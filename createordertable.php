<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('orders',function(Blueprint $t){$t->id();$t->string('order_id')->unique();$t->string('buyer');$t->string('style')->nullable();$t->string('quality')->nullable();$t->unsignedInteger('qty');$t->date('delivery_date')->nullable();$t->string('status')->default('Pending');$t->timestamps();});} public function down(){Schema::dropIfExists('orders');}};
