<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Employee;
class EmployeeController extends Controller {
 public function index(){return ['data'=>Employee::latest()->get()->map(fn($e)=>['id'=>$e->employee_id,'name'=>$e->name,'desig'=>$e->designation,'dept'=>$e->department,'salary'=>number_format($e->salary),'status'=>$e->status])];}
 public function store(Request $r){
  $d=$r->validate(['name'=>'required','designation'=>'nullable','department'=>'required','salary'=>'required|numeric|min:0','phone'=>'nullable','join_date'=>'nullable|date']);
  $d['employee_id']='EMP-'.str_pad(Employee::count()+1,3,'0',STR_PAD_LEFT); $d['status']='Active';
  return response()->json(['data'=>Employee::create($d)],201);
 }
 public function destroy(Employee $employee){$employee->delete(); return ['message'=>'Employee removed'];}
}
