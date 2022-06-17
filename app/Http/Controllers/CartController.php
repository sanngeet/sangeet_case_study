<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Cart::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sessionId' => 'required',
            'productId' => "required",
            'quantity' => 'required'
        ]);


        $sessionId = $request->sessionId;
        $productId = $request->productId;
        $userId = $request->userId ? $request->userId : false;

        $db = DB::table('cart')
        ->where('productId', $productId);

        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $recordExists = $db->count();

        if($recordExists){
            $response = array(
                'message' => 'Item already added to the cart.'
            );
            return response()->json($response, 400);
        }else{
            return Cart::create($request->all());
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
        return Cart::find($id);
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
        $cart = Cart::find($id);
        $request->request->set('updated', date('Y-m-d H:i:s'));
        $cart->update($request->all());
        return $cart;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Cart::destroy($id);
    }

     /**
     * Search by sessionId.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($id)
    {
        return Cart::where('sessionId', $id)->get();
    }
}
