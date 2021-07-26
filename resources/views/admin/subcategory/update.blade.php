@extends('layouts.admin')
@section('content')
    
﻿﻿ <div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">الرئيسية </a>
                            </li>
                            <li class="breadcrumb-item"><a href="{{route('subcategory.index')}}"> الاقسام الفرعية </a>
                            </li>
                            <li class="breadcrumb-item active">تعديل قسم فرعي جديد 
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
                                <h4 class="card-title" id="basic-layout-form"> تعديل قسم الفرعي </h4>
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
                                    <form class="form" action="{{route('subcategory.update' , $subcategory->id) }}" method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        {{-- update image  --}}
                                        <input type="hidden" name="ph" value="ph">
                                        <div class="form-group">
                                           <div class="text-center">
                                            <img src="{{asset('image_subcategory/'.$subcategory->photo)}}" style="width:150px ; height:100px " alt="صورة">
                                           </div>
                                          
                                         </div>

                                        <div class="form-group">
                                            <label> صوره القسم </label>
                                            <label id="projectinput7" class="file center-block">
                                                <input type="file" id="file" name="photo">
                                                <span class="file-custom"></span>
                                            </label>
                                            @error('photo')
                                                              
                                            <span class="text-danger">{{$message}} </span>
                                            @enderror   
                                         </div>

                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-home"></i> بيانات  القسم </h4>
                                          
          
                                                   
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectinput1">   اسم القسم  {{ __('message.'.$subcategory->translation_lang) }}   </label>
                                                        <input type="text" value="{{$subcategory->name}}" id="name"
                                                               class="form-control"
                                                          
                                                               name="subcaegory[0][name]">
                                                               @error("subcaegory.0.name")
                                                              
                                                               <span class="text-danger">هذا الحقل مطلوب</span>
                                                               @enderror   
                                                     </div>
                                                </div>

                                                 {{-- القسم  --}}
                                                 <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <label class="input-group-text" for="inputGroupSelect01">اختر قسم</label>
                                                        </div>
                                                        <select class="custom-select" id="inputGroupSelect01" name="category_id">
                                                         @isset($cate)
                                                        @foreach ($cate as $cat)
                                                            
                                                            <option selected value="{{$cat->id}}">{{$cat->name}}</option>
                                                        @endforeach

                                                         @endisset

                                                        </select>
                                                      </div>
                                                </div>
                                          </div>

                                                <div class="col-md-6 hidden">
                                                    <div class="form-group">
                                                        <label for="projectinput1"> أختصار اللغة  {{ __('message.'.$subcategory->translation_lang) }} </label>
                                                        <input type="text" value="{{$subcategory->translation_lang}}" id="name"
                                                               class="form-control"
                                                            
                                                               name="subcaegory[0][translation_lang]">
                                                          @error("subcaegory.0.translation_lang")
                                                              
                                                         <span class="text-danger">هذا الحقل مطلوب</span>
                                                         @enderror     

                                                     </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mt-1">
                                                        <input type="checkbox"  value="1" name="subcaegory[0][active]"
                                                               id="switcheryColor4"
                                                               class="switchery" data-color="success"
                                                               @if ($subcategory->active == 1)
                                                               checked
                                                               @endif
                                                               
                                                               />
                                                        <label for="switcheryColor4"
                                                               class="card-title ml-1">الحالة {{ __('message.'.$subcategory->translation_lang) }}  </label>
                                                      
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
                                                <i class="la la-check-square-o"></i> تحديث
                                            </button>
                                        </div>
                                    </form>

                                    <ul class="nav nav-tabs nav-topline">
                                        @isset($subcategory->categore)
                                            @foreach ($subcategory->categore as $index =>$categ)
                                                
                                          <li class="nav-item">
                                            <a class="nav-link  @if ($index==0)active @endif  "  id="home-tab1" data-toggle="tab" href="#home1{{$index}}" aria-controls="home1"
                                          
                                           @if ($index==0)
                                           aria-expanded="true"
                                           @else
                                           aria-expanded="flase" 
                                           @endif
                                            >{{$categ->translation_lang}}</a>
                                          </li>
                                          @endforeach
                                           
                                          @endisset
  
                                    
                                        </ul>
                                    <div class="tab-content px-1 pt-1">
                                        @isset($subcategory->categore)
                                        @foreach ($subcategory->categore as $index =>$categ)
                                        <div role="tabpanel" class="tab-pane  @if ($index==0)active @endif " id="home1{{$index}}" aria-labelledby="home-tab1{{$categ->id}}" aria-expanded="true">
                                     
                                            <form class="form" action="{{route('subcategory.update' , $categ->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                              @csrf
                                              @method('PUT')
                                              <input type="hidden" name="ph" value="ph">
                                             
      
      
                                              <div class="form-body">
                                                  <h4 class="form-section"><i class="ft-home"></i>  بيانات  القسم الفرعي</h4>
                                                
                
                                                         
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                          <div class="form-group">
                                                              <label for="projectinput1">   اسم القسم الفرعي {{ __('message.'.$categ->translation_lang) }}   </label>
                                                              <input type="text" value="{{$categ->name}}" id="name"
                                                                     class="form-control"
                                                                
                                                                     name="subcaegory[0][name]">
                                                                     @error("subcaegory.0.name")
                                                                    
                                                                     <span class="text-danger">هذا الحقل مطلوب</span>
                                                                     @enderror   
                                                           </div>
                                                      </div>
                                                          {{-- القسم  --}}
                                                 <div class="col-md-6">
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                          <label class="input-group-text" for="inputGroupSelect01">اختر قسم</label>
                                                        </div>
                                                        <select class="custom-select" id="inputGroupSelect01" name="category_id">
                                                         @isset($cate)
                                                        @foreach ($cate as $cat)
                                                            
                                                            <option selected value="{{$cat->id}}">{{$cat->name}}</option>
                                                        @endforeach

                                                         @endisset

                                                        </select>
                                                      </div>
                                                </div>
                                          </div>
                                                      <div class="col-md-6 hidden">
                                                          <div class="form-group">
                                                              <label for="projectinput1"> أختصار اللغة  {{ __('message.'.$categ->translation_lang) }} </label>
                                                              <input type="text" value="{{$categ->translation_lang}}" id="name"
                                                                     class="form-control"
                                                                  
                                                                     name="subcaegory[0][translation_lang]">
                                                                @error("subcaegory.0.translation_lang")
                                                                    
                                                               <span class="text-danger">هذا الحقل مطلوب</span>
                                                               @enderror     
      
                                                           </div>
                                                      </div>
                                                  </div>
      
      
                                                  <div class="row">
                                                      <div class="col-md-6">
                                                          <div class="form-group mt-1">
                                                              <input type="checkbox"  value="1" name="subcaegory[0][active]"
                                                                     id="switcheryColor4"
                                                                     class="switchery" data-color="success"
                                                                     @if ($categ->active == 1)
                                                                     checked
                                                                     @endif
                                                                     
                                                                     />
                                                              <label for="switcheryColor4"
                                                                     class="card-title ml-1">الحالة {{ __('message.'.$categ->translation_lang) }}  </label>
                                                            
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
                                                      <i class="la la-check-square-o"></i> تحديث
                                                  </button>
                                              </div>
                                          </form>
                                        </div>

                                        @endforeach
                                         
                                        @endisset
                                      </div>
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
 