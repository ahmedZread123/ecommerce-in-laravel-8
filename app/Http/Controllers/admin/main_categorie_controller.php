<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\main_categorie;
use App\Models\lanuages;
use App\Models\main_categories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class main_categorie_controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = Config::get('app.locale');
       $cat = main_categories::where('translation_lang',$lang )->get();
       return view('admin.categorie.index' , compact('cat'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lang = lanuages::where('active',1)->get();
        return view('admin.categorie.add' , compact('lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(main_categorie $request)
    {
        try{
                //    save image 
                $file = $request->file('photo');
                $cate_photo = $request->caegory[0]['name'] . time() .'.' . $file->extension();
                $file->move('image_categorie',$cate_photo);


                // find and save the defaualt languge in cate 

                $main_cate = collect($request->caegory);

                $filter =  $main_cate -> filter(function($value , $key){
                        return $value['translation_lang'] ==Config::get('app.locale');
                    });
                $new_filter = array_values($filter->all()) ;
                    
                    DB::beginTransaction();
                $cate_id =  main_categories::insertGetId([
                        'translation_lang' => $new_filter[0]['translation_lang'],
                        'translation_of'=> 0,
                            'name'	=>$new_filter[0]['name'], 
                            'slug'	=>$new_filter[0]['name'], 
                            'active'=>$new_filter[0]['active'],
                            'photo'=>$cate_photo,
                ]);
                

            // save all data bute no defaullte languge
                $cate_all =  $main_cate -> filter(function($value , $key){
                    return $value['translation_lang'] !=Config::get('app.locale');
                });

                if(isset($cate_all) && $cate_all->count() > 0){
                    foreach($cate_all as $cate_all ){
                        main_categories::insert([
                            'translation_lang' => $cate_all['translation_lang'],
                            'translation_of'=> $cate_id,
                            'name'	=>$cate_all['name'], 
                            'slug'	=>$cate_all['name'], 
                            'active'=>$cate_all['active'],
                            'photo'=>$cate_photo,
                            
                        ]);
                    }
                }
                DB::commit();
                return redirect()->route('categorie.index')->with('success' , 'تم الحفظ بنجاح');
        }catch(\Exception $ex){
           DB::rollBack();
           return redirect()->route('categorie.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');

        }
      
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!main_categories::find($id)){
           return redirect()->route('categorie.index')->with('error' , ' هذا القسم غير موجود');
        }
        $cate =   main_categories::with('categore')->find($id);
       return  view('admin.categorie.update' ,compact('cate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(main_categorie $request, $id)
    {
      try{
      //  return   $request;
        // find main id 
          $cate=main_categories::find($id);
        if(!$cate){
          return redirect()->route('categorie.index')->with('error' , ' هذا القسم غير موجود');
        }
        //فحص ال active 
        if(!$request->has('caegory.0.active'))
          $request->request->add(['active' => 0]);
          else
          $request->request->add(['active' => 1]);
          
            //    save image 
          if($request->has('photo')){

            $file = $request->file('photo');
            $cate_photo = $request->caegory[0]['name'] . time() .'.' . $file->extension();
            $file->move('image_categorie',$cate_photo);

            }else{
              $cate_photo = $cate->photo ;
            }
        //update data 
          $categ = array_values($request->caegory)[0];
        $cate->update([
          'name'	=>$categ['name'], 
          'active'=>$request->active ,
          'photo'=>$cate_photo
        ]);
          //redirect to index with success
        return redirect()->route('categorie.index')->with('success' , 'تم التحديث بنجاح');
    }catch(\Exception $ex){
        return redirect()->route('categorie.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');
        
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
              $cate = main_categories::find($id) ;
              // return $cate->vendor()->count();
          if($cate){
          $vendor = $cate->vendor()->count();
            if(isset($vendor) && $vendor > 0 ){
              return redirect()->route('categorie.index')->with('success' , ' لا يمكن حذف هذا القسم يوجد بداخله '. $vendor .'متاجر  ');
            }
          //   return 'image_categorie/'.$cate->photo;
            unlink('image_categorie/'.$cate->photo);
            $cate->categore()->delete();
            $cate->delete();
          return redirect()->route('categorie.index')->with('success' , 'تم الحذف بنجاح');
          
          }else
          return redirect()->route('categorie.index')->with('error' , 'هذا القسم غير موجود ');
        
      }catch(\Exception $ex)
        {
        
            return redirect()->route('categorie.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');
          
  }


}

public function active($id){
  try{
    $cate = main_categories::find($id);
    if(!$cate){
      return redirect()->route('categorie.index')->with('error' , ' هذا القسم غير موجود او تم حذفه');
    }
    
    if($cate->active == 0){
      $cate->update([
        'active'=>1
      ]);
    }
      else{
        $cate->update([
          'active'=>0
        ]);
      }
      return redirect()->route('categorie.index')->with('success' , 'تم التحديث بنجاح ');
    

  }catch(\Exception $ex){
    return redirect()->route('categorie.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');

  }

}

public function allsubcategory($id){
  try{
    $cat =   main_categories::find($id);
     $cate = $cat->supcategory;
     if($cate && $cate->count() > 0 ){
      return view('admin.categorie.supcategory' , compact('cate'))->with('success' , 'تم عرض الاقسام بنجاح ');
     }else
     return redirect()->route('categorie.index')->with('error' , 'لا يوجد اقسام فرعية لهذا القسم ');

  }catch(\Exception $ex){
    // return $ex ;
    return redirect()->route('categorie.index')->with('error' , ' حدث خطأ يرجا المحاولة مرة اخرى');

  }

}

}
