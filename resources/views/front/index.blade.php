@extends('layouts.siet')
@section('title')
Home
@endsection
@section('content')
	<main id="main">
		<div class="container">

			<!--MAIN SLIDE-->
			<div class="wrap-main-slide">
				<div class="slide-carousel owl-carousel style-nav-1" data-items="1" data-loop="1" data-nav="true" data-dots="false">
				   @if (isset($prod))
					   @foreach ($prod as $index=>$pro)
					   <?php $i=1 ; ?>
					   <div class="item-slide">
						<img src="{{asset('image_producte/'.$pro->photo)}}" alt="{{$pro->name}}"   width="1170" height="240"  class="img-slide .h-20  .w-20">
						<div class="slide-info slide-{{++$i}}">
							<h2 class="f-title"> <b>{{$pro->name}}</b></h2>
							<span class="subtitle">{{$pro->contact}}</span>
							<p class="sale-info">Only price: <span class="price">${{$pro->price}}</span></p>
							<a href="{{route('show.producte',$pro->id)}}" class="btn-link">Shop Now</a>
						</div>
				       </div>

					   @endforeach
				   @endif
					
				
				</div>
			</div>

			<!--BANNER-->
			<div class="wrap-banner style-twin-default">
				<div class="banner-item">
					<a href="#" class="link-banner banner-effect-1">
						<figure><img src="assets/images/home-1-banner-1.jpg" alt="" width="580" height="190"></figure>
					</a>
				</div>
				<div class="banner-item">
					<a href="#" class="link-banner banner-effect-1">
						<figure><img src="assets/images/home-1-banner-2.jpg" alt="" width="580" height="190"></figure>
					</a>
				</div>
			</div>

			<!--On Sale-->
			<div class="wrap-show-advance-info-box style-1 has-countdown">
				<h3 class="title-box">On Sale</h3>
				<div class="wrap-countdown mercado-countdown" data-expire="2020/12/12 12:34:56"></div>
				<div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container " data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}'>
                    @if (isset($producte))
						@foreach ($producte as $product)
						<div class="product product-style-2 equal-elem ">
							<div class="product-thumnail">
								<a href="{{route('show.producte',$product->id)}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
									<figure><img src="{{asset('image_producte/'.$product->photo)}}" width="800" height="800" alt="{{$product->name}}"></figure>
								</a>
								<div class="group-flash">
									<span class="flash-item sale-label">sale</span>
								</div>
								<div class="wrap-btn">
									<a href="{{route('show.producte',$product->id)}}" class="function-link">quick view</a>
								</div>
							</div>
							<div class="product-info">
								<a href="{{route('show.producte',$product->id)}}" class="product-name"><span>{{$product->name}}</span></a>
								<div class="wrap-price"><span class="product-price">${{$product->price}}</span></div>
							</div>
						</div>
						@endforeach
					@endif
					

				</div>
			</div>

			<!--Latest Products-->
			<div class="wrap-show-advance-info-box style-1">
				<h3 class="title-box">Latest Products</h3>
				<div class="wrap-top-banner">
					<a href="{{route('show.producte',$pro->id)}}" class="link-banner banner-effect-2">
						<figure><img src="{{asset('image_producte/'.$pro->photo)}}" width="1170" height="0" alt="{{$product->name}}"></figure>
					</a>
				</div>

				<div class="wrap-products">
					<div class="wrap-product-tab tab-style-1">						
						<div class="tab-contents">
							<div class="tab-content-item active" id="digital_1a">
								<div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >
                                   @if (isset($producte1))
								   @foreach ($producte1 as $index => $prod1)
										<div class="product product-style-2 equal-elem ">
											<div class="product-thumnail">
												<a href="{{route('show.producte',$prod1->id)}}" title="{{$prod1->name}}">
													<figure><img src="{{asset('image_producte/'.$prod1->photo)}}" width="800" height="800" alt="{{$prod1->name}}"></figure>
												</a>
												<div class="group-flash">
													<span class="flash-item new-label">new</span>
												</div>
												<div class="wrap-btn">
													<a href="{{route('show.producte',$prod1->id)}}" class="function-link">quick view</a>
												</div>
											</div>
											<div class="product-info">
												<a href="{{route('show.producte',$prod1->id)}}" class="product-name"><span>{{$prod1->contact}}</span></a>
												<div class="wrap-price"><span class="product-price">${{$prod1->price}}</span></div>
											</div>
							    </div>
								   @endforeach
									   
								   @endif
								

								</div>

							</div>
           


					<h3 class="title-box">Product Categories</h3>
				<div class="wrap-top-banner">
					<a href="{{route('show.producte',$prod1->id)}}" class="link-banner banner-effect-2">
						<figure><img src="{{asset('image_producte/'.$prod1->photo)}}" width="1170" height="240" alt=""></figure>
					</a>
				</div>

				<div class="wrap-products">
					@if (isset($subcate))

					<div class="wrap-product-tab tab-style-1">
						<div class="tab-control">
							@foreach ($subcate as $index=> $subcat)
							<a href="#{{$subcat->name}}" class="tab-control-item 
							@if($index == 0)
							active
							@endif
							">{{$subcat->name}}</a>
						
						
							@endforeach
								
							@endif
						</div>

						{{-- // تفصيل المنتج  --}}
					  
										
						<div class="tab-contents">
						@if (isset($subcate))
						@foreach ($subcate as $index=> $subcat)
						   
							<div class="tab-content-item active" id="{{$subcat->name}}">
								<div class="wrap-products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"4"},"1200":{"items":"5"}}' >
									@if (isset($subcat->producte))
									@foreach ($subcat->producte as$index => $item)
									<div class="product product-style-2 equal-elem ">
										<div class="product-thumnail">
											<a href="{{route('show.producte',$item->id)}}" title="{{$item->name}}">
												<figure><img src="{{asset('image_producte/'.$item->photo)}}" width="800" height="800" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
											</a>
											<div class="group-flash">
												<span class="flash-item new-label">new</span>
											</div>
											<div class="wrap-btn">
												<a href="{{route('show.producte',$item->id)}}" class="function-link">quick view</a>
											</div>
										</div>
										<div class="product-info">
											<a href="{{route('show.producte',$item->id)}}" class="product-name"><span>{{$item->name}}</span></a>
											<div class="wrap-price"><span class="product-price">${{$item->price}}</span></div>
										</div>
									</div>
									
									@endforeach
									@endif

								</div>
							</div>
							
							@endforeach
								
							@endif
						
						</div>

					

					</div>
				
				</div>
			
			</div>			
		
		</div>

	</main>

@endsection