@extends('admin.dashboard')
@section('title', 'Vouchers')
@section('content')
<div class="mx-6 lg:mx-0">
   <div class="flex justify-start mt-14 mb-10 ml-20">
      <h3><strong class="text-3xl"> Update vouchers</strong></h3>
   </div>
   <div class="flex justify-center">
      <table class="lg:w-fit w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm">
         <thead class="ltr:text-left rtl:text-right">
            <tr>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">voucher_code</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">discount_value</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">quantity</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">status</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">start_date</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">end_date</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Action</th>
            </tr>
         </thead>
         @if(isset($vouchers))
         @foreach($vouchers as $value)
         <tbody class="divide-y divide-gray-200">
            <tr>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->voucher_code }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->discount_value }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->voucher_quantity }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->status }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->start_date }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->end_date }}</td>
               <td>
                  <form action="{{ route('vouchers.delete', ['id' => $value->id]) }}" method="POST">
                     @csrf
                     @method('DELETE')
                     <button onclick="return confirm('Do you want to delete this voucher?')" type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full">
                        Delete
                     </button>
                  </form>

               </td>
               <td>
                  <form action="{{ route('vouchers.update', ['id' => $value->id]) }}" method="GET">
                     @csrf
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