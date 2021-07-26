<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\lanuageRequest;
use App\Models\lanuages;
use Illuminate\Http\Request;

class lanuagecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lanuage =  lanuages::paginate(PAGINATION_COUNT);
        return view('admin.lanuages.index' , compact('lanuage'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
        return view('admin.lanuages.add' );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(lanuageRequest $request)
    {
        try{
            
            if(!$request->has('active'))
               $request->request->add(['active'=>0]);

        lanuages::create($request->except('_token'));
        return redirect()->route('lanuage.index')->with('success' , 'تم حفظ اللغة بنجاح');
        }catch(\Exception $ex){
        return redirect()->route('lanuage.index')->with('error' ,  'هناك خطأ يرجا المحاولة في ما بعد ');
          
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
        $lang  = lanuages::find($id);
        if(!$lang){
            return redirect()->route('lanuage.index')->with('error','هذه اللغة غير موجودة');
        }else
        return view('admin.lanuages.update' , compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(lanuageRequest $request, $id)
    {
        try{
            $lang  = lanuages::find($id);
            // no empty 
            if(!$lang){
                return redirect()->route('lanuage.edit' , $id)->with('error','هذه اللغة غير موجودة');
            }
            if(!$request->has('active'))
            $request->request->add(['active'=>0]);
          //    update in data 
            $lang->update($request->except('_token'));

            // redirect in index 
            return redirect()->route('lanuage.index')->with('success','تم التعديل بنجاح');
        }
        catch(\Exception $ex){
            return redirect()->route('lanuage.index')->with('error' ,  'هناك خطأ يرجا المحاولة في ما بعد ');
              
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
            $lang  = lanuages::find($id);
            // no empty 
            if(!$lang){
                return redirect()->route('lanuage.edit' , $id)->with('error','هذه اللغة غير موجودة');
            }

           //    delete in data 
            $lang->delete();

          // redirect in index 
            return redirect()->route('lanuage.index')->with('success','تم الحذف بنجاح');
        }
        catch(\Exception $ex){
            return redirect()->route('lanuage.index')->with('error' ,  'هناك خطأ يرجا المحاولة في ما بعد ');
              
            }
    }
}
