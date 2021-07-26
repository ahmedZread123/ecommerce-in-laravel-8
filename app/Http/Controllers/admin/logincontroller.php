<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\loginrequest;
use App\Models\admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class logincontroller extends Controller
{
   public function getlogin()
   {
      return view('admin.auth.login');
   }

   public function setlogin(loginrequest $request)
   {
    $remember_me = $request->has('remember_me') ? true :false ;
      $admin = [
        'email'=>$request->email , 
        'password'=>$request->password
      ];

   if(Auth()->guard('admin')->attempt($admin)){
    
      
          return redirect()->route('admin.dashboard');
       
   }
    return redirect()->back()->with('error' , 'هناك خطا في اسم المستخدم او كلمة المرور ');

    
   
 }

 public function logout(){
   //  return "10";
    try{
    if(Auth()->guard('admin')->check()){
      Auth()->guard('admin')->logout();
    }
    return redirect()->route('admin.login')->with('success' , 'تم تسجل الخروج بنجاح');
   }catch(\Exception $ex){
     return $ex ;
      return redirect()->back()->with('error' , 'هناك خطأ يرجا المحاولة لاحقا ');
   }
 }
   
}
