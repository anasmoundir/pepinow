<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class manageAccounts extends Controller
{
    public function makeAdmin(Request $request, $id)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()[0];
        if($role == 'admin' )
        {   
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $role = $user->getRoleNames()[0];
        if ($role != 'admin') {
            $user->syncRoles('admin'); // override all current roles and assign admin role only
            $user->update();
            return response()->json(['user' => $user]);
        }
        else {
            return response()->json(['error' => 'User is already an admin'], 401);
        }}
        else{
            return response()->json(['error' => 'You are not an admin'], 401);
        }
    }
    

    public function makeSeller(Request $request, $id)
    {
    
        $user = auth()->user();
        $role = $user->getRoleNames()[0];
        if($role == 'admin' )
        {   
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        $role = $user->getRoleNames()[0];
       
      
        if ($role != 'seller') {
            $user->assignRole('seller');
            $user->update();
            return response()->json(['user' => $user]);
        }
        else {
            return response()->json(['error' => 'User is already a seller'], 401);
        }
    }
    else{
        return response()->json(['error' => 'You are not an admin'], 401);
    }
    }
} 
