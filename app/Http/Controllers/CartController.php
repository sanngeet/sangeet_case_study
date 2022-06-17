<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class CartController extends Controller
{
    /**
     * List cart items by sessionId or userId.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sessionId = $request->header('X-AUTH-TOKEN', 0);
        $cart = DB::table('cart')->where('sessionId', $sessionId)->get();

        if(!$cart){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 200);
        }

        return $cart;
    }

    /**
     * Store a newly created resource in storage
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
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
     * Update the specified cart item quantity in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        // Validate request
        $request->validate([
            'quantity' => 'required'
        ]);

        $sessionId = $request->header('X-AUTH-TOKEN', 0);

        $cart = Cart::where('id',$id)
        ->where('sessionId', $sessionId)
        ->first();

        if(!$cart){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 400);
        }

        $request->request->set('updated', date('Y-m-d H:i:s'));
        $cart->update($request->all());
        return $cart;
    }

    /**
     * Remove the specified cart item from storage.
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $sessionId = $request->header('X-AUTH-TOKEN', 0);

        $cart = Cart::where('id',$id)
        ->where('sessionId', $sessionId)
        ->first();

        if(!$cart){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 400);
        }
        
        return Cart::destroy($id);
    }
}
