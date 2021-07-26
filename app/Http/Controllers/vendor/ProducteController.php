<?php

namespace App\Http\Controllers\vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\producterequest;
use App\Models\producte;
use App\Models\size;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class ProducteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try{
       $pro = producte::where('vendor_id' ,  Auth::id())->get();

        return view('vendor.producte.index' , compact('pro'));
        }catch(\Exception $ex){
         return redirect()->route('producte.index')->with('error' , 'هناك خطأ يرجا المحالة لاحقا ') ;

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
        $subcate = subcategory::where('active' , 1)
        ->where('translation_lang' , Config::get('app.locale'))->get();
        return view('vendor.producte.add' , compact('subcate'));
        }catch(\Exception $ex){
        return redirect()->route('producte.index')->with('error' , 'هناك خطأ يرجا المحالة لاحقا ') ;

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(producterequest $request)
    {
        // return $request ;
        try{
         //حفظ الصورة 
        if($request->has('photo')){
             $file     = $request->file('photo') ;
             $img_pro  = $request->name . time() . '.' . $file->extension();
             $file->move('image_producte' , $img_pro); 
        
        }
        // الانتهاء من حفظ الصورة 

        //حفظ الحالة 
          
                 if($request->active == null)
                 $request->request->add(['active'=> 0]);

             
        // النتهاء من حفظ الحالة 

      // حفظ البيانات كاملة 
    
      $pord_id=  producte::insertGetId ([
            'name'         =>$request->name,
        	'contact'      =>$request->contact,
        	'price'	       =>$request->price,
        	'vendor_id'	   =>$request->vendor_id,
        'subcategory_id'   =>$request->subcategory_id,
        	'active'       =>$request->active,
            'photo'        =>$img_pro ,
            'namber'       =>$request->namber,
           
        
        ]);

        //  return !$request->has('size') ;
        if($request->size[0] != null){
            foreach($request->size as $index => $sizes){
        size::create([
          'producte_id'=> $pord_id ,
         'size' => $sizes
        ]);
    }
    }
      //النتهاء من حفظ البيانات 
          
        return redirect()->route('producte.index')->with('success' , 'تم انشاء المنتج بنجاح ') ;

      }catch(\Exception $ex){
         return $ex ;
        return redirect()->route('producte.index')->with('error' , 'هناك خطأ يرجا المحالة لاحقا ') ;
     }
    }

    public function show($id){
      $prod = producte::find($id);
      return view('vendor.producte.show' ,compact('prod'));
    }

    public function edit(producte $producte)
    {
       try{
        if(!producte::find($producte->id)){
            return redirect()->route('producte.index')->with('error' , 'هذا القسم غير موجود او تم حذفه');
        }
        $subcate = subcategory::where('active' , 1)
        ->where('translation_lang' , Config::get('app.locale'))->get();
        return view('vendor.producte.update' , compact('producte' , 'subcate'));
       }catch(\Exception $ex){
           return $ex ;
        return redirect()->route('producte.index')->with('error' , 'هناك خطأ يرجا المحالة لاحقا ') ;
         
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function update(producterequest $request, producte $producte)
    {
        // return $request ;
        try{
            if(!producte::find($producte->id)){
                return redirect()->route('producte.index')->with('error' , 'هذا القسم غير موجود او تم حذفه');
            }
            
            //فحص وجود صورة وحفظها 
            if($request->has('photo')){
                $file     = $request->file('photo') ;
                $img_pro  = $request->name . time() . '.' . $file->extension();
                $file->move('image_producte' , $img_pro); 
           
           }else
           $img_pro = $producte->photo ;

           //انتهاء حفظ الصورة 
             //حفظ الحالة 
             if($request->active == null)
             $request->request->add(['active'=> 0]);

            
             // النتهاء من حفظ الحالة 

             // تعديل البيانتات
             $producte->update([
                'name'         =>$request->name,
                'contact'      =>$request->contact,
                'price'	       =>$request->price,
                'namber'	   =>$request->namber,
                'vendor_id'	   =>$request->vendor_id,
         'subcategory_id'      =>$request->subcategory_id,
                'active'       =>$request->active,
                'photo'        =>$img_pro ,
             ]);


        return redirect()->route('producte.index')->with('success' , 'تم تعديل المنتج لنجاح  ') ;
          
        }catch(\Exception $ex){
            return $ex ;
        // return redirect()->route('producte.index')->with('error' , 'هناك خطأ يرجا المحالة لاحقا ') ;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\producte  $producte
     * @return \Illuminate\Http\Response
     */
    public function destroy(producte $producte)
    {
        try{
            if(!$producte){
                return redirect()->route('producte.index')->with('error' , 'هذا القسم غير موجود او تم حذفه');
            }

            $producte->delete();
            return redirect()->route('producte.index')->with('success' , 'تم حذف المنتج بنجاح ') ;

        }catch(\Exception $ex){
        return redirect()->route('producte.index')->with('error' , 'هناك خطأ يرجا المحالة لاحقا ') ;
          
        }
    }

    public function active($id){
       
        try{
            $producte = producte::find($id);
            // return $producte;
            if(!$producte){
                return redirect()->route('producte.index')->with('error' , 'هذا القسم غير موجود او تم حذفه');
            }

            if($producte->active == 0){
              
               $producte->update(['active'=>1]) ;
            }else{
              
               $producte->update(['active'=>0]) ;
            }
            return redirect()->route('producte.index')->with('success' , 'تم تعديل الحالة بنجاح ') ;

        }catch(\Exception $ex){
        return redirect()->route('producte.index')->with('error' , 'هناك خطأ يرجا المحالة لاحقا ') ;
          
        }
    }
}
