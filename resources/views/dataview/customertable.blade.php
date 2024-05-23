<!-- -->
@extends('admin.dashboard')
@section('title', 'Table')
<!--  -->
@section('content')
<div class="">
   <div class="flex justify-start mt-20 ml-20">
      <h1><strong class="text-3xl">Customers</strong></h1>
   </div>
   <div class="flex justify-center mt-7	">
      <div class="overflow-x-auto mr-5 w-9/12 rounded-lg border border-gray-200">
         @if (session('success'))
         <div class="alert text-blue-600 alert-success">
            <strong>{{ session('success') }} </strong>
         </div>
         @endif
         <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
            <thead class="ltr:text-left rtl:text-right">
               <tr>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Name</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Email</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Address</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Notes</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Phone</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Số lần mua hàng </th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Action</th>
               </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
               @foreach($customers as $value)
            <tbody class="divide-y divide-gray-200">
               <tr>
                  <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->name }}</td>
                  <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->email }}</td>
                  <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->address }}</td>
                  <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->notes }}</td>
                  <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->phone }}</td>
                  <td class="flex justify-center whitespace-nowrap px-4 py-2 text-gray-900">{{ $value->total_purchases }}</td>
                  <td>
                     <form action="{{ route('customer.edit', ['id' => $value->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full">
                           edit
                        </button>
                     </form>
                  </td>
                  <td>
                     <form action="{{ route('customer.delete', ['id' => $value->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Do you want to delete this customer?')" type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full">
                           Delete
                        </button>
                     </form>
                  </td>
               </tr>
            </tbody>
            @endforeach
            </tbody>
            <div class="flex justify-center mt-4">
               <div>{{ $customers->links() }}</div>
            </div>
         </table>
      </div>
   </div>
</div>
<!--  -->
@endsection