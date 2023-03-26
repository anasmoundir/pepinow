<?php


namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plants = Plant::all();
        return response()->json(['plants' => $plants]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $user = auth()->user();
    $role = $user->getRoleNames()[0];

    if ($role == 'admin' || $role == 'seller') {
        
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            
        ]);

        $plant = new Plant();
        $plant->nom = $validatedData['nom'];
        $plant->description = $validatedData['description'];
        $plant->prix = $validatedData['prix'];
   

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $plant->image = $imageName;
        }

        $plant->save();

        return response()->json(['plant' => $plant], 201);
    } else {
        return response()->json(['error' => 'you dont have the permission'], 403);
    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function show(Plant $plant)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()[0];

        if ($role == 'admin' || $role == 'seller' || $plant->is_published) {
            return response()->json(['plant' => $plant]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plant  $plant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()[0];
    
        if ($role == 'admin' || $role == 'seller') {
            
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'prix' => 'required|numeric',
                'image' => 'nullable|image|max:2048',
            ]);
    
            $plant = Plant::findOrFail($id);
    
            // check if the authenticated user has the necessary permission to update the plant
            if ($role == 'admin' || ($role == 'seller' && $plant->seller_id == $user->id)) {
                $plant->nom = $validatedData['nom'];
                $plant->description = $validatedData['description'];
                $plant->prix = $validatedData['prix'];
                
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images'), $imageName);
                    $plant->image = $imageName;
                }
    
                $plant->save();
    
                return response()->json(['plant' => $plant], 200);
            } else {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }

    public function destroy(Plant $plant)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()[0];

        if ($role != 'admin' && $role != 'seller') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $plant->delete();

        return response()->json(['message' => 'Plant deleted']);
    }

}
