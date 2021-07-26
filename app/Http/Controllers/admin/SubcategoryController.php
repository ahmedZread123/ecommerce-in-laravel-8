<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\subcategoryRequest;
use App\Models\lanuages;
use App\Models\main_categories;
use App\Models\subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class SubcategoryController extends  Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = Config::get('app.locale');
        $sub = subcategory::where('translation_lang'  ,$lang)->get();
        return view('admin.subcategory.index' , compact('sub'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
        $lang = lanuages::all();
        $lan=Config::get('app.locale');

        $cate = main_categories::where('active',1)->where('translation_lang' , $lan)-> get();
        // return $cate ;
       return view('admin.subcategory.add' , compact('lang' , 'cate') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(subcategoryRequest $request)
    {
        //  return $request ;

       try{
            // save imag 
            if($request->has('photo')){
              $file = $request->file('photo');
              $img_subcate = $request->subcaegory[0]['name'] . time() . '.' . $file->extension() ;
              $file -> move('image_subcategory' ,$img_subcate );
            }
           //end uploade image 

           // save defualte lang in subcategory 
      
            $sub_cate = collect($request->subcaegory);
        //   filter defult lang 
            $filter = $sub_cate->filter(function($value , $key){
             return $value['translation_lang'] == Config::get('app.locale');
          });
         DB::beginTransaction();
         $new_filter = array_values($filter->all());
         $subcate_id = subcategory::insertGetId([
            'translation_lang'=> $new_filter[0]['translation_lang'],
            'parent_id' => 0,	
            'category_id'=>$request->category_id ,
            'translation_of'=>0	,
            'name'=> $new_filter[0]['name'],	
            'slug'=> $new_filter[0]['name'],
            'photo'	=> $img_subcate,
            'active'=> $new_filter[0]['active'],
         ]);

       // end save defulte 

       //save all date but not defulte 
         
       $all_subcate = $sub_cate->filter(function($value , $key){
         return $value['translation_lang'] != Config::get('app.locale');
       });
       
       if(isset($all_subcate) && $all_subcate->count() > 0){
           foreach($all_subcate as $filte ){
               subcategory::insert([
                'translation_lang'=> $filte['translation_lang'],
                'parent_id' => 0,	
                'category_id'=>$request->category_id ,
                'translation_of'=>$subcate_id	,
                'name'=> $filte['name'],	
                'slug'=> $filte['name'],
                'photo'	=> $img_subcate,
                'active'=> $filte['active'],
               ]);
           }
       }

        //end save all data 
        DB::commit();
        return redirect()->route('subcategory.index')->with('success' , 'تم اضافة قسم فرعي جديد بنجاح ');
        
       }catch(\Exception $ex){
        //    return $ex ;
         DB::rollBack();
        return redirect()->route('subcategory.index')->with('error' , 'هناك خطا يرجا اعادة المحاولة ');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(subcategory $subcategory)
    {
        try{
          if($subcategory){
            $lan=Config::get('app.locale');

            $cate = main_categories::where('active',1)->where('translation_lang' , $lan)-> get();
          return view('admin.subcategory.update'  , compact('subcategory' , 'cate'));
          }else
          return redirect()->route('subcategory.index')->with('error' , 'هذا القسم غير موجود');

        }catch(\Exception $ex){
            return redirect()->route('subcategory.index')->with('error' , 'هناك خطا يرجا اعادة المحاولة ');

        }
    }


    public function update(subcategoryRequest $request, $id)
    {
        // return $request ;
        $subcategory = subcategory::find($id);
        try{
     
           if(subcategory::find($id)){
              // فحص الصورة والتحميلها 
              if(isset($request->photo) && !empty($request->photo && $request->has('photo'))){
                $file = $request->file('photo');
                $img_subcate = $request->subcaegory[0]['name'] . time() . '.' . $file->extension() ;
                $file -> move('image_subcategory' ,$img_subcate );
              }else
              $img_subcate = $subcategory->photo ;
              

              // فحص ال active والتأكد من قيمتها 
               if($request->has('subcaegory.0.active')  ){
                   $request->request->add(['active'=>1]);
               }else
               $request->request->add(['active'=>0]);
             // انتهاء تحميل الصورة بعد التاكد من وجوها 

            // تعديل البيانات
             //.......... 
             $subcat = collect($request->subcaegory) ;
          

            $subcategory->update([
               'photo' =>$img_subcate ,
               'name' =>$subcat[0]['name'],
               'active' =>$request->active , 
               'category_id' =>$request->category_id ,
            ]);
            
            return redirect()->route('subcategory.index')->with('success' , 'تم تحديث القسم بنجاح  ');
           
            
           }else
            return redirect()->route('subcategory.index')->with('error' , 'هذا القسم غير موجود  ');
             
        }catch(\Exception $ex){
            return redirect()->route('subcategory.index')->with('error' , 'هناك خطا يرجا اعادة المحاولة ');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(subcategory $subcategory)
    {
        if($subcategory){
           if($subcategory->categore->count() > 0  && !empty($subcategory->categore) ){
               foreach($subcategory->categore as $subcate){
                   $subcate->delete();
               }
           }
            $subcategory->delete();
            return redirect()->route('subcategory.index')->with('success' , 'تم حذف القسم بنجاح');
        }
        return redirect()->route('subcategory.index')->with('error' , 'هذا القسم غير موجود');
    }

    public function active($id){
         $subcate = subcategory::find($id);
         if(!$subcate){
            return redirect()->route('subcategory.index')->with('error' , 'هذا القسم غير موجود');
         }

         if($subcate->active == 0){
            if($subcate->categore->count() > 0  && !empty($subcate->categore) ){
                foreach($subcate->categore as $subcat){
                    $subcat->update(['active'=>1]) ;
                }
            }
           $subcate->update(['active'=>1]) ;
        }else{
            if($subcate->categore->count() > 0  && !empty($subcate->categore) ){
                foreach($subcate->categore as $subcat){
                    $subcat->update(['active'=>0]) ;
                }
            }
           $subcate->update(['active'=>0]) ;
        }
      return redirect()->route('subcategory.index')->with('success' , 'تم تغير الحالة بنجاح');
    }
}
