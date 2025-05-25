<?php

namespace App\Http\Controllers\Seller;
use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\Store;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{

    protected $userModel;
    protected $storeModel;
    protected $activityLogModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = Auth::user();
        $this->storeModel = Store::class;
        $this->activityLogModel = ActivityLog::class;
        $this->roleModel = Role::class;
    }

    public function openStore(Request $request)
    {

        // Pastikan ada role seller & attach ke user
        $this->userModel->roles()->syncWithoutDetaching($this->roleModel::firstOrCreate(['role_name' => 'seller'])->id_role);

        // Validasi input
        $data = $request->validate([
            'store_name'    => 'required|string|max:100',
            'description'   => 'required|string',
            'store_address' => 'required|string',
        ]);

        // Buat slug unik
        $base = Str::slug($data['store_name']);
        $slug = $base;
        $i = 1;
        while ($this->storeModel::where('slug', $slug)->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }
        $data['slug'] = $slug;

        // upload logo via storage disk
        if ($request->hasFile('store_logo')) {
            $data['store_logo'] = $request->file('store_logo')
                ->store('logos', 'public');
        }

        // Upload banner via storage disk
        if ($request->hasFile('store_banner')) {
            $data['store_banner'] = $request->file('store_banner')
                ->store('banners', 'public');
        }

        // Simpan store
        $store = $this->userModel->stores()->create($data);

        // Catat activity
        $this->activityLogModel::create([
            'id_user'   => $this->userModel->id_user,
            'action'    => 'create',
            'entity'    => 'store',
            'target_id' => $store->id_store,
            'notes'     => "User {$this->userModel->username} opened store \"{$store->store_name}\"",
        ]);

        return redirect()
            ->route('sellerdashboard')
            ->with('success', 'Toko berhasil dibuka!');
    }

    public function updateStore(Request $request, $id_store)
    {

        $store = $this->userModel->stores()->where('id_store', $id_store)->firstOrFail();

        $data = $request->validate([
            'store_name'    => 'required|string|max:100',
            'description'   => 'required|string',
            'store_address' => 'required|string',
            'store_logo'    => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'store_banner'  => 'nullable|image|mimes:jpeg,png,jpg,svg|max:4096',
        ]);

        // Update slug if store_name changed
        if ($data['store_name'] !== $store->store_name) {
            $base = Str::slug($data['store_name']);
            $slug = $base;
            $i = 1;
            while ($this->storeModel::where('slug', $slug)->where('id_store', '!=', $store->id_store)->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }
            $data['slug'] = $slug;
        }

        if ($request->hasFile('store_logo')) {
            $data['store_logo'] = $request->file('store_logo')->store('logos', 'public');
        }

        if ($request->hasFile('store_banner')) {
            $data['store_banner'] = $request->file('store_banner')->store('banners', 'public');
        }

        $store->update($data);

        $this->activityLogModel::create([
            'id_user'   => $this->userModel->id_user,
            'action'    => 'update',
            'entity'    => 'store',
            'target_id' => $store->id_store,
            'notes'     => "User {$this->userModel->username} updated store \"{$store->store_name}\"",
        ]);

        return redirect()
            ->route('sellerdashboard')
            ->with('success', 'Toko berhasil diperbarui!');
    }

    public function deleteStore($id_store)
    {

        $store = $this->userModel->stores()->where('id_store', $id_store)->firstOrFail();

        // Hapus logo dan banner dari storage
        if ($store->store_logo) {
            Storage::disk('public')->delete($store->store_logo);
        }
        if ($store->store_banner) {
            Storage::disk('public')->delete($store->store_banner);
        }

        // Hapus store
        $store->delete();

        $this->activityLogModel::create([
            'id_user'   => $this->userModel->id_user,
            'action'    => 'delete',
            'entity'    => 'store',
            'target_id' => $store->id_store,
            'notes'     => "User {$this->userModel->username} deleted store \"{$store->store_name}\"",
        ]);

        return redirect()
            ->route('sellerdashboard')
            ->with('success', 'Toko berhasil dihapus!');
    }
}
