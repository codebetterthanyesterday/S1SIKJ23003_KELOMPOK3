<?php

namespace App\Imports;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    private $roleModel, $userModel;
    private $errors = [];
    private $successCount = 0;

    public function __construct($roleModel, $userModel)
    {
        $this->roleModel = $roleModel;
        $this->userModel = $userModel;
    }

    public function model(array $row)
    {
        if (!isset($row['email']) || !isset($row['username']) || !isset($row['password']) || !isset($row['role'])) {
            $this->errors[] = "Format kolom tidak sesuai template.";
            return null;
        }

        if (!filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Email {$row['email']} tidak valid.";
            return null;
        }
        if ($this->userModel::where('email', $row['email'])->exists()) {
            $this->errors[] = "Email {$row['email']} sudah terdaftar.";
            return null;
        }
        if ($this->userModel::where('username', $row['username'])->exists()) {
            $this->errors[] = "Username {$row['username']} sudah terdaftar.";
            return null;
        }
        if (strlen($row['password']) < 8) {
            $this->errors[] = "Password untuk {$row['email']} kurang dari 8 karakter.";
            return null;
        }

        $user = $this->userModel::create([
            'email' => $row['email'],
            'username' => $row['username'],
            'password' => Hash::make($row['password']),
        ]);

        $role = $this->roleModel::where('role_name', strtolower($row['role']))->first();
        if ($role) {
            $user->roles()->attach($role->id_role);
        } else {
            $this->errors[] = "Role '{$row['role']}' tidak ditemukan untuk email {$row['email']}.";
        }

        $this->successCount++;
        return null;
    }

    public function getErrors()
    {
        return $this->errors;
    }
    public function getSuccessCount()
    {
        return $this->successCount;
    }
}
