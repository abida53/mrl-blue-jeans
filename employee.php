<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Employee extends Model {
 protected $fillable=['employee_id','name','designation','department','salary','phone','join_date','status'];
 protected $casts=['join_date'=>'date'];
}
