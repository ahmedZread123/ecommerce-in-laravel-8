<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\vendorRequest;
use App\Models\lanuages;
use App\Models\main_categories;
use App\Models\subcategory;
use App\Models\vendor;
use App\Notifications\vendorcreate;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $vendor = vendor::paginate(10);
       return view('admin.vendor.index' , compact('vendor'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang =Config::get('app.locale');
        $cate = main_categories::where('active',1)->where('translation_lang' , $lang)-> get();
        // $subcate = subcategory::where('active',1)->where('translation_lang' , $lang)-> get();

      
        return view('admin.vendor.add' , compact( 'cate'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(vendorRequest $request)
    {
        // return $request ;
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
            return redirect()->route('vendor.index')->with('success' , 'تم اضافة المتجر بنجاح ') ;
         }
        
          
        }catch(\Exception $ex){
            return  $ex ;
            return redirect()->route('vendor.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
        $lang = Config::get('app.locale');
        $cate = main_categories::where('active' , 1)->where('translation_lang' , $lang)->get();

       $vendor = vendor::find($id);

       if(!$vendor){
        return redirect()->route('vendor.index')->with('error' , ' هذا المتجر غير موجود او ربما محذوف');

       }
       return view('admin.vendor.update' , compact('vendor' , 'cate'));

        }catch(\Exception $ex){
         return redirect()->route('vendor.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');
           
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(vendorRequest $request, $id)
    {
        try{
    
        // return $request ;

        // check id 
       $vendor = vendor::find($id);
        if(!$vendor){
            return redirect()->route('vendor.index')->with('error' , ' هذا المتجر غير موجود او ربما محذوف');
           }
        // check image 
          DB::beginTransaction();
        if($request->has('logo')){
     
            // save image 
            $file = $request->file('logo');
            $logo = $request->name . time()  . '.' . $file->extension();
            $file->move('image_vendor' , $logo) ;

            $vendor->update([
              'logo'=>$logo 
            ]);
        }

        //check password or data 
        $data = $request->except('_token' , 'id' , 'logo' , 'password' , 'log' , 'pass' , '_method') ;
  
        if(!empty($request->password)){
            $data['password'] = $request->password ;
        }


        // update data 

        vendor::where('id',$id)->update($data) ;

        DB::commit();
        return redirect()->route('vendor.index')->with('success' , ' تم التحديث بنجاح');
        
        }catch(\Exception $ex){
            return $ex ;
            DB::rollBack();
         return redirect()->route('vendor.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
        $vendor = vendor::find($id) ; 
        if($vendor == null){
          return redirect()->route('vendor.index')->with('error' , 'هذا المتجر غير موجود او تم حذفه');

        }
        unlink('image_vendor/'.$vendor->logo);
        $vendor->delete();
        return redirect()->route('vendor.index')->with('success' , 'تم حذف المتجر بنجاح');
      }catch(\Exception $ex){
         return redirect()->route('vendor.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');

      }
    }

    
    public function active($id){
        try{
          $vendor = vendor::find($id);
          if(!$vendor){
            return redirect()->route('vendor.index')->with('error' , ' هذا القسم غير موجود او تم حذفه');
          }
          
          if($vendor->active == 0){
            $vendor->update([
              'active'=>1
            ]);
          }
            else{
              $vendor->update([
                'active'=>0
              ]);
            }
            return redirect()->route('vendor.index')->with('success' , 'تم التحديث بنجاح ');
          
      
        }catch(\Exception $ex){
          return redirect()->route('vendor.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');
      
        }
      
      
      }
}
