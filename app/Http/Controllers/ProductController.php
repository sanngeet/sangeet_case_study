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
            'categoryId' => 'required|numeric|max:8',
            'name' => "required|string|unique:products,name",
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'avatar' => 'required|string',
            'developerEmail' => 'required|email:rfc'
        ]);

        // Create new product 
        $product = Product::create($request->all());

        return DB::table('products as p')
        ->select('p.*','c.name as categoryName')
        ->Join('categories as c', 'c.id', '=', 'p.categoryId')
        ->where('p.id', $product->id)
        ->first();
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

         if(!$product){
            return response()->json(['message' => 'Invalid Id'], 400);
         }

         // Validate request
         $request->validate([
            'categoryId' => 'required|numeric|max:8',
            'name' => "required|string|unique:products,name,".$id,
            'price' => 'required|numeric|min:1',
            'description' => 'required|string',
            'avatar' => 'required|string',
            'developerEmail' => 'required|email:rfc|max:320'
        ]);

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
            $response = array('message' => 'Item deleted');
            $statusCode = 200;
        }else{
            $response = array('message' => 'No record found');
            $statusCode = 400;
        }
        return response()->json($response, $statusCode);
    }
}
