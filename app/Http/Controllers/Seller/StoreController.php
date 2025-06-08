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

    protected $authenticatedUser;
    protected $storeModel;
    protected $activityLogModel;
    protected $roleModel;

    public function __construct()
    {
        $this->authenticatedUser = Auth::user();
        $this->storeModel = Store::class;
        $this->activityLogModel = ActivityLog::class;
        $this->roleModel = Role::class;
    }

    public function index()
    {
        $stores = $this->storeModel::where('id_user', $this->authenticatedUser->id_user)->get();
        return view('Pages.Seller.MyStores', compact('stores'));
    }

    public function show(Store $store)
    {
        $store->load('products');
        return view('Pages.Seller.ShowStore', compact('store'));
    }

    public function createStore()
    {
        $maxReached = $this->authenticatedUser->stores()->count() >= 5;
        return view('Pages.Seller.StoreCreation', compact('maxReached'));
    }

    public function openStore(Request $request)
    {
        // Batasi user hanya bisa memiliki maksimal 5 toko
        if ($this->authenticatedUser->stores()->count() >= 5) {
            return redirect()->back()->with('error', 'Anda hanya dapat memiliki maksimal 5 toko.');
        }

        // Pastikan ada role seller & attach ke user
        $this->authenticatedUser->roles()->syncWithoutDetaching($this->roleModel::firstOrCreate(['role_name' => 'seller'])->id_role);

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
            $path = $request->file('store_logo')->store('store_logos', 'public');
            $data['store_logo'] = basename($path);
        }

        // Upload banner via storage disk
        if ($request->hasFile('store_banner')) {
            $path = $request->file('store_banner')->store('store_banners', 'public');
            $data['store_banner'] = basename($path);
        }

        // Simpan store
        $store = $this->authenticatedUser->stores()->create($data);

        // Catat activity
        $this->activityLogModel::create([
            'id_user'   => $this->authenticatedUser->id_user,
            'action'    => 'create',
            'entity'    => 'store',
            'target_id' => $store->id_store,
            'notes'     => "User {$this->authenticatedUser->username} opened store \"{$store->store_name}\"",
        ]);

        return redirect()->back()
            ->with('success', 'Toko berhasil dibuka!');
    }

    public function updateStore(Request $request, $id_store)
    {

        $store = $this->authenticatedUser->stores()->where('id_store', $id_store)->firstOrFail();

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
            'id_user'   => $this->authenticatedUser->id_user,
            'action'    => 'update',
            'entity'    => 'store',
            'target_id' => $store->id_store,
            'notes'     => "User {$this->authenticatedUser->username} updated store \"{$store->store_name}\"",
        ]);

        return redirect()
            ->route('sellerdashboard')
            ->with('success', 'Toko berhasil diperbarui!');
    }

    public function deleteStore($id_store)
    {

        $store = $this->authenticatedUser->stores()->where('id_store', $id_store)->firstOrFail();

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
            'id_user'   => $this->authenticatedUser->id_user,
            'action'    => 'delete',
            'entity'    => 'store',
            'target_id' => $store->id_store,
            'notes'     => "User {$this->authenticatedUser->username} deleted store \"{$store->store_name}\"",
        ]);

        return redirect()
            ->route('seller.stores.list')
            ->with('success', 'Toko berhasil dihapus!');
    }

    public function edit(Store $store)
    {
        return view('Pages.Seller.StoreEdit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'store_name'    => 'required|string|max:100',
            'store_logo'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'store_banner'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'store_address' => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'store_status'  => 'required|in:active,inactive',
        ]);

        // Update store_logo jika ada file baru
        if ($request->hasFile('store_logo')) {
            if ($store->store_logo && Storage::disk('public')->exists($store->store_logo)) {
                Storage::disk('public')->delete($store->store_logo);
            }
            $path = $request->file('store_logo')->store('store_logos', 'public');
            $validated['store_logo'] = basename($path);
        }

        // Update store_banner jika ada file baru
        if ($request->hasFile('store_banner')) {
            if ($store->store_banner && Storage::disk('public')->exists($store->store_banner)) {
                Storage::disk('public')->delete($store->store_banner);
            }
            $path = $request->file('store_banner')->store('store_banners', 'public');
            $validated['store_banner'] = basename($path);
        }

        $store->update($validated);

        return redirect()->route('seller.store.show', $store->id_store)
            ->with('success', 'Store updated successfully!');
    }
}
