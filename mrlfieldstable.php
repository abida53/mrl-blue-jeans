<?php
use Illuminate\Database\Migrations\Migration; use Illuminate\Database\Schema\Blueprint; use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){Schema::table('users',function(Blueprint $t){$t->string('username')->unique()->nullable();$t->string('role')->default('employee');$t->string('designation')->nullable();$t->string('api_token',64)->nullable()->index();});}
 public function down(){Schema::table('users',function(Blueprint $t){$t->dropColumn(['username','role','designation','api_token']);});}
};
