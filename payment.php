<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
 protected $fillable=['invoice_number','amount','payment_id','trx_id','status','raw_response'];
 protected $casts=['raw_response'=>'array'];
}
