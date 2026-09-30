<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder; use Illuminate\Support\Facades\Hash; use App\Models\User; use App\Models\Order; use App\Models\Employee;
class DatabaseSeeder extends Seeder {
 public function run(): void {
  foreach([
   ['Alfaj Ahmed','admin','admin123','admin','System Administrator'],
   ['Rahim Uddin','emp','emp123','employee','Production Supervisor'],
   ['Sarah Mitchell','buyer','buyer123','buyer','Sourcing Manager'],
  ] as [$name,$username,$pass,$role,$designation])
   User::updateOrCreate(['username'=>$username],['name'=>$name,'password'=>Hash::make($pass),'role'=>$role,'designation'=>$designation]);
  Order::insert([
   ['order_id'=>'ORD-2026-001','buyer'=>'H&M','style'=>'Polo Shirt T/C','quality'=>'60/40 T/C','qty'=>15000,'delivery_date'=>'2026-10-30','status'=>'Completed','created_at'=>now(),'updated_at'=>now()],
   ['order_id'=>'ORD-2026-002','buyer'=>'Zara','style'=>'Denim Jacket','quality'=>'100% Denim','qty'=>20000,'delivery_date'=>'2026-11-15','status'=>'In Progress','created_at'=>now(),'updated_at'=>now()],
  ]);
  Employee::insert([
   ['employee_id'=>'EMP-001','name'=>'Karim Ahmed','designation'=>'Cutting Master','department'=>'Cutting','salary'=>22000,'status'=>'Active','created_at'=>now(),'updated_at'=>now()],
   ['employee_id'=>'EMP-002','name'=>'Fatema Begum','designation'=>'Sewing Operator','department'=>'Sewing','salary'=>16500,'status'=>'Active','created_at'=>now(),'updated_at'=>now()],
  ]);
 }
}
