@extends('dashboard')

@section('title', 'Payment')

@section('content')
<div class="px-4 py-5 mb-10 lg:px-52 lg:py-20">
    <div class="grid grid-cols-1 gap-1 lg:grid-cols-2 lg:gap-1">
        <div class="h-full mt-8 lg:mt-10">
            @if ($paymentName == 'qr' || $paymentName == 'bank')
            <div class="flex justify-center">
                <img src="{{ asset('images/31CDD39E-B52B-4427-94F5-6E980E9EA953_1_201_a.jpeg') }}" alt="" class="h-4/5 w-3/5 lg:w-40 lg:h-48 object-cover transition duration-500 group-hover:scale-105" />
            </div>
            <div class="flex mt-5 justify-center">
                <span class="text-[12px] text-red-600">
                    Please transfer the correct content <strong>{{$orderNumber}}</strong> for we can confirm the payment
                </span>
            </div>
            <div class="flex mt-3 mb-10 justify-center">
                <div>
                    <table>
                        <tr>
                            <td class="text-[12px] flex justify-end">Account name:</td>
                            <td class="text-[12px] px-4 ml-4">NGO MINH QUANG</td>
                        </tr>
                        <tr>
                            <td class="text-[12px]  flex justify-end">Account number:</td>
                            <td class="text-[12px] px-4 ml-4">1035505217</td>
                        </tr>
                        <tr>
                            <td class="text-[12px]  flex justify-end">Bank:</td>
                            <td class="text-[12px] px-4 ml-4">Vietcombank</td>
                        </tr>
                        <tr>
                            <td class="text-[12px]  flex justify-end">Total:</td>
                            <td class="text-[12px] px-4 ml-4"> {{ number_format($subtotal/ 1000, 3, ',', ',') }}đ </td>
                        </tr>
                        <tr>
                            <td class="text-[12px]  flex justify-end">Memo:</td>
                            <td class="text-[12px] px-4 ml-4"><strong class="text-red-600">{{$orderNumber}}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            @elseif ($paymentName == 'paypal')
            <div class="flex items-center h-full w-full justify-center">
                <div class=" mt-3 mb-10">
                    <span class="text-[12px] text-red-600">
                        Please transfer the correct content <strong>{{$orderNumber}}</strong> for we can confirm the payment
                    </span>
                    <div class="flex justify-center">
                        <table>
                            <tr>
                                <td class="text-[12px]  flex justify-end">Total:</td>
                                <td class="text-[12px] px-4 ml-4"> {{ number_format($subtotal/ 1000, 3, ',', ',') }}đ </td>
                            </tr>
                            <tr>
                                <td class="text-[12px]  flex justify-end">Memo:</td>
                                <td class="text-[12px] px-4 ml-4"><strong class="text-red-600">{{$orderNumber}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @else
            <div class="flex items-center h-full w-full justify-center">
                <div class=" mt-3 mb-10">
                    <span class="text-[12px] text-red-600">
                        Please transfer the correct content <strong>{{$orderNumber}}</strong> for we can confirm the payment
                    </span>
                    <div class="flex justify-center">
                        <table>
                            <tr>
                                <td class="text-[12px]  flex justify-end">Total:</td>
                                <td class="text-[12px] px-4 ml-4"> {{ number_format($subtotal/ 1000, 3, ',', ',') }}đ </td>
                            </tr>
                            <tr>
                                <td class="text-[12px]  flex justify-end">Memo:</td>
                                <td class="text-[12px] px-4 ml-4"><strong class="text-red-600">{{$orderNumber}}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="h-fit  bg-gray-100">
            <div class="ml-3 mr-3 mt-3">
                <div class="flex justify-start">
                    <span class="text-gray-800 text-sm italic">Thank you. Your order has been received!</span>
                </div>
                <div class="mt-3 ml-3 lg:mt-3 lg:ml-3 ">
                    <ul>
                        <li class="text-xs text-black ">Order number: <strong>{{$orderNumber}}</strong></li>
                        <li class="text-xs ">Date: <strong>{{$time}}</strong></li>
                        <li class="text-xs ">Total price: <strong>{{ number_format($subtotal/ 1000, 3, ',', ',') }}đ</strong></li>
                        <li class="text-xs ">Payment method: <strong>{{$element['payment']}}</strong></li>
                    </ul>
                </div>
                <div class="flex mt-2 justify-between">
                    <div class="text-gray-800 text-sm">Order Detail</div>
                    <div class="text-gray-800 text-sm">Order Total</div>
                </div>
            </div>
            <div class="flex justify-end border-t  border-gray-600"></div>
            <div class="ml-3 mr-3 mt-3">
                @foreach($cart as $item)
                <div class="flex justify-between">
                    <div>
                        <span class="text-[12px]">{{ $item['name'] }} - {{ $item['size'] }} x {{ $item['quantity'] }} @if(isset($item['discountPercent']) && $item['discountPercent'] >0)
                            - {{ $item['discountPercent'] }}%
                            @endif</span>
                        <div class="text-[12px]">Color: {{ $item['color'] }}</div>
                    </div>
                    <div class="flex items-center">
                        <div class="text-[12px]">{{ number_format( $item['price'] / 1000, 3, ',', ',') }}đ</div>
                    </div>
                </div>
                <div class="flex my-1 justify-end border-t border-gray-300"></div>
                @endforeach
                <div>
                    @if(isset($totalDiscountAmount) && $totalDiscountAmount >0)
                    <span class="text-[12px] flex justify-between">
                        <dt class="inline">Total discount:</dt>
                        <dd class="inline ">- {{ number_format($totalDiscountAmount/ 1000, 3, ',', ',') }}đ</dd>
                    </span>
                    @endif
                </div>
                <form action="{{Route('handlecheckout.checkout')}}" method="POST">
                    @csrf
                    <div class="mt-3 lg:mt-3 ">
                        <ul>
                            <li class="text-xs mt-1 text-black ">Name: @if(isset($element['name']))
                                {{ $element['name'] }}
                                @else
                                {{ old('name', session('userData.name')) }}
                                @endif
                            </li>
                            <li class="text-xs mt-1 ">Phone number: @if(isset($element['phone']))
                                {{ $element['phone'] }}
                                @else
                                {{ old('phone', session('userData.phone')) }}
                                @endif
                            </li>
                            <li class="text-xs mt-1 ">Email: @if(isset($element['email']))
                                {{ $element['email'] }}
                                @else
                                {{ old('email', session('userData.email')) }}
                                @endif
                            </li>
                            <li class="text-xs mt-1 ">Address: @if(isset($element['address']))
                                {{ $element['address'] }}
                                @else
                                {{ old('address', session('userData.address')) }}
                                @endif
                            </li>
                        </ul>
                    </div>
                    <div class="my-4 flex justify-center ">
                        <input type="hidden" name="total" value="{{$subtotal}}">
                        <input type="hidden" name="time" value="{{$time}}">
                        <button type="submit" class="mr-1 text-sm rounded-xl text-white px-10 py-2 font-medium bg-gray-800 hover:bg-black">
                            Confirm
                        </button>
                        <a href="javascript:void(0);" onclick="window.history.back()" class="text-sm rounded-xl text-white px-12 py-2 font-medium bg-gray-800 hover:bg-black">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div @endsection