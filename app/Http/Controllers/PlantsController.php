<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 
        $plant = Plant::all();
        return response() ->json([
            'status' => 200,
            'message' => 'success',
            'data' => $plant
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'description' => 'required',
            'prix' => 'required',
            'image' => 'required|image|mimes:jpeg,png',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $validator->errors(),
            ], 400);
        }
    
        $imagePath = $request->file('image')->store('public/images');
        $imageName = $request->file('image')->hashName();
    
        $plant = new Plant();
        $plant->nom = $request->input('nom');
        $plant->description = $request->input('description');
        $plant->prix = $request->input('prix');
        $plant->image = $imageName;
        $plant->save();
    
        return response()->json([
            'success' => true,
            'data' => $plant,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Plant $plant)
    {
        //
        $plant  = Plant::find($plant);
        if (!$plant) {
            return response()->json([
                'error' => 'Plant not found',
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $plant,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plant $plant)
    {
    

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $plant = Plant::find($id);
        if (!$plant) {
            return response()->json([
                'error' => 'Plant not found',
            ], 404);
        }
        
        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'description' => 'required',
            'prix' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $validator->errors(),
            ], 400);
        }
        
        $plant->nom = $request->input('nom');
        $plant->description = $request->input('description');
        $plant->prix = $request->input('prix');
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images');
            $imageName = $request->file('image')->hashName();
            $plant->image = $imageName;
        }
        
        $plant->save();
        
        return response()->json([
            'success' => true,
            'data' => $plant,
        ], 200);
        }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $plant = Plant::find($id);
        if (!$plant) {
            return response()->json([
                'error' => 'Plant not found',
            ], 404);
        }
        
        $plant->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Plant deleted successfully',
        ], 200);
    }
}
