<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
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
            return Product::create($request->all());
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
        return Product::find($id);
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
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }
}
