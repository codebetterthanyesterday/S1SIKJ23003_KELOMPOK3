<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;

class UserController extends Controller
{
    protected $userModel;
    protected $roleModel;
    protected $activityLogModel;
    protected $authenticatedUser;

    public function __construct()
    {
        $this->authenticatedUser = Auth::user();
        $this->userModel = User::class;
        $this->roleModel = Role::class;
        $this->activityLogModel = ActivityLog::class;
    }

    public function getCreationPage(Request $request, $getEntity)
    {
        $entity = $request->query('entity', $getEntity);
        $title = "Create User";
        $description = "Add a new user to the system.";
        return view('Pages.Admin.Creation', compact('entity', 'title', 'description'));
    }

    public function create(Request $request, $getEntity)
    {
        // Jika ada file import, proses import
        if ($request->hasFile('import_file')) {
            $request->validate([
                'import_file' => 'required|mimes:xlsx,csv,xls|max:10240'
            ], [
                'import_file.mimes' => 'Format file harus .xls, .xlsx, atau .csv',
                'import_file.max' => 'Maksimal ukuran file 10MB',
            ]);

            try {
                $import = new UserImport($this->roleModel, $this->userModel);
                Excel::import($import, $request->file('import_file'));

                // Log aktivitas
                if ($this->authenticatedUser) {
                    $this->activityLogModel::create([
                        "id_user" => $this->authenticatedUser->id_user,
                        "action" => "import",
                        "entity" => "user",
                        "notes" => "User {$this->authenticatedUser->username} melakukan import user"
                    ]);
                }

                $successCount = $import->getSuccessCount();
                $errors = $import->getErrors();

                $msg = "$successCount user berhasil diimport.";
                if ($errors) {
                    $msg .= " Beberapa baris gagal: " . implode('; ', $errors);
                }
                return redirect()->route('admin.creation', $getEntity)
                    ->with('success', $msg);
            } catch (\Exception $e) {
                return redirect()->route('admin.creation', $getEntity)
                    ->with('error', 'Gagal import: ' . $e->getMessage());
            }
        }

        // Jika input manual
        $data = $request->validate([
            'email_address' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:customer,seller,admin',
        ]);

        $user = $this->userModel::create([
            'email' => $data['email_address'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        $user->roles()->attach(
            $this->roleModel::where('role_name', $data['role'])->first()->id_role
        );

        $this->activityLogModel::create([
            "id_user" => $this->authenticatedUser->id_user,
            "action" => "create",
            "entity" => "user",
            "target_id" => $user->id_user,
            "notes" => "User {$this->authenticatedUser->username} created user {$user->username}"
        ]);

        return redirect()->route('admin.creation', $getEntity)
            ->with('success', Str::ucfirst($getEntity) . " created successfully.");
    }
}
