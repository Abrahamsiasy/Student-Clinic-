<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Pharmacy;
use App\Models\PharmacyUser;
use App\Models\Store;
use App\Models\StoreUser;
use Spatie\Permission\Models\Permission;

require_once app_path('Helper/constants.php');
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', User::class);

        $search = $request->get('search', '');

        $users = User::search($search)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('app.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', User::class);

        $roles = Role::get();

        return view('app.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user = User::create($validated);

        $user->syncRoles($request->roles);

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user): View
    {
        $this->authorize('view', $user);
        $roles = Role::all();
        $permissions = Permission::all();

        return view('app.users.show', compact('user','roles','permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user): View
    {
        $this->authorize('update', $user);

        $roles = Role::get();

        return view('app.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UserUpdateRequest $request,
        User $user
    ) {

        // ): RedirectResponse {
        // dd($request->roles);
        if (in_array(Constants::PHARMACY_USER_ROLE_ID, $request->roles) and in_array(Constants::STORE_USER_ROLE_ID, $request->roles)) {
            return redirect()->back()->with('error', 'Store user and Pharmacy user can\'t be assigned simultaneously');
        }
        $this->authorize('update', $user);

        $validated = $request->validated();

        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);


        $user->syncRoles($request->roles);

        if (in_array(Constants::PHARMACY_USER_ROLE_ID, $request->roles)) {
            $pharmacy = true;
            $pharmacies = Pharmacy::pluck('name', 'id');


            return view('app.roles.assignPlaceForPharmacyOrStore', compact('pharmacy', 'pharmacies', 'user'));
        } elseif (in_array(Constants::STORE_USER_ROLE_ID, $request->roles)) {
            $pharmacy = false;
            $stores = Store::pluck('name', 'id');


            return view('app.roles.assignPlaceForPharmacyOrStore', compact('pharmacy', 'stores', 'user'));
        }

        return redirect()
            ->route('users.edit', $user)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->withSuccess(__('crud.common.removed'));
    }


    public function updateRoleAndPermission(User $user, Request $request)
    {

        $data['permissions'] = null;
        $data = $request->validate([
            'role' => 'nullable',
            'input_permissions' => 'nullable',
        ]);
        $userRoles = $user->roles;
        foreach ($userRoles as $userRole) {
            $user->removeRole($userRole->name);
        }
        $user->assignRole($data['role']);

        $directPermissions = $user->getAllPermissions();
        foreach ($directPermissions as $key => $directPermission) {
            $user->revokePermissionTo($directPermission->name);
        }
        if (array_key_exists('input_permissions', $data)) {
            foreach ($data['input_permissions'] as $permission) {
                if ($permission == null)
                    continue;
                $permissionName = Permission::findById($permission)->name;
                if ($user->hasPermissionTo($permissionName) == false)
                    $user->givePermissionTo($permissionName);
            }
        }
        return redirect()->back()->with('success', 'User role and permission updated successfully');
    }

    public function assignPharamacyPlace(Request $request, Pharmacy $pharmacy, User $user)
    {
        PharmacyUser::where('user_id', $user->id)->delete();
        $pharmacyUser = PharmacyUser::create([
            'user_id' => $user->id,
            'pharmacy_id' => $request->pharmacy_id
        ]);
        return redirect()
            ->back()
            ->withSuccess(__('User has been assigned to Pharmacy'));
    }

    public function assignStorePlace(Request $request, Store $store, User $user)
    {
        StoreUser::where('user_id', $user->id)->delete();
        $storeUser = StoreUser::create([
            'user_id' => $user->id,
            'store_id' => $request->store_id
        ]);
        return redirect()
            ->back()
            ->withSuccess(__('User has been assigned to Store'));
    }

    public function store_users(Request $request)
    {

        $storeUsersWithStore = User::whereHas('roles', function ($query) {
            $query->where('name', Constants::STORE_USER_ROLE); // Adjust 'name' based on your actual column
        })
        ->with('storeUser.store')
            ->latest()
            ->paginate(10)
            ->withQueryString();





            return view('app.store_and_pharmacy_users.store', compact('storeUsersWithStore', ));


    }
    public function pharmacy_users(Request $request)
    {



        $pharmacyUsersWithPharmacy = User::whereHas('roles', function ($query) {
            $query->where('name', Constants::PHARMACY_USER);
        })
            ->with('pharmacyUsers.pharmacy') // Eager load the relationship
            ->latest()
            ->paginate(10)
            ->withQueryString();


        return view('app.store_and_pharmacy_users.pharmacy', compact('pharmacyUsersWithPharmacy'));


    }

    public function assignPharmacyView(User $user){
        $pharmacies = Pharmacy::pluck('name', 'id');


        return view('app.store_and_pharmacy_users.assign_pharmacy', compact( 'pharmacies', 'user',));


    }




    public function assignStoreView(User $user){


        $stores = Store::pluck('name', 'id');


        return view('app.store_and_pharmacy_users.assign_store', compact( 'stores', 'user'));


    }
    public function assignPharmacy(Request $request, Pharmacy $pharmacy, User $user)
    {
        PharmacyUser::where('user_id', $user->id)->delete();
        $pharmacyUser = PharmacyUser::create([
            'user_id' => $user->id,
            'pharmacy_id' => $request->pharmacy_id
        ]);
        return redirect()
            ->route('store_and_pharmacy_users.pharmacy')
            ->withSuccess(__('User has been assigned to Pharmacy'));
    }

    public function assignStore(Request $request, Store $store, User $user)
    {
        // dd($request);

        StoreUser::where('user_id', $user->id)->delete();
        $storeUser = StoreUser::create([
            'user_id' => $user->id,
            'store_id' => $request->store_id
        ]);
        return redirect()
            ->route('store_and_pharmacy_users.store')
            ->withSuccess(__('User has been assigned to Store'));
    }
}
