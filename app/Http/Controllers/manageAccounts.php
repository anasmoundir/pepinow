<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class manageAccounts extends Controller
{
    //
    public function makeAdmin(Request $request, $id)
{
  
    $user = User::findOrFail($id);

    // Check if the user already has the admin role
    if ($user->hasRole('admin')) {
        return response()->json(['error' => 'User is already an admin'], 401);
    }

    // Assign the admin role to the user
    $adminRole = Role::where('name', 'admin')->first();
    $user->assignRole($adminRole);

    $user->save();

    return response()->json(['user' => $user]);
}

public function makeSeller(Request $request, $id)
{
    
    $user = User::find($id);
    
    if($user->hasRole('customer'))
    {
        echo 'hi';
    };
    $role = $user->getRoleNames()[0];
   
    echo $role;
    // Check if the user already has the seller role
    if ($user->hasRole('seller')) {
        return response()->json(['error' => 'User is already a seller'], 401);
    }

    // Assign the seller role to the user
    $sellerRole = Role::where('name', 'seller')->first();
    $user->assignRole($sellerRole);

    $user->save();

    return response()->json(['user' => $user]);
}
}
