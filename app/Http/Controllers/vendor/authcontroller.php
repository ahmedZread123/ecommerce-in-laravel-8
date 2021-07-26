<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\vendorloginrequest;
use App\Http\Requests\vendorRequest;
use App\Models\main_categories;
use App\Models\vendor;
use App\Notifications\vendorcreate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class authcontroller extends Controller
{
    public function getlogin(){
        
        return view('vendor.auth.login');
    }

    public function login(vendorloginrequest $request){
      try{
        //   return $request ;
              $data = [
               'email'    => $request->email,
               'password' => $request->password,
              ];

              if(Auth()->guard('vendor')->attempt($data)){
                  return redirect()->route('vendor.dashboard')->with('success' , 'تم تسجيل الدخول بنجاح');
              }
              return back()->with('error' , 'هناك خطأ في كلمة المرور او كلمة السر ');
 
      }catch(\Exception $ex){
          return $ex;
        return redirect()->route('getlogin')->with('error','هناك خطأ يرجا المحاولة لاحقا ');
      }
    }

    public function getregister(){
        $lang =Config::get('app.locale');
        $cate = main_categories::where('active',1)->where('translation_lang' , $lang)-> get();
      return  view('vendor.auth.register' , compact('cate'));
    }

    public function register(vendorRequest $request){
        try{
            if(empty($request)){
                return back()->with('error','تأكد من عملية ادخل البيانات ') ;
            }else{
                //save image
   
                $file = $request->file('logo');
                $logo = $request->name . time() .'.' . $file->extension();
                $file-> move('image_vendor' ,$logo );
                 
                //check active
                if($request->active == null)
                $request->request->add(['active'=> 0]);
   
             $vendor =   vendor::create([
                   'name'=>$request->name,
                   'mobile'=>$request->mobile,
                   'email'	=>$request->email,
                   'category_id' => $request->category_id,
                   'subcategory_id'=>1,
                   'address' =>$request->address,
                   'active' =>$request->active,
                   'logo' =>$logo,
                   'password'=>Hash::make($request->password),
               ]); 
               Notification::send($vendor , new vendorcreate($vendor)) ;
               return redirect()->route('vendor.dashboard')->with('success' , 'تم اضافة المتجر بنجاح ') ;
            }
           
             
           }catch(\Exception $ex){
               return  $ex ;
               return redirect()->route('vendor.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');
   
           }
    }
}
