@extends('dashboard')

@section('title', 'Check Out')

@section('content')
<div class="mt-20 lg:px-40 px-10">
   <div>
      <div class="overflow-hidden rounded-full bg-blue-500">
         <div class="h-1 w-1/2 rounded-full bg-blue-500"></div>
      </div>
      <ol class="mt-4 grid grid-cols-3 text-sm font-medium  text-gray-500">
         <li class="flex items-center justify-start text-gray-600 sm:gap-1.5">
            <span class=" sm:inline">Shopping </span>
         </li>
         <li class="flex items-center justify-center  text-gray-600 sm:gap-1.5">
            <span class=" sm:inline "><a href="/cart">View Cart</a> </span>
         </li>
         <li class="flex items-center  justify-end sm:gap-1.5">
            <span class=" text-blue-700 sm:inline"><a href="/checkout">Check Out</a></span>
         </li>
      </ol>
   </div>
</div>
<!-- end step -->
<div class="mx-auto max-w-screen-xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
   <div class="text-center mt-4">
      <h1 class="text-xl font-bold mt-5 mb-8 lg:mt-3 text-gray-900 sm:text-3xl">Check Out</h1>
   </div>
   <!--  -->
   <form action="{{ route('checkout.process') }}" method="post">
      @csrf
      <div class="grid grid-cols-1 h-full gap-2 mb-4 lg:grid-cols-3 lg:gap-3">
         <!-- left -->
         <div class="h-fit  border bg-white  border-slate-300 rounded-lg lg:col-span-2">
            <div class="flex justify-start">
               <span class=" mt-4 ml-6 mb-4 text-gray-700">Billing Details</span>
            </div>
            <div class="flex justify-end my-0 border-t border-gray-300"></div>
            <div class="rounded-lg  p-4  lg:col-span-3 lg:p-12">
               <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                  <div>
                     <label class="sr-only" for="name">Name</label>
                     <input value="{{ old('name', session('userData.name')) }}" class="w-full border rounded-lg border-gray-700 p-3 lg:p-3 text-sm" placeholder="Name" name="name" type="name" id="name" />
                     @error('name')
                     <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                        <span class="block sm:inline text-[10px]">{{ $message }}</span>
                     </div>
                     @enderror
                  </div>
                  <div>
                     <label class="sr-only" for="phone">Phone</label>
                     <input value="{{ old('phone', session('userData.phone')) }}" class="w-full border rounded-lg border-gray-700 p-3 text-sm" placeholder="Phone Number" name="phone" type="tel" id="phone" />
                     @error('phone')
                     <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                        <span class="block sm:inline text-[10px]">{{ $message }}</span>
                     </div>
                     @enderror
                  </div>
               </div>
               <div class="mt-2">
                  <label class="sr-only" for="email">Email</label>
                  <input value="{{ old('email', session('userData.email')) }}" class="w-full border rounded-lg border-gray-700 p-3 text-sm" placeholder="Email Address" name="email" type="email" id="email" />
                  @error('email')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-[10px]">{{ $message }}</span>
                  </div>
                  @enderror
               </div>
               <div class="mt-2">
                  <label class="sr-only" for="address">Address</label>
                  <input value="{{ old('address', session('userData.address')) }}" class="w-full border rounded-lg border-gray-700 p-3 text-sm" placeholder="Address" type="text" name="address" id="address" />
                  @error('address')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-[10px]">{{ $message }}</span>
                  </div>
                  @enderror
               </div>
               <div class="mt-2">
                  <label class="sr-only" for="note">Message</label>
                  <textarea class="w-full border rounded-lg border-gray-700 p-3 text-sm" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hoặc địa điểm giao hàng chi tiết hơn." rows="4" lg:row='9' for="note" name="note" id="note"></textarea>
               </div>
            </div>
         </div>
         <!-- right -->
         <div class="h-fit  border border-slate-300 rounded-lg">
            <div class="flex ml-4 mt-4 justify-start">
               <span class=" text-gray-700">Your Order</span>
            </div>
            <div class="flex mt-4 justify-end border-t border-gray-300"></div>
            <div class="ml-4 mt-1 ">
               @if(!empty($cartCheckout))
               @foreach($cartCheckout as $item)
               <div class="flex justify-between">
                  <div>
                     <input type="hidden" name="product_ids[]" value="{{ $item['id'] }}">
                     <span class="text-[12px]">{{ $item['name'] }} - {{ $item['size'] }} x {{ $item['quantity'] }}</span>
                     <div class="text-[12px]">Color: {{ $item['color'] }} </div>
                     <div class="text-[12px]">
                        @if(isset($item['discountPercent'] )&& $item['discountPercent']>0)
                        <span>
                           <dt class="inline">Discount:</dt>
                           <dd class="inline text-red-600">- {{$item['discountPercent']}}%</dd>
                        </span>
                        @endif

                     </div>
                  </div>
                  <div>
                     <span class="mr-3  text-[12px]">{{ number_format($item['price']/ 1000, 3, ',', ',') }}đ</span>
                  </div>
               </div>
               <div class="flex justify-end my-2 border-t border-gray-300"></div>
               @endforeach
               <div class=" my-1 mr-2 flex justify-start ">
                  <span class="text-[12px] text-gray-700">{{$cartQuantity}} items!</span>
               </div>
               <div>
                  @if(isset($VoucherValue)&& $VoucherValue >0)
                  <span class="text-[12px]">
                     <dt class="inline">Voucher:</dt>
                     <dd class="inline text-red-700">- {{$VoucherValue}}%</dd>
                  </span>
                  @endif
               </div>
               <div>
                  @if(isset($totalDiscountAmount) && $totalDiscountAmount >0)
                  <span class="text-[12px]">
                     <dt class="inline">Total discount:</dt>
                     <dd class="inline text-gray-700">- {{ number_format($totalDiscountAmount/ 1000, 3, ',', ',') }}đ</dd>
                  </span>
                  @endif
               </div>
               <div class="flex justify-between">
                  <div class="text-[14px] text-gray-800">Total price</div>
                  <div class="text-[14px] text-gray-800 mr-5">{{ number_format($checkoutSubtotal/ 1000, 3, ',', ',') }}đ</div>
               </div>
               <div class="mt-4 text-[14px] text-gray-800">Shipping</div>
               <div class="justify-start flex ">
                  <dl class=" mb-3 italic space-y-px text-[10px] text-blue-600 ">
                     Vietnam: Recipient pays for shipping service at the time of delivery.
                  </dl>
               </div>
               <!--  -->
               <div>
                  <fieldset class="space-y-2 mr-4">
                     <div>
                        <label for="paypal" class="flex cursor-pointer items-center justify-between gap-4 rounded-lg border border-gray-100  p-1 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                           <p class="text-gray-700">Paypal</p>
                           <input type="radio" name="payment" value="paypal" id="paypal" class="sr-only" />
                        </label>
                     </div>
                     <div>
                        <label for="qr" class="flex cursor-pointer items-center justify-between gap-4 rounded-lg border border-gray-100 p-1 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                           <p class="text-gray-600">Quét mã QR code</p>
                           <input type="radio" name="payment" value="qr" id="qr" class="sr-only" checked />
                        </label>
                     </div>
                     <div>
                        <label for="bank" class="flex cursor-pointer items-center justify-between gap-4 rounded-lg border border-gray-100  p-1 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                           <p class="text-gray-600">Chuyển khoản ngân hàng</p>
                           <input type="radio" name="payment" value="bank" id="bank" class="sr-only" />
                        </label>
                     </div>
                     <div>
                        <label for="meet" class="flex cursor-pointer items-center justify-between gap-4 rounded-lg border border-gray-100  p-1 text-sm font-medium shadow-sm hover:border-gray-200 has-[:checked]:border-blue-500 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                           <p class="text-gray-600">Thanh toán khi nhận hàng</p>
                           <input type="radio" name="payment" value="meet" id="meet" class="sr-only" />
                        </label>
                     </div>
                  </fieldset>
               </div>
               <!--  -->
               <div class="my-4 flex justify-center">
                  <button type="submit" class=" rounded-xl bg-gray-800 hover:bg-black	 px-12 py-2 text-sm text-white w-auto">
                     Next
                  </button>
                  <a href="{{Route('cart')}}" class="ml-2  bg-gray-800 hover:bg-black	 px-7 py-2 text-sm rounded-xl text-white w-auto">
                     Show cart
                  </a>
               </div>

               @else
               <div class="flex my-3">
                  <p class="text-[15px] italic mr-3  text-gray-700">No items!</p>
                  <a class=" text-[15px] italic text-blue-600 hover:text-blue-800" href="{{ url('/') }}">Shopping Here</a>
               </div>
               @endif
            </div>
         </div>
      </div>
   </form>
</div>
@endsection