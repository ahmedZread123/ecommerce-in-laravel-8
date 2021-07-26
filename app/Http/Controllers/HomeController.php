<?php

namespace App\Http\Controllers;

use App\Models\contact_us;
use App\Models\main_categories;
use App\Models\order;
use App\Models\User;

use App\Models\producte;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    //التسجيل وتسجيل الدخول للمستخدم 
    // login 
    public function login(){
     
      return view('front.login');
    }

    public function at_login(Request $request){
      //  return $request ;
       $data = [
        'email'=>$request->email , 
        'password'=>$request->password ,
      ];

     if(Auth()->guard('web')->attempt($data)){
        return redirect()->route('home')  ;
      }else
      return back()->with('كلمة اسم المستخدم او كليمة المرور غير صحيحة ');

    }
    // register 
    public function register(){
     return view('front.register');
    }

    public function save_register(Request $request){
      User::create([
         'name'      =>$request->name , 
         'email'     =>$request->email , 
         'password'  =>Hash::make($request->password)  ,
      ]);


      return redirect()->route('home')  ;
    }

    // logout 

    public function logout(){
      if(Auth()->guard('web')->check()){
        Auth()->guard('web')->logout();
      }
     return redirect()->route('login') ;
   }
    //  الصفحة الرئيسية 
    public function index()
    {
        $cate = main_categories::where('active' , 1)->where('translation_lang',Config::get('app.locale'))->get();
        $prod = producte::where('active' , 1)->orderby('created_at','DESC')->limit(3)->get();
        $producte = producte::where('active' , 1)->orderby('created_at','DESC')->get();
        $producte1 = producte::where('active' , 1)->orderby('created_at')->get();
        $subcate = subcategory::where('active' , 1)->where('translation_lang',Config::get('app.locale'))->get();
        

        return view('front.index' , compact('cate' ,'prod' , 'producte' , 'producte1' , 'subcate'));

    }
     // عرض تفاصيل المنتج 
    public function show($id){
        $prod = producte::find($id);
       $id_sub = $prod->subcategory->id ;
      $subcate =   subcategory::find($id_sub);

        return view('vendor.producte.show' ,compact('prod' , 'subcate'));
      }
    // الاضافة الى السلة 
      public function AddToCart(Request $request ){
        // return $request ;
      
             order::create([
              'count'      =>$request->count , 
              'product_id' =>$request->producte_id , 
              'name'       =>$request->name,
              'price'      =>$request->price,
             ]);
      
           return back()->with('success' , 'تم اضافة ا لمنتج بنجاح') ;
      }
         
      // عرض ما بداخل السلة
      public function showcart(){
        $cart  =  order::all();
        $total = 0 ;
        foreach($cart as $item){
         $total+= $item->price * $item->count ; 
        }
       $total ;
       
        return view('front.cart' , compact('cart' , 'total'));
      }

      //التحكم في عدد المنتجات 

      public function mor($id){
        // return $id ;
       $order = order::find($id);
       $order->update([
        'count' => $order->count + 1 ,
       ]);

       return back() ;
      }
 
      public function les($id){
        $order = order::find($id);
        $order->update([
         'count' => $order->count - 1 ,
        ]);
       return back() ;

       }

    // تصفح المنتجات في ملف shop

    public function shop(){
      $cates =   main_categories::where('translation_of' , 0)->where('active',1)->get();

      $prods =   producte::orderby('created_at' , 'DESC')->paginate(12);
      return view('front.shop' , compact('cates' , 'prods'));
    }


    // حول الموقع 

    public function about_us(){
     
      return view('front.about_us');
    }

    // التواصل مع الموقع
    public function contact_us(){
      
      return view('front.contact_us');
    }

    public function contact_save(Request $request){
      
      contact_us::create([
        'name'	=> $request->name , 
        'email'	=> $request->email ,
        'namber'=> $request->namber,
        'comment'=>$request->comment,
      ]);

      return redirect()->route('home')->with('success' , 'تم ارسال الرسالة بنجاح ') ; 
    }
}
