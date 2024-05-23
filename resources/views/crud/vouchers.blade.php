@extends('admin.dashboard')

@section('title', 'Update Products')
<!--  -->
@section('content')
<div class="mx-6 lg:mx-0">
   <div class="flex justify-start mt-14 mb-10 ml-20">
      <h3><strong class="text-3xl">Update vouchers</strong></h3>
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
            </tr>
         </thead>
         @if(isset($Vouchers))
         <tbody class="divide-y divide-gray-200">
            <tr>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $Vouchers->voucher_code }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $Vouchers->discount_value }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $Vouchers->voucher_quantity }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $Vouchers->status }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $Vouchers->start_date }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $Vouchers->end_date }}</td>
            </tr>
         </tbody>
         @endif
      </table>
   </div>
   <form class="max-w-md mx-auto" method="POST" action="{{ route('edit.vouchers', ['id' => $Vouchers->id]) }}">
      @csrf
      <input type="hidden" value="{{$Vouchers->id}}" name="voucher_id">
      <div class="relative z-0 w-full mb-5 mt-4 group">
         <input type="text" value="{{ $Vouchers->voucher_code }}" name="voucher_code" id="voucher_code" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
         <label for="voucher_code" name="voucher_code" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Voucher code</label>
      </div>
      <div class="mt-2">
         <label for="start_datetime" class="text-sm">Start day:</label>
         <input type="datetime-local" class="text-sm" id="start_datetime" name="start_datetime" value="{{ $Vouchers->start_datetime ?? '' }}">
         <br>
         <label for="end_datetime" class="text-sm">End day:</label>
         <input type="datetime-local" id="end_datetime" class="text-sm" name="end_datetime" value="{{ $Vouchers->end_datetime ?? '' }}">
         <br>
         <div class="flex my-3">
            <input type="number" value="{{ $Vouchers->discount_value }}" name="discount_value" placeholder="Discount %" min="0" max="100" oninput="validity.valid||(value='');" class=" w-2/3  px-3 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" />
            |
            <input type="number" value="{{ $Vouchers->voucher_quantity }}" name="voucher_quantity" placeholder="Vouchers Quantity" min="0" oninput="validity.valid||(value='');" class=" w-2/3  px-3 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" />
         </div>
         <div class="w-full">
            <div class="">
               <select id="status" name="status" class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option hidden disabled>Choose a status</option>
                  <option value="Active" {{ $Vouchers->status === 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Used" {{ $Vouchers->status === 'Used' ? 'selected' : '' }}>Used</option>
                  <option value="Expired" {{ $Vouchers->status === 'Expired' ? 'selected' : '' }}>Expired</option>
               </select>

            </div>
         </div>
      </div>
      @if (session('success'))
      <div class="alert text-blue-600 mt-2 alert-success">
         <strong>{{ session('success') }} </strong>
      </div>
      @endif
      @if (session('error'))
      <div class="alert text-red-600 mt-2 alert-danger">
         <strong>{{ session('error') }}</strong>
      </div>
      @endif

      @if ($errors->any())
      <div class="alert alert-danger">
         <ul class="mb-1">
            @foreach ($errors->all() as $error)
            <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
               <li class="block sm:inline text-xs">{{ $error }}</li>
            </div>
            @endforeach
         </ul>
      </div>
      @endif
      <div class="mb-5 mt-2 w-full">
         <div class="flex justify-start lg:flex lg:justify-start">
            <button type="submit" id="submit-button" class="text-white mt-6 bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-1/2 sm:w-auto px-20 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
         </div>
   </form>

</div>
@endsection