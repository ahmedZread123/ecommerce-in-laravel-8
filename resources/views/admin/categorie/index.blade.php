 
@extends('layouts.admin')
@section('content')
    

<div class="app-content content">
   <div class="content-wrapper">
       <div class="content-header row">
           <div class="content-header-left col-md-6 col-12 mb-2">
               <h3 class="content-header-title"> اللغات </h3>
               <div class="row breadcrumbs-top">
                   <div class="breadcrumb-wrapper col-12">
                       <ol class="breadcrumb">
                           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية</a>
                           </li>
                           <li class="breadcrumb-item active"> الاقسام الرئيسة
                           </li>
                       </ol>
                   </div>
               </div>
           </div>
       </div>
       <div class="content-body">
           <!-- DOM - jQuery events table -->
           <section id="dom">
               <div class="row">
                   <div class="col-12">
                       <div class="card">
                           <div class="card-header">
                               <h4 class="card-title">جميع الاقسام الرئيسية </h4>
                               <a class="heading-elements-toggle"><i
                                       class="la la-ellipsis-v font-medium-3"></i></a>
                               <div class="heading-elements">
                                   <ul class="list-inline mb-0">
                                       <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                       <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                       <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                       <li><a data-action="close"><i class="ft-x"></i></a></li>
                                   </ul>
                               </div>
                           </div>

                           @include('admin.includes.alerts.success')
                           @include('admin.includes.alerts.errors')

                           <div class="card-content collapse show">
                               <div class="card-body card-dashboard">
                                   <table
                                       class="table display nowrap table-striped table-bordered scroll-horizontal">
                                       <thead>
                                       <tr>
                                           <th> الاسم</th>
                                           <th> الاختصار</th>
                                           <th> الصورة</th>
                                         
                                           <th>الحالة</th>
                                           <th>الإجراءات</th>
                                       </tr>
                                       </thead>
                                       <tbody>

                                      @isset($cat)
                                      @foreach ($cat as $cat)
                                          
                                          
                                      
                                               <tr>
                                                   <td>{{$cat->name}} </td>
                                                   <td> {{$cat->translation_lang}}</td>
                                                   <td><img src="{{asset('image_categorie/'.$cat->photo)}}" style="width:150px ; height:100px " alt="صورة"> </td>
                                                  
                                                   <td>{{$cat->getactive()}}</td>
                                                   <td>

                                                       <div class="btn-group" role="group"
                                                            aria-label="Basic example">
                                                           <a href="{{route('categorie.edit',$cat->id)}}"
                                                              class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">تعديل</a>
                                                       
                                                           <form action="{{route('categorie.destroy',$cat->id)}}" method="POST">
                                                             
                                                               @method('DELETE')    
                                                               @csrf
                                                               <button type="submit"
                                                                   
                                                                       class="btn btn-outline-danger btn-min-width box-shadow-3 mr-1 mb-1" 
                                                                       data-toggle="modal"
                                                                       data-target="#rotateInUpRight" 
                                                                       >
                                                                       حذف
                                                               </button>
                                                               
                                                           </form> 

                                                           <a href="{{route('categorie.active',$cat->id)}}"
                                                            class="btn btn-outline-warning btn-min-width box-shadow-3 mr-1 mb-1">
                                                            @if ($cat->active == 1)
                                                                الغاء تفعيل
                                                            @else
                                                            تفعيل 
                                                            @endif </a>
                                                            @if ($cat->supcategory->count() > 0)
                                                                
                                                            
                                                                
                                                            <a href="{{route('categorie.subcategory',$cat->id)}}"
                                                                class="btn btn-outline-primary btn-min-width box-shadow-3 mr-1 mb-1">الاقسام الفرعية
                                                            </a>
                                                            @endif


                                                       </div>
                                                   </td>
                                               </tr>
                                      @endforeach

                                     @endisset   


                                       </tbody>
                                   </table>
                                   <div class="justify-content-center d-flex">

                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </section>
       </div>
   </div>
</div>

@endsection
