<?php
namespace App\Http\Helpers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;

class Cart
{
    public  static  function  getCartItemsCount(): int
    {
        /**get the request*/
        $request  = \request();
        /**from the request , get user data*/
        $user     = $request->user();
        /**check if the user is authorized*/
        if ($user){
            /**making query in the database*/
            return  CartItem::where('user_id', $user->id)->sum('quantity');
        }else {
            /**if the user isn't authorized*/
            $cartItems = self::getCookieCartItems();  // $cartItems associative array

            return  array_reduce(
                $cartItems,
                fn($carry, $item) => $carry + $item['quantity'],
                0
            );
        }
    }

    public  static  function  getCartItems()
    {
        /**get the request*/
        $request  = \request();
        /**from the request , get user data*/
        $user     = $request->user();
        if ($user){
            /**return the associative array*/
            return  CartItem::where('user_id', $user->id)->get()->map(
                fn($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );

        }else{
            /**if the user isn't authorized*/
            return self::getCookieCartItems();  // inside the cookie we save item like
        }

    }
    public  static  function  getCookieCartItems()
    {
        /**get the request*/
        $request  = \request();

        /**call cookie*/
        return json_decode($request->cookie('cart_items',' []'), true);


    }
    public  static  function  getCountFromItems($cartItems)
    {
        /**Accept Item */
        return  array_reduce(
            $cartItems,
            fn($carry ,$item ) => $carry + $item['quantity'],
            0
        );
    }
    public  static  function moveCartItemsIntoDb()
    {
        /**get the request*/
        $request  = \request();
        /**get cart item from cookies*/
        $cartItems    = self::getCookieCartItems();
        $dbCartItems  = CartItem::where(['user_id' => $request->user()->id])->get()->keyBy('product_id');
        $newCartItems = [];
        foreach ($cartItems as $cartItem){
            if (isset($dbCartItems[$cartItem['product_id']])){
                continue;
            }
            $newCartItems[] =[
                'user_id'       => $request->user()->id,
                'product_id'    => $cartItem['product_id'] ,
                'quantity'      => $cartItem['quantity'],
            ];
        }
        /**check if the newcartitems */
        if (!empty($newCartItems)){
            /** Save into database */
            CartItem::insert($newCartItems);
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public static  function getProductsAndCartItems(): array|\Illuminate\Database\Eloquent\Collection
    {
        $cartItems = self::getCartItems();

        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Product::query()->whereIn('id', $ids)->get();
        $cartItems = Arr::keyBy($cartItems, 'product_id');

        return [$products,$cartItems];
    }
}
