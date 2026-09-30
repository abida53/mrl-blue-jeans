<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('payments',function(Blueprint $t){$t->id();$t->string('invoice_number')->unique();$t->decimal('amount',12,2);$t->string('payment_id')->nullable();$t->string('trx_id')->nullable();$t->string('status')->default('PENDING');$t->json('raw_response')->nullable();$t->timestamps();});} public function down(){Schema::dropIfExists('payments');}};
