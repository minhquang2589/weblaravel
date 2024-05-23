@extends('admin.dashboard')
@section('title', 'Discounts')
@section('content')
<div class="mx-6 lg:mx-0">
   <div class="flex justify-start mt-14 mb-10 ml-20">
      <h3><strong class="text-3xl">Discounts Edit</strong></h3>
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
            </tr>
         </thead>
         @isset($discountEdit)
         <tbody class="divide-y divide-gray-200">
            <tr>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $discountEdit->discount }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $discountEdit->quantity }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $discountEdit->remaining }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $discountEdit->status }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $discountEdit->start_datetime }}</td>
               <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ $discountEdit->end_datetime }}</td>
            </tr>
         </tbody>
         @endif
      </table>
   </div>
   <form class="max-w-md mx-auto" method="POST" action="{{ route('discount.update') }}">
      @csrf
      <input type="hidden" name="discount_id" value="{{ $discountEdit->id }}">
      <div class="mt-2">
         <label for="start_datetime" class="text-sm">Start discount:</label>
         <input type="datetime-local" value="{{ $discountEdit->start_datetime }}" class="text-sm" id="start_datetime" name="start_datetime">
         <br>
         <label for="end_datetime" class="text-sm">End discount:</label>
         <input type="datetime-local" value="{{ $discountEdit->end_datetime }}" id="end_datetime" class="text-sm" name="end_datetime">
         <br>
         <div class="flex my-3">
            <input type="number" value="{{ $discountEdit->discount }}" name="discountnumber" placeholder="Discount %" min="0" max="100" oninput="validity.valid||(value='');" class="w-2/3 px-3 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" />
            |
            <input type="number" value="{{ $discountEdit->quantity }}" name="discountquantity" placeholder="Discount Quantity" min="0" oninput="validity.valid||(value='');" class="w-2/3 px-3 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" />
         </div>
         <input type="number" value="{{ $discountEdit->remaining }}" name="remaining" placeholder="Renaining" min="0" oninput="validity.valid||(value='');" class="w-full px-3 text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600" />
      </div>
      <div class="mt-2">
         <div class="w-full">
            <div class="">
               <select id="status" name="status" class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option hidden disabled>Choose a status</option>
                  <option value="Active" {{ $discountEdit->status === 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Used" {{ $discountEdit->status === 'Used' ? 'selected' : '' }}>Used</option>
                  <option value="Expired" {{ $discountEdit->status === 'Expired' ? 'selected' : '' }}>Expired</option>
               </select>
            </div>
         </div>
      </div>
      @if (session('success'))
      <div class="alert text-blue-600 mt-2 alert-success">
         <strong>{{ session('success') }}</strong>
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
      </div>
   </form>
</div>
@endsection