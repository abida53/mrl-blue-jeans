<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model {
 protected $fillable=['order_id','buyer','style','quality','qty','delivery_date','status'];
 protected $casts=['delivery_date'=>'date'];
}
