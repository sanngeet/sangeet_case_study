<?php

namespace App\Http\Controllers;

use Auth;
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
        $userId = null;
        $sessionId = $request->header('X-AUTH-TOKEN', null);

        // Get userId from the bearerToken
        if($request->bearerToken()){
            $token = $request->bearerToken();
            $v = DB::table('personal_access_tokens')->where('id', $token)->first();
            $userId = DB::table('users')->select('id')->where('id', $v->tokenable_id)->first()->id;
        }

        if(!$userId && !$sessionId){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 400);
        }

        $db = DB::table('cart');
        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $cart = $db->get();

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
        $userId = null;

        // Validate request
        $request->validate([
            'productId' => "required",
            'quantity' => 'required'
        ]);

        // Get userId from the bearerToken
        if($request->bearerToken()){
            $token = $request->bearerToken();
            $v = DB::table('personal_access_tokens')->where('id', $token)->first();
            $userId = DB::table('users')->select('id')->where('id', $v->tokenable_id)->first()->id;
        }
        $sessionId = $request->header('X-AUTH-TOKEN', null);
        $productId = $request->productId;

        if(!$userId && !$sessionId){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 400);
        }

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
            $request->request->set('sessionId', $sessionId);
            $request->request->set('userId', $userId);
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

        // Get userId from the bearerToken
        if($request->bearerToken()){
            $token = $request->bearerToken();
            $v = DB::table('personal_access_tokens')->where('id', $token)->first();
            $userId = DB::table('users')->select('id')->where('id', $v->tokenable_id)->first()->id;
        }

        $sessionId = $request->header('X-AUTH-TOKEN', 0);

        $db = Cart::where('id',$id);
        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $cart = $db->first();

        if(!$cart){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 400);
        }

        $request->request->set('sessionId', $sessionId);
        $request->request->set('userId', $userId);
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
        $sessionId = $request->header('X-AUTH-TOKEN', null);

        // Get userId from the bearerToken
        if($request->bearerToken()){
            $token = $request->bearerToken();
            $v = DB::table('personal_access_tokens')->where('id', $token)->first();
            $userId = DB::table('users')->select('id')->where('id', $v->tokenable_id)->first()->id;
        }

        if(!$userId && !$sessionId){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 400);
        }

        $db = DB::table('cart');
        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $cart = $db->first();

        if(!$cart){
            $response = array(
                'message' => 'Invalid Request'
            );
            return response()->json($response, 400);
        }
        
        return Cart::destroy($id);
    }

    public function userdata(){
        $id = auth()->guard('agent')->user()->id; // just id
        return $id;
     }
}
