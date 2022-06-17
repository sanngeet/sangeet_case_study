<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::table('products as p')
        ->select('p.*', 'c.name as categoryName')
        ->Join('categories as c', 'c.id', '=', 'p.categoryId')
        ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'categoryId' => 'required',
            'name' => "required",
            'price' => 'required',
            'description' => 'required',
            'avatar' => 'required',
            'developerEmail' => 'required'
        ]);

        // Check if product with same name already exists in the database
        $recordExists = Product::where('name', $request->name)->count();
        if($recordExists){
            $response = array(
                'message' => 'Product already exists.'
            );
            return response()->json($response, 400);
        }else{  
            // Create new product if the name is unique
            $product = Product::create($request->all());

            return DB::table('products as p')
            ->select('p.*','c.name as categoryName')
            ->Join('categories as c', 'c.id', '=', 'p.categoryId')
            ->where('p.id', $product->id)
            ->get();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::table('products as p')
        ->select('p.*','c.name as categoryName')
        ->where('p.id', $id)
        ->Join('categories as c', 'c.id', '=', 'p.categoryId')
        ->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Get the product by ID
        $product = Product::find($id);

        // Add updated field in the request body
        $request->request->set('updated', date('Y-m-d H:i:s'));

        $product->update($request->all());

        return DB::table('products as p')
        ->select('p.*','c.name as categoryName')
        ->where('p.id', $id)
        ->Join('categories as c', 'c.id', '=', 'p.categoryId')
        ->get();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = Product::destroy($id);
        if($deleted){
            $response = array(
                'message' => 'Item deleted'
            );
            $statusCode = 200;
        }else{
            $response = array(
                'message' => 'No record found'
            );
            $statusCode = 400;
        }
        return response()->json($response, $statusCode);
    }
}
