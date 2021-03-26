<?php

namespace App\Http\Controllers\User;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function index(){
        $count_item_in_cart = Cart::where('user_id',auth()->user()->id)->count();
        $carts = Cart::with('item')->where('user_id',auth()->user()->id)->get();


        return view('user.cart',compact('count_item_in_cart','carts'));
    }

    public function addToCart($id){

        $item_exits = Cart::where('user_id',auth()->user()->id)->where('item_id',$id)->count();

            if($item_exits > 0){
                return response()->json(['message'=>'มีไอเทมนี้มีในตระกร้าแล้ว','status'=>302]);
            }

        $data = [
          'user_id'=>auth()->user()->id,
          'item_id'=>$id
        ];

        Cart::create($data);

        return response()->json(['message'=>'เพิ่มลงตระกร้าเรียบร้อยแล้ว','status'=>200]);
    }

    public function removeInCart($id){
        Cart::where('user_id',auth()->user()->id)->where('item_id',$id)->delete();
        return response()->json(['message'=>'ลบสินค้าเรียบร้อยแล้ว','status'=>200]);
    }

    public function clearCart(){
        Cart::where('user_id',auth()->user()->id)->delete();
        return response()->json(['message'=>'ลบสินค้าทั้งหมดเรียบร้อยแล้ว','status'=>200]);
    }

    public function crateOrder(){
        $carts = Cart::where('user_id',auth()->user()->id)->get();

        if($carts->isEmpty()){
            return response()->json(['message'=>'ไม่พบไอเทมในตระกร้า','status'=>422]);
        }

        $order_data = [
            'user_id'=>auth()->user()->id,
            'status'=>0
        ];

        $order = Order::create($order_data);

        foreach ($carts as $cart){
            $order_data_detail[] = [
              'order_id' => $order->id,
              'item_id' => $cart->item_id

            ];
        }

        OrderDetail::insert($order_data_detail);


        Cart::where('user_id',auth()->user()->id)->delete();

        return response()->json(['message'=>'สร้าง order เรียบร้อย','status'=>200]);
    }
}
