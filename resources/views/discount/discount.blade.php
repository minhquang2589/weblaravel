@extends('admin.dashboard')
@section('title', 'Discounts')
@section('content')
<div class="mx-6 lg:mx-0">
   <div class="flex justify-start mt-14 mb-10 ml-20">
      <h3><strong class="text-3xl">Discounts</strong></h3>
   </div>
   <div class="flex justify-center">
      <table class="lg:w-fit w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm">
         <thead class="ltr:text-left rtl:text-right">
            <tr>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Discount</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Quantity</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Remaining</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">status</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">start_date</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">end_date</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Action</th>
            </tr>
         </thead>
         @if(isset($discounts))
         @foreach($discounts as $value)
         <tbody class="divide-y divide-gray-200">
            <tr>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->discount }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->quantity }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->remaining }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->status }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->start_datetime }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->end_datetime }}</td>
               <td>
                  <form action="{{ route('discount.edit',['id' =>$value->id ]) }}" method="get">
                     @csrf
                     <input type="hidden" name="discount_id" value="{{$value->id}}">
                     <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full">
                        Update
                     </button>
                  </form>
               </td>
            </tr>
         </tbody>
         @endforeach
         @endif
      </table>
   </div>
</div>
@endsection