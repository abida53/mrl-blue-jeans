<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(){Schema::create('employees',function(Blueprint $t){$t->id();$t->string('employee_id')->unique();$t->string('name');$t->string('designation')->nullable();$t->string('department');$t->decimal('salary',12,2)->default(0);$t->string('phone')->nullable();$t->date('join_date')->nullable();$t->string('status')->default('Active');$t->timestamps();});} public function down(){Schema::dropIfExists('employees');}};
