<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;




class CategoriesController extends Controller
{

    protected function sendError($message, $errors = null)
{
    $response = [
        'status' => 'error',
        'message' => $message,
    ];
    if (!is_null($errors)) {
        $response['errors'] = $errors;
    }
    return response()->json($response, 422);
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $user = auth()->user();
        $role = $user->getRoleNames()[0];
        if($role == 'admin' )
        {   
            $categorie = Categorie::all();
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $categorie
            ]);
        }
        else {
            return response()->json([
                'status' => 403,
                'message' => 'forbidden',
            ]);
        }
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
        $user = auth()->user();
        $role = $user->getRoleNames()[0];

        if ($role == 'admin') {
        $input = $request->all();
    
        $validator = Validator::make($input, [
            'nom' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('error validation', $validator->errors());
        }
        $categorie = Categorie::create($input);
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $categorie
        ]);
    }
    else {
        return response()->json([
            'status' => 403,
            'message' => 'forbidden',
        ]);
    }
}
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();
        $role = $user->getRoleNames()[0];
        if($role == 'admin' )
        {
            $categorie = Categorie::find($id);
            if (is_null($categorie)) {
                return $this->sendError('categorie not found');
            }
            return response()->json([
                'status' => 200,
                'message' => 'success',
                'data' => $categorie
            ]);        
        }
        else {
            return response()->json([
                'status' => 403,
                'message' => 'forbidden',
            ]);
        }        
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
    public function update(Request $request, $id)
{
    // find the category by ID
    $use = auth()->user();
    $role = $user->getRoleNames()[0];
    echo $role;
    if ($role == 'admin') {
    $categorie = Categorie::find($id);
    
    // check if category exists
    if (!$categorie) {
        return response()->json([
            'status' => 'error',
            'message' => 'category not found',
        ], 404);
    }
    
    // validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'required',
    ]);
    
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'validation error',
            'errors' => $validator->errors(),
        ], 422);
    }
    
    // update the category
    $categorie->update([
        'name' => $request->input('name'),
    ]);
    
    return response()->json([
        'status' => 'success',
        'message' => 'category updated successfully',
        'data' => $categorie,
    ]); 
}
    else {
        return response()->json([
            'status' => 403,
            'message' => 'forbidden',
        ]);
    }
}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if ($role == 'admin') {
        $categorie = Categorie::find($id);
        $categorie  ->delete();
        return response() ->json([
            'status' => 200,
            'message' => 'deleted succefuly',
            'data' => $categorie
        ]);}else{
            return response()->json([
                'status' => 403,
                'message' => 'forbidden',
            ]);}
    }
}
