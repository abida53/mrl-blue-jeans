<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
class BkashController extends Controller {
 private function token(){
   $base=rtrim(config('services.bkash.base_url'),'/');
   $res=Http::timeout(30)->withHeaders(['Content-Type'=>'application/json','username'=>config('services.bkash.username'),'password'=>config('services.bkash.password')])
     ->post($base.'/checkout/token/grant',['app_key'=>config('services.bkash.app_key'),'app_secret'=>config('services.bkash.app_secret')]);
   if(!$res->successful()) throw new \Exception('bKash token request failed: '.$res->body());
   return $res->json('id_token') ?? $res->json('access_token');
 }
 public function create(Request $r){
   $d=$r->validate(['amount'=>'required|numeric|min:1','invoiceNumber'=>'required|string|max:100']);
   $token=$this->token(); $base=rtrim(config('services.bkash.base_url'),'/');
   $payload=['amount'=>number_format($d['amount'],2,'.',''),'currency'=>'BDT','intent'=>'sale','merchantInvoiceNumber'=>$d['invoiceNumber'],'callbackURL'=>config('services.bkash.callback_url')];
   $res=Http::timeout(30)->withHeaders(['Content-Type'=>'application/json','Authorization'=>$token,'X-APP-Key'=>config('services.bkash.app_key')])->post($base.'/checkout/payment/create',$payload);
   if(!$res->successful()) return response()->json(['message'=>'bKash create payment failed','details'=>$res->json()],502);
   $j=$res->json(); Payment::updateOrCreate(['invoice_number'=>$d['invoiceNumber']],['amount'=>$d['amount'],'payment_id'=>$j['paymentID']??null,'status'=>$j['transactionStatus']??'PENDING','raw_response'=>$j]);
   return ['paymentID'=>$j['paymentID']??null,'bkashURL'=>$j['bkashURL']??null,'status'=>$j['transactionStatus']??'PENDING'];
 }
 public function execute(Request $r){
   $d=$r->validate(['paymentID'=>'required|string']);
   $token=$this->token(); $base=rtrim(config('services.bkash.base_url'),'/');
   $res=Http::timeout(30)->withHeaders(['Content-Type'=>'application/json','Authorization'=>$token,'X-APP-Key'=>config('services.bkash.app_key')])
      ->post($base.'/checkout/payment/execute',['paymentID'=>$d['paymentID']]);
   if(!$res->successful()) return response()->json(['message'=>'bKash execute failed','details'=>$res->json()],502);
   $j=$res->json(); Payment::where('payment_id',$d['paymentID'])->update(['trx_id'=>$j['trxID']??null,'status'=>$j['transactionStatus']??'COMPLETED','raw_response'=>$j]);
   return $j;
 }
 public function callback(Request $r){
   $paymentId=$r->input('paymentID'); $status=$r->input('status','callback');
   if($paymentId) Payment::where('payment_id',$paymentId)->update(['status'=>$status,'raw_response'=>$r->all()]);
   return redirect(config('app.frontend_url', env('FRONTEND_URL','http://localhost:5500')).'?payment='.urlencode($status));
 }
 public function status($paymentId){
   $token=$this->token(); $base=rtrim(config('services.bkash.base_url'),'/');
   $res=Http::timeout(30)->withHeaders(['Authorization'=>$token,'X-APP-Key'=>config('services.bkash.app_key')])->get($base.'/checkout/payment/query',['paymentID'=>$paymentId]);
   if(!$res->successful()) return response()->json(['message'=>'Unable to query payment'],502);
   return $res->json();
 }
}
