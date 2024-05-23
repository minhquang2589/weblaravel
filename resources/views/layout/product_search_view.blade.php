@extends('dashboard')

@section('title', 'Search')

@section('content')
@if(Request::path()=='product/womens')
@include('layout.slider')
@endif
<div class="my-5 mb-3 mx-3 flex justify-center	">
   <a href="">
      <div class="font-medium text-sm text-gray-600 hover:text-gray-800">Kết quả tìm kiếm</div>
   </a>
</div>
<!--  -->
<span class="flex items-center">
   <span class="h-px flex-1 bg-gray-300"></span>
</span>
<!--  -->
<div class="my-2 ml-2 mt-3 lg:ml-6">
   <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-1 text-sm text-gray-600">
         <li>
            <a href="{{url('')}}" class="block transition hover:text-gray-700">
               <span class="sr-only"> Home </span>
               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
               </svg>
            </a>
         </li>
         <li class="rtl:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
               <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
         </li>
         <li>
            <a href="" class="block transition hover:text-gray-700"> Search</a>
         </li>
      </ol>
   </nav>
</div>
<div class="lg:mx-6 ml-2">
   @if (isset($product_search_count) && $product_search_count >0 )
   <p class="font-medium text-sm text-gray-700">Search results: {{ $product_search_count }}</p>
   @else
   <strong class="font-medium text-sm text-gray-700">No results</strong>
   @endif
</div>
<!-- product  -->
<div class="grid grid-cols-2 lg:mx-6 lg:grid-cols-4 lg:gap-8 ">
   @foreach( $product_search as $product)
   <div class="h-120 rounded-lg">
      <div>
         <div href="" class="group rounded-xl relative block overflow-hidden">
            <button class="absolute end-4 top-4 z-10 bg-conver p-1.5 text-gray-900 transition hover:text-gray-900/75">
               @if ($product->discount_quantity > 0)
               <span class=" mr-1 text-red-600 px-1 py-0.5 text-xs font-medium">- {{ $product->discount }}%</span>
               @endif
            </button>
            <div class="">
               <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->image }}" class="primage min-h-full rounded-t-2xl w-full object-cover transition duration-500 group-hover:scale-105 sm:h-72" />
            </div>
            <div class="relative p-6">
               <div class="flex items-baseline	">
                  <h3 class="mt-4 flex text-[11px] lg:text-sm font-medium">{{ $product->name }}</h3>
                  <div class="mr-4 ">
                     @if ($product->is_new)
                     <span class="rounded-full ml-3 text-white bg-red-600 px-2 py-1 text-xs font-medium"> New </span>
                     @else
                     <span class="rounded-full ml-3 text-white px-2 py-1 text-xs font-medium"></span>
                     @endif
                  </div>
               </div>
               <p class="mt-1.5 lg:text-sm text-[12px] text-gray-500 transition hover:text-gray-800">{{ number_format($product->price / 1000, 3, ',', ',') }}đ</p>
               <div>
                  <a data-product-id="{{ $product->id }}" id="addToCartBtnView{{$product->id}}" class="group relative justify-center	 flex items-center overflow-hidden rounded-full  border py-1.5 mt-2 g:mt-3 lg:mx-10 lg:py-3 text-gray-500 focus:outline-none focus:ring active:text-gray-600">
                     <span class="absolute -end-full transition-all lg:group-hover:end-4">
                        <svg class="size-5 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                     </span>
                     <div class="">
                        <button class="text-sm font-medium transition-all group-hover:me-4">View Product</button>
                     </div>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   @endforeach
</div>

@endsection