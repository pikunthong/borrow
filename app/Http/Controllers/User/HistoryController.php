<?php

namespace App\Http\Controllers\User;
use App\Cart;
use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    //
    public function index(){
        $count_item_in_cart = Cart::where('user_id',auth()->user()->id)->count();

        $orders = Order::where('user_id',auth()->user()->id)->get();


        return view('user.history',compact('count_item_in_cart','orders'));
    }

    public function show($id){

        $order = Order::with(['details.item'])->where('id',$id)->first();
        $html =  view('user.history-detail',compact('order'))->render();

        return response()->json(['html'=>$html,'status'=>200]);
    }
}
