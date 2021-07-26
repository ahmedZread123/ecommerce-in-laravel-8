@extends('layouts.vendor')
@section('content')
    
﻿﻿ <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('vendor.dashboard')}}">الرئيسية </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('producte.index')}}"> المنتجات</a>
                            </li>
                            <li class="breadcrumb-item active">تعديل منتج  
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic form layout section start -->
            <section id="basic-form-layouts">
                <div class="row match-height">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title" id="basic-layout-form"> تعديل منتج جديد </h4>
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
                                <div class="card-body">
                                    <form class="form" action="{{route('producte.update' , $producte) }}" method="POST"
                                          enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{-- add logo  --}}
                                        <div class="form-group">
                                            
                                            <label> صورة المنتج  </label>
                                            <label id="projectinput7" class="file center-block">
                                                <input type="file" id="file" name="photo">
                                                <input type="hidden" name="ph" value="ph">
                                                <span class="file-custom"></span>
                                            </label>
                                            <img src="{{asset('image_producte/'.$producte->photo)}}" style="width:200px ; height:150px " alt="صورة">

                                            @error('photo')
                                                              
                                            <span class="text-danger">{{$message}} </span>
                                            @enderror   
                                        </div>
                                           
                                        
                                         <div class="form-body">
                                            <h4 class="form-section"><i class="ft-home"></i> بيانات  المنتج </h4>
                                          
                                    
                                                   {{-- الاسم + رقم الهاتف  --}}
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">   اسم المنتج   </label>
                                                        <input type="text" value="{{$producte->name}}" id="name"
                                                               class="form-control"
                                                          
                                                               name="name">
                                                               @error("name")
                                                              
                                                               <span class="text-danger">  {{$message}}</span>
                                                               @enderror   
                                                     </div>
                                                </div>

                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label for="projectinput1">السعر</label>
                                                        <input type="text" value="{{$producte->price}}" id="name"
                                                               class="form-control"
                                                            
                                                               name="price">
                                                          @error("price")
                                                              
                                                         <span class="text-danger">  {{$message}}</span>
                                                         @enderror     

                                                     </div>
                                                </div>
                                            </div>
                                                  {{-- القسم + التاجر   --}}
                                            <div class="row">
                                                {{-- القسم  --}}
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <label class="input-group-text" for="inputGroupSelect01"> اختر قسم فرعي</label>
                                                        </div>
                                                        <select class="custom-select" id="inputGroupSelect01" name="subcategory_id">
                                                         @isset($subcate)
                                                        @foreach ($subcate as $cate)
                                                            
                                                            <option 
                                                            @if ($cate->id == $producte->subcategory_id	)
                                                            selected 
                                                            @endif
                                                            value="{{$cate->id}}">{{$cate->name}}</option>
                                                        @endforeach

                                                         @endisset

                                                        </select>
                                                      </div>
                                                </div>

                                                   {{-- العدد  --}}
                                                   <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label for="projectinput1">الكمية المتوفرة</label>
                                                        <input type="text" value="{{$producte->namber}}" id="name"
                                                               class="form-control"
                                                            
                                                               name="namber">
                                                          @error("namber")
                                                              
                                                         <span class="text-danger">  {{$message}}</span>
                                                         @enderror     

                                                     </div>
                                                </div>
                                                 {{-- التاجر  --}}
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                       
                                                        <input type="hidden" value="{{Auth::id()}}" 
                                                               class="form-control"
                                                            
                                                               name="vendor_id">
                                                          @error("vendor_id")
                                                              
                                                         <span class="text-danger">  {{$message}}</span>
                                                         @enderror     

                                                     </div>
                                                </div>
                                            </div>
                                         {{-- وصف المنتج  --}}
                                            <div class="row">
                                             <div class="col-md-8 mt-2">
                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="وصف المنتج " 
                                                    name="contact" id="floatingTextarea2" style="height: 100px">{{$producte->contact}}</textarea>
                                                    <label for="floatingTextarea2">وصف المنتج</label>
                                                </div>
                                                @error("contact")
                                                              
                                                <span class="text-danger">  {{$message}}</span>
                                                @enderror     
                                             </div>
                   
                                            </div>
                                           {{-- الحالة  --}}
                                            <div class="row">
                                                

                                                <div class="col-md-6">
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox"  value="1" name="active"
                                                               id="switcheryColor4"
                                                               class="switchery" data-color="success"
                                                               @if ($producte->active == 1)
                                                               checked
                                                               @endif
                                                               />
                                                        <label for="switcheryColor4"
                                                               class="card-title ml-1">الحالة</label>
                                                      
                                                        <span class="text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                           
                                           
                                        </div>


                                        <div class="form-actions">
                                            <button type="button" class="btn btn-warning mr-1"
                                                    onclick="history.back();">
                                                <i class="ft-x"></i> تراجع
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="la la-check-square-o"></i> حفظ
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Basic form layout section end -->
        </div>
    </div>
</div>

@endsection
 
{{-- @section('script')
@include('layouts.script')
@endsection --}}