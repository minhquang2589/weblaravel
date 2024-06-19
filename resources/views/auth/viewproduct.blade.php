@extends('dashboard')
@section('title', 'View Product')
@section('content')
<style>
  .out-of-stock-button {
    opacity: 0.5;
    pointer-events: none;
  }


  .out-of-stock-button:hover {
    cursor: pointer;
    pointer-events: auto;
  }

  .out-of-stock {
    color: red;
  }

  .product_des img {
    width: 200px;
    height: 200px;
  }



  .sold-out-css {
    border-radius: 9999px;
    color: #fff;
    background-color: #dc2626;
    padding-left: 0.75rem;
    padding-right: 0.75rem;
    padding-top: 0.375rem;
    padding-bottom: 0.375rem;
    font-size: 0.75rem;
    font-weight: 500;
  }
</style>
<!--  -->
<div class="text-center">
  <h1 class="text-xl font-bold mt-20 text-gray-900 sm:text-3xl">Product View</h1>
</div>
<span class="flex mt-3 items-center">
  <span class="h-px flex-1 bg-slate-200"></span>
</span>
<!--  -->
<div class="my-2 mx-10 mt-3 ml-6">
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
        <a href="" class="block transition hover:text-gray-700">Product view </a>
      </li>
    </ol>
  </nav>
</div>

<!-- view product -->
<div class="grid grid-cols-1 lg:grid-cols-4">
  <div class="h-full ml-1 px-5 content-center">
    <div>
      <div class="flex justify-start  lg:px-8 pt-3">
        <strong class="text-gray-900 text-sm italic">Product Details</strong>
      </div>
      <div class="lg:px-8">
        <ul class="my-3 ml-3 lg:mt-6 lg:ml-5 ">
          @if (isset($productDetails))
          @foreach ($productDetails as $detail )
          <li class="text-xs">- {{$detail -> description}}</li>
          @endforeach

          @endif
        </ul>
        <div class=" mt-9 italic  text-[12px]">
          @if (isset($colors) && $colors != null)
          Color:
          @foreach($colors as $key => $color)
          {{ $color->color }}
          @if (!$loop->last)
          ,
          @endif
          @endforeach
          @endif
        </div>
        <div class=" italic  text-[12px]">
          @if ($product_info -> category_genter)
          for: {{$product_info -> category_genter}}
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="lg:col-span-2">
    @include('auth.productdetail')
  </div>
  <div class="h-full px-5 lg:px-0 content-center">
    <div class="relative ml-2 mt-1 lg:mt-8 ">
      <div class="flex">
        @if ($product->is_new)
        <span class="whitespace-nowrap mr-1 rounded-full text-white bg-red-600 px-3 py-1.5 text-xs font-medium"> New </span>
        @endif
        @if ($product->remaining > 0 && $product->discount>0)
        <span class="whitespace-nowrap mr-1 rounded-full text-white bg-red-600 px-3 py-1.5 text-xs font-medium"> - {{ $product->discount }}% </span>
        @endif
        <div class="sold-out-css" id="soldOutMessage"></div>
      </div>
      <h3 class="text-[16px] text-gray-700 mt-3">{{ $product->name }}</h3>
      <p class="text-[12px] text-gray-700">{{ number_format($product->price/ 1000, 3, ',', ',') }}đ</p>
      <p class="text-[12px] text-gray-700 mt-2 	 hover:text-blue-700">
        <a href="{{Route('size.guize')}}">
          Size Guize
        </a>
      </p>
      <input type="hidden" value="{{$product->id}}" name="checkquantitystock" id="checkquantitystock">
      <form id="addToCartForm{{$product->id}}" action="{{ route('addcart') }}" method="POST">
        @csrf
        <input type="hidden" name="productCheck_id" value="{{ $product->id }}">
        <div class="flex">
          <div class="w-full">
            @if (isset($product -> remaining) && $product -> remaining >0 && isset($product->discount) && $product -> discount >0)
            <input type="hidden" name="discountPercent" id="discountPercent" value="{{$product->discount}}">
            @else
            <input type="hidden" name="discountPercent" id="discountPercent" value="0">
            @endif
            <input type="hidden" name="discount_id" id="discount_id" value="{{$product->discount_id}}">
            <select for="size" name="size" id="size" class="text-[12px] border-gray-400 rounded border w-2/6 mt-1 p-1 text-gray-700 hover:text-blue-700">
              <option for="size" value="selectsize" hidden selected>Select Size</option>
              @foreach($sizes as $size)
              <option for="size" value="{{$size->size}}">{{ $size->size }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="">
          <select for="color" name="color" id="color" class="text-[12px] border-gray-400 rounded border w-2/6 mt-1 p-1 text-gray-700 hover:text-blue-700">
            <option for="color" value="selectcolor" hidden selected>Select Color</option>
            @foreach($colors as $color)
            <option for="color" value="{{$color->color}}">{{ $color->color }}</option>
            @endforeach
          </select>
          <div class=" text-gray-700 mt-1 text-[12px]" id="totalInStock"></div>
          <!-- stock -->
          <div class=" text-gray-800 text-[12px] mt-1" id="availability"></div>
          <!--  -->
          <div class="text-sm text-red-600 mt-1" id="checkoutMessage"></div>
        </div>
        <div id="notification"></div>
        <div class="flex lg:justify-start justify-center mt-3">
          <div class="mr-2">
            <a id="addToCartBtn{{$product->id}}" class="group relative inline-flex items-center overflow-hidden rounded-full border  px-6 py-2 text-gray-600 focus:outline-none focus:ring active:text-gray-700">
              <span class="absolute -end-full transition-all group-hover:end-4">
                <svg class="size-4 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </span>
              <div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button class="text-sm font-medium transition-all group-hover:me-4" type="button">Add to Cart</button>
              </div>
            </a>
          </div>
          <div>
            <a id="CheckOutBtn" class="group relative inline-flex items-center overflow-hidden rounded-full border  px-8 py-2 text-gray-600 focus:outline-none focus:ring active:text-gray-700">
              <span class="absolute -end-full transition-all group-hover:end-4">
                <svg class="size-4 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </span>
              <div>
                <button class="text-sm font-medium transition-all group-hover:me-4" type="button">Buy now</button>
              </div>
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@if (session('errors'))
<div class="alert alert-danger">
  <ul>
    @foreach (session('errors') as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
<!--  -->
@if ($product->description != null)
<div class="text-center pt-2 ">
  <h1 class="text-xl font-bold mt-7 text-gray-900 sm:text-3xl">Detail product</h1>
</div>
<span class="flex pt-2 pb-5 items-center">
  <span class="h-px flex-1 bg-slate-200"></span>
</span>
<div class="px-7 lg:px-10">
  <div class="product_des">
    {!! $product->description !!}
  </div>
</div>
@endif
@include('dataview.productkankei')
<!-- end view  -->
@endsection