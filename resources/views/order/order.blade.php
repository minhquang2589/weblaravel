<!-- -->
@extends('admin.dashboard')
@section('title', 'order Managements')
@section('content')
<!-- -->
<div class="flex justify-center mt-20	">
   <div class="overflow-x-auto mx-3 lg:w-9/12 rounded-lg border border-gray-200">
      <table class="w-full divide-y-2 divide-gray-200 bg-white text-sm">
         <thead class="ltr:text-left rtl:text-right">
            <tr>
               <th class=" px-4 py-2 font-medium text-gray-900">Name</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Email</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Address</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Phone</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Order number</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Status</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Total amount</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Payment</th>
               <th class=" font-medium text-gray-900"><span class="mr-4">Action</span></th>
            </tr>
         </thead>
         <tbody class="divide-y divide-gray-200">
         @foreach ($datacustomer as $order)
            <tr>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{ $order ->customer_name }}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{ $order ->email }}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{ $order ->address }}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{ $order ->phone }}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{ $order ->order_number }}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-red-700">{{ $order ->status }}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{ $order ->total_amount }}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{ $order ->payment_method }}</td>
               <td><a class="btn btn-primary" href="{{ route('orderdetail', ['id' => $order -> customer_id]) }}"><button class="bg-blue-500 hover:bg-blue-700 mr-4 text-white font-bold py-2 px-4 rounded-full">
                        Detail
                     </button></a></td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</div>




<!--  -->
@endsection