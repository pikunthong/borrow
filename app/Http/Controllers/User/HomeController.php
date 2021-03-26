<?php

namespace App\Http\Controllers\User;

use App\Cart;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(Request $request) {
//        dd($request->get('search'));

        $items = Item::where('status',0);

        if (!empty($request->get('search'))){
            $items->where('title','like','%'.$request->get('search').'%');

        }

        $count_item_in_cart = Cart::where('user_id',auth()->user()->id)->count();
//        หาจำนวน Db ของ Cart แล้ว count ว่ามีกี่ชิ้น

        $items = $items->get();
        return view('user.home',compact('items','count_item_in_cart'));
    }
}
