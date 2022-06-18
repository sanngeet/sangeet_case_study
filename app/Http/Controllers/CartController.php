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
            $accessTokenRecord = DB::table('personal_access_tokens')->where('id', $token)->first();
            if($accessTokenRecord){
                $userId = DB::table('users')->select('id')->where('id', $accessTokenRecord->tokenable_id)->first()->id;
            }
        }

        // Return Error if userId and sessionId are missing
        if(!$userId && !$sessionId){
            $response = array('message' => 'Invalid Request');
            return response()->json($response, 400);
        }

        // Get cart items based on userId or sessionId
        $db = DB::table('cart');
        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $cart = $db->get();

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
        $sessionId = $request->header('X-AUTH-TOKEN', null);

        // Validate request
        $request->validate([
            'productId' => "required|numeric",
            'quantity' => 'required|numeric|min:1|max:10'
        ]);

        // Get userId from the bearerToken
        if($request->bearerToken()){
            $token = $request->bearerToken();
            $accessTokenRecord = DB::table('personal_access_tokens')->where('id', $token)->first();
            if($accessTokenRecord){
                $userId = DB::table('users')->select('id')->where('id', $accessTokenRecord->tokenable_id)->first()->id;
            }
        }
        $productId = $request->productId;

        // Return Error if userId and sessionId are missing
        if(!$userId && !$sessionId){
            $response = array('message' => 'Invalid Request');
            return response()->json($response, 400);
        }

        // Get cart item based on cart id and (userId or sessionId)
        $db = DB::table('cart')
        ->where('productId', $productId);

        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $recordExists = $db->count();

        // Throw error if productId+userId or productId+sessionId are already present
        // These records can only be updated, can't be created again
        if($recordExists){
            $response = array('message' => 'Item already added to the cart.');
            return response()->json($response, 400);
        }else{
            // Create new cart item
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
        $userId = null;
        $sessionId = $request->header('X-AUTH-TOKEN', null);

        // Validate request
        $request->validate(['quantity' => 'required|numeric|min:1|max:10']);

        // Get userId from the bearerToken
        if($request->bearerToken()){
            $token = $request->bearerToken();
            $accessTokenRecord = DB::table('personal_access_tokens')->where('id', $token)->first();
            if($accessTokenRecord){
                $userId = DB::table('users')->select('id')->where('id', $accessTokenRecord->tokenable_id)->first()->id;
            }
        }

        // Return Error if userId and sessionId are missing
        if(!$userId && !$sessionId){
            $response = array('message' => 'Invalid Request');
            return response()->json($response, 400);
        }

        // Get cart item based on cart id and (userId or sessionId)
        $db = Cart::where('id',$id);
        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $cart = $db->first();

        // Return Error if no cart is found
        if(!$cart){
            $response = array('message' => 'Invalid Request');
            return response()->json($response, 400);
        }

        // Update quantity of the item along with 
        //sessionId (if present), userId(if present) & datetime
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
        $userId = null;
        $sessionId = $request->header('X-AUTH-TOKEN', null);

        // Get userId from the bearerToken
        if($request->bearerToken()){
            $token = $request->bearerToken();
            $accessTokenRecord = DB::table('personal_access_tokens')->where('id', $token)->first();
            if($accessTokenRecord){
                $userId = DB::table('users')->select('id')->where('id', $accessTokenRecord->tokenable_id)->first()->id;
            }
        }

         // Return Error if userId and sessionId are missing
        if(!$userId && !$sessionId){
            $response = array('message' => 'Invalid Request');
            return response()->json($response, 400);
        }

        // Get cart item based on cart id & (userId or sessionId)
        // Use id and (userId or sessionId) to make sure only the authorized user deletes the items
        $db = Cart::where('id',$id);
        if($userId){
            $db->where('userId', $userId);
        }else{
            $db->where('sessionId', $sessionId);
        }
        $cart = $db->first();

        // Return Error if no cart is found
        if(!$cart){
            $response = array('message' => 'Invalid Request');
            return response()->json($response, 400);
        }
        
        // Delete cart item
        $deleted = Cart::destroy($id);
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
