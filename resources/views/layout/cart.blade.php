@extends('dashboard')
@section('title', 'Cart')
@section('content')
<!-- step -->
@if(Request::path()=='/cart')
@include('layout.slider')
@endif
<div class="mt-20 lg:px-40 px-10">
  <div>
    <div class="overflow-hidden rounded-full bg-gray-200">
      <div class="h-1 w-1/2 rounded-full bg-blue-500"></div>
    </div>
    <ol class="mt-4 grid grid-cols-3 text-sm font-medium text-gray-500">
      <li class="flex items-center justify-start text-gray-600 sm:gap-1.5">
        <span class=" sm:inline">Shopping </span>
      </li>
      <li class="flex items-center justify-center text-blue-700 sm:gap-1.5">
        <span class=" sm:inline"><a href="/cart">View Cart</a></span>
      </li>
      <li class="flex items-center justify-end sm:gap-1.5">
        <span class=" sm:inline"><a href="/checkout">Check Out</a></span>
      </li>
    </ol>
  </div>
</div>
<!-- end step -->
<div>
  <div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
    <div class="mx-auto max-w-3xl">
      <div class="text-center">
        <h1 class="text-xl font-bold mt-4 lg:mt-3 text-gray-900 sm:text-3xl">Shopping Cart</h1>
      </div>
      <div class="mt-5">
        <div class="flex justify-end border-t border-gray-600"></div>
        <ul>
          @if(!empty($viewcartData))
          @foreach($viewcartData as $item)
          <li class="flex  items-center gap-4 py-3">
            @if(isset($item['image']))
            <a href="{{ route('product.view', ['id' => $item['id']]) }}">
              <img src="{{ asset('images/' . $item['image']) }}" alt="" class="size-24 rounded object-cover">
            </a>
            @else
            <span class="text-red-500 text-sm">No image available</span>
            @endif
            <div>
              @if(is_array($item) && isset($item['name']))
              <a href="{{ route('product.view', ['id' => $item['id']]) }}">
                <h3 class="text-sm text-gray-600"><strong>{{ $item['name'] }}</strong></h3>
              </a>
              @else
              <span class="text-red-500 text-sm">No name available</span>
              @endif
              <dl class="mt-0.5 space-y-px text-[11px] text-gray-600">
                <div>
                  <dt class="inline">Price: {{ number_format($item['price'] / 1000, 3, ',', ',') }}đ</dt>
                </div>
                @if(isset($item['discountPercent'] )&& $item['discountPercent']>0)
                <div>
                  <dt class="inline">Discount:</dt>
                  <dd class="inline text-red-600">- {{$item['discountPercent']}}%</dd>
                </div>
                @endif
                <div>
                  <dt class="inline">Color:</dt>
                  <dd class="inline">{{$item['color']}}</dd>
                </div>
                <div>
                  <dt class="inline">Size:</dt>
                  <dd class="inline">{{$item['size']}}</dd>
                </div>
              </dl>

            </div>

            <div class="flex flex-1 items-center justify-end gap-2">
              <form class="updateQuantityForm" method="post" action="{{ route('cart.update-quantity') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{$item['id']}}">
                <input type="hidden" name="color" value="{{$item['color']}}">
                <input type="hidden" name="size" value="{{$item['size']}}">
                <button class="decreaseQuantityBtn" type="button" class="size-9 leading-10 text-gray-400 transition hover:opacity-75">
                  &minus;
                </button>
                <input type="number" min="1" oninput="validity.valid||(value='');" name="quantity" value="{{$item['quantity']}}" class="quantityInput h-6 w-10 border rounded border-gray-300 text-center sm:text-sm [-moz-appearance:_textfield] [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none" />
                <button class="increaseQuantityBtn" type="button" class=" text-gray-400 transition hover:opacity-75">
                  &plus;
                </button>
              </form>

              <form method="POST" action="{{ route('cart.remove') }}" class="mt-2 remove-from-cart-cart">
                @csrf
                <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                <input type="hidden" name="size" value="{{ $item['size'] }}">
                <input type="hidden" name="color" value="{{ $item['color'] }}">
                <button type="submit" class="text-gray-600 transition hover:text-red-600">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                </button>
              </form>
            </div>
          </li>
          @endforeach
          <div class="flex justify-end border-t border-gray-600"></div>
          @else
          <div class="flex">
            <p class="my-2 text-[15px] italic mr-3  text-gray-700">No items in cart!</p>
            <a class="my-2 text-[15px] italic text-blue-600 hover:text-blue-800" href="{{ url('/') }}">Shopping Here</a>
          </div>
          <div class="removeEnd"></div>
          <div class="flex justify-end border-t border-gray-600"></div>
          @endif
        </ul>
        <div class="justify-end flex ">
          <dl class="mt-1 italic space-y-px text-[10px] text-blue-600 ">
            Vietnam: Recipient pays for shipping service at the time of delivery.
          </dl>
        </div>
        <div class=" mt-2 justify-end grid text-sm ">
          <div class="text-gray-700 text-sm mr-2" id="cartquantity"></div>
        </div>
        <div class="mt-8 mx-1.5	 flex justify-end  pt-8">
          <div class="w-screen max-w-lg">
            <dl class="space-y-0.5 text-sm text-gray-700">
              <div class="flex justify-between">
                <dt>Total</dt>
                <dd id="cartTotal"></dd>
              </div>
              @if(session('error'))
              <div class="alert alert-success">
                {{ session('success') }}
              </div>
              @endif

              <div class="flex justify-between">
                <dt>VAT</dt>
                <dd>0%</dd>
              </div>
              <div class="flex justify-between">
                <dt>Discount</dt>
                <dd id="CartDiscount"></dd>
              </div>
              <div class="flex justify-between !text-base font-medium">
                <dt>Subtotal</dt>
                <dd id="cartSubtotal"></dd>
              </div>
            </dl>
            <div class="w-1/2 sm:w-1/2 mt-3">
              <div class="relative border-current">
                <input type="text" id="voucherInput" value="{{ old('aruvoucher', session('aruvoucher.voucherCode')) }}" placeholder="Apply voucher" class="w-full border rounded-md border-gray-400 hover:border-gray-600 py-2 shadow-sm sm:text-sm" />
                <span class="absolute inset-y-0 end-0 grid w-10 place-content-center">
                  <button type="button" id="applyVoucherButton" class="p-2 text-gray-400 hover:text-gray-700">
                    <svg class="h-4 w-4" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path d="m11 11h-7.25c-.414 0-.75.336-.75.75s.336.75.75.75h7.25v7.25c0 .414.336.75.75.75s.75-.336.75-.75v-7.25h7.25c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-7.25v-7.25c0-.414-.336-.75-.75-.75s-.75.336-.75.75z" fill-rule="nonzero" />
                    </svg>
                  </button>
                </span>
              </div>
            </div>
            <div class="text-sm text-red-600 my-1" id="voucherMessage"></div>
            @if (session('error'))
            <div class="alert text-sm text-red-600 alert-error">
              <p>{{ session('error') }} </p>
            </div>
            @endif
            <div class="flex mt-2 justify-end">
              <div class=" flex">
                <a href="javascript:void(0);" onclick="window.history.back()" class="mr-1  bg-gray-800 hover:bg-black	 px-10 py-2 text-sm rounded-xl text-white w-auto">
                  Back
                </a>
              </div>
              <div id="checkoutButton">
                <a href="/checkout" class="block rounded-xl bg-gray-800 hover:bg-black px-6 py-2 text-sm text-white transition" id="checkoutLink">
                  Checkout
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  document.getElementById('checkoutButton').addEventListener('click', function() {
    var voucherCode = document.getElementById('voucherInput').value;
    var checkoutLink = document.getElementById('checkoutLink');
    checkoutLink.href = "/checkout?voucher=" + voucherCode;
  });
</script>

@endsection