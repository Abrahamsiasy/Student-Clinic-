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

        return view('app.users.show', compact('user'));
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
        if (in_array(Constants::PHARMACY_USER_ROLE_ID, $request->roles) and  in_array(Constants::STORE_USER_ROLE_ID, $request->roles)) {
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
            $pharmacies = Pharmacy::pluck('name', 'id');;

            return view('app.roles.assignPlaceForPharmacyOrStore', compact('pharmacy', 'pharmacies', 'user'));
        } elseif (in_array(Constants::STORE_USER_ROLE_ID, $request->roles)) {
            $pharmacy = false;
            $stores = Store::pluck('name', 'id');;

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

    public function assignPharamacyPlace(Request $request, Pharmacy $pharmacy, User $user)
    {
        $pharmacyUser = PharmacyUser::create([
            'user_id' => $user->id,
            'pharmacy_id' => $request->pharmacy_id
        ]);
        return redirect()
            ->route('users.index', $user)
            ->withSuccess(__('User has been assigned to Pharmacy'));
    }

    public function assignStorePlace(Request $request, Store $store, User $user)
    {
        $storeUser = StoreUser::create([
            'user_id' => $user->id,
            'store_id' => $request->store_id
        ]);
        return redirect()
            ->route('users.index', $user)
            ->withSuccess(__('User has been assigned to Store'));
    }



    public function store_and_pharmacy_users(Request $request){

        $store_users = User::whereHas('roles', function ($query) {
            $query->where('name', Constants::STORE_USER_ROLE); // Adjust 'name' based on your actual column
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

        dd($store_users[0]->storeUser());
        $pharmacy_users = User::whereHas('roles', function ($query) {
            $query->where('name', Constants::PHARMACY_USER); // Adjust 'name' based on your actual column
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();



        return view('app.store_and_pharmacy_users.index',compact('store_users','pharmacy_users'));


    }
}
