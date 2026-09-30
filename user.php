<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable {
 protected $fillable=['name','username','password','role','designation','api_token'];
 protected $hidden=['password','api_token'];
}
