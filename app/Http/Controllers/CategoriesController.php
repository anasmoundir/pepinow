<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
         $categorie = Categorie::all();
        return response() ->json([
            'status' => 200,
            'message' => 'success',
            'data' => $categorie
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
        //
        $input = $request->all();
        $validator = validator ::make(
            [
                'name' =>'required',
            ]
        );
        if($validator ->fails())
        {
            return $this->sendError('error validation', $validator->errors());
        }
        $categorie = Categorie::create($input);
        return response() ->json([
            'status' => 200,
            'message' => 'success',
            'data' => $categorie
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
        $categorie = Categorie::find($id);
        if(is_null)
        {
            return $this ->sendError('categorie not found');
        }
        return response() ->json([
            'status' => 200,
            'message' => 'success',
            'data' => $categorie
        ]);        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        //
        $input =$request->all();
        validator::make(
            [
                'name' => 'required',
            ]
        );
        if(validator->fails())
        {
            return $this->sendError('error validation', $validator->errors());
        }
        $categorie->name = $input['name'];
        return response() ->json([
            'status' => 200,
            'message' => 'success',
            'data' => $categorie
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        //
        $categorie  ->delete();
        return response() ->json([
            'status' => 200,
            'message' => 'deleted succefuly',
            'data' => $categorie
        ]);
    }
}
