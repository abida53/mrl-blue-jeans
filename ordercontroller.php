<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
class OrderController extends Controller {
 public function index(){ return ['data'=>Order::latest()->get()->map(fn($o)=>['id'=>$o->order_id,'buyer'=>$o->buyer,'style'=>$o->style,'quality'=>$o->quality,'qty'=>$o->qty,'date'=>$o->delivery_date?->format('Y-m-d'),'status'=>$o->status])];}
 public function store(Request $r){
  $d=$r->validate(['buyer'=>'required','style'=>'nullable','quality'=>'nullable','qty'=>'required|integer|min:1','delivery_date'=>'nullable|date','status'=>'required']);
  $d['order_id']='ORD-'.date('Ymd').'-'.str_pad((Order::count()+1),3,'0',STR_PAD_LEFT);
  return response()->json(['data'=>Order::create($d)],201);
 }
 public function destroy(Order $order){$order->delete(); return ['message'=>'Order deleted'];}
}
