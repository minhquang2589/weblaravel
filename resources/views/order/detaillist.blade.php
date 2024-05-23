<!-- -->
@extends('admin.dashboard')
@section('title', 'Order Details')
@section('content')
<div class="mb-4 ml-20">
</div>
<div class="grid grid-cols-1 mx-4  gap-3 lg:gap-5 lg:mx-10 lg:grid-cols-2">
   <!-- trai -->
   <div class="flex justify-center mt-20	">
      <div class="overflow-x-auto bg-gray-100 w-full rounded-lg border">
         <div class="flow-root rounded-lg border border-gray-100 py-3 ">
            <div class="flex justify-between mx-10 my-3">
               <div class="text-gray-800 "><strong>Customer Detail</strong></div>
               <div>
                  <label for="statusFilter" class="block text-sm font-medium text-gray-700">Filter by status:</label>
                  <select id="statusFilter" name="statusFilter" class="form-select mt-1 block w-full">
                     <option value="">Tất cả</option>
                     <option value="pending">Không xác định</option>
                     <option value="pending">Đang chờ xác nhận</option>
                  </select>
               </div>
            </div>
            <div class="flex justify-end border-t  border-gray-600"></div>
            <div class=" divide-y divide-gray-100 text-sm my-8">
               @foreach($datacustomer as $value)
               <div class=" px-8">
                  <div>
                     <div class="text-[12px]">Status: <strong class="text-red-700">{{$value ->status }}</strong></div>
                     <div class="lg:flex lg:justify-between">
                        <div class="text-[12px]">Name: <strong>{{$value ->customer_name }} - <strong>{{$value ->total_purchases }}</strong></strong></div>
                        <div class="text-[12px]">Date: <strong>{{$value ->order_date }}</strong> </div>
                     </div>
                     <div class="text-[12px]">Phone: <strong>{{$value ->phone }}</strong></div>
                     <div class="text-[12px]">Email: <strong>{{$value ->email }}</strong></div>
                     <div class="text-[12px]">Address: <strong>{{$value ->address }}</strong></div>
                     <div class="text-[12px]">Order Number: <strong>{{$value ->order_number }}</strong></div>
                     <div class="text-[12px]">Payment: <strong>{{$value ->payment_method }}</strong></div>

                     @if (isset($value->total_discount) && $value->total_discount >0)
                     @php
                     $total = $value->total_discount + $value->total_amount;
                     @endphp
                     <div class="text-[12px]">Total: <strong>{{ number_format( $total / 1000, 3, ',', ',') }}đ</strong></div>
                     @if (isset($value->voucher_value) && $value->voucher_value >0)
                     <div class="text-[12px]">Voucher: <strong>- {{ $value->voucher_value}}%</strong></div>
                     @endif
                     <div class="text-[12px]">Total Discount: <strong>{{ number_format( $value ->total_discount / 1000, 3, ',', ',') }}đ</strong></div>
                     <div class="text-[12px]">Total price: <strong>{{ number_format( $value ->total_amount / 1000, 3, ',', ',') }}đ</strong></div>
                     @else
                     @if (isset($value->voucher_value) && $value->voucher_value >0)
                     <div class="text-[12px]">Voucher: <strong>- {{ $value->voucher_value}}%</strong></div>
                     @endif
                     <div class="text-[12px]">Total price: <strong>{{ number_format( $value ->total_amount / 1000, 3, ',', ',') }}đ</strong></div>
                     @endif
                  </div>
                  <div class="flex justify-end border-t  border-gray-600"></div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
   <!-- phai -->
   <div class="flex justify-center  lg:mt-20	">
      <div class="overflow-x-auto bg-gray-100 w-full rounded-lg border">
         <div class="flow-root rounded-lg border border-gray-100 py-3 ">
            <div class="flex mx-10 my-3 justify-between ">
               <div class="text-gray-800 "><strong>Order items</strong></div>
               <div class="text-gray-800 "><strong>Item price</strong></div>
            </div>
            <div class="flex justify-end border-t  border-gray-600"></div>
            @foreach($orderItems as $item)
            <div class="  divide-gray-100 text-sm ">
               <div class="flex justify-between px-8">
                  <div>
                     <span class="text-[12px]">{{$item ->product_name }} - {{$item ->size }} x {{$item ->quantity }}</span>
                     <div class="text-[12px]">Color: {{$item ->color }}</div>
                     @if (isset($item ->discount ) && $item ->discount > 0)
                     <div class="text-[12px]">discount: - {{$item ->discount }}%</div>
                     @endif
                  </div>
                  <div class="flex items-center">
                     <div class="text-[12px]">{{ number_format($item ->order_item_price / 1000, 3, ',', ',') }}đ</div>
                  </div>
               </div>
            </div>
            <div class="flex justify-end border-t  border-gray-300"></div>

            @endforeach
         </div>
         <div class="mx-4 my-4">
            <button type="submit" class="inline-block w-full rounded-lg bg-black px-10 py-2 font-medium text-white sm:w-2/6">
               Confirm
            </button>
         </div>
      </div>
   </div>
</div>
<script>
   document.getElementById('statusFilter').addEventListener('change', function() {
      var status = this.value;
      console.log('Selected status:', status);
      if (status.trim() !== '') {
         $.ajax({
            url: "{{ route('order.filter') }}",
            type: 'GET',
            data: {
               status: status
            },
            success: function(data) {
               $('#orderList').html(data);
            },
            error: function(xhr, status, error) {
               console.error(error);
            }
         });
      } else {
         console.error('Status value is empty');
      }
   });
</script>




@endsection