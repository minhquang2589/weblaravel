@extends('admin.dashboard')

@section('title', 'Slider')
<!--  -->
@section('content')
<div class="">
   <div class="flex mt-14 mb-10 ml-20">
      <h3><strong class="text-xl">Update slider</strong></h3>
   </div>
   <div class="flex justify-center mb-4">
      <table class="lg:w-1/2 w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm">
         <thead class="ltr:text-left rtl:text-right">
            <tr>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Image</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Name</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Status</th>
            </tr>
         </thead>
         <tbody class="divide-y divide-gray-200">
            @if ( isset($slider))
            @foreach($slider as $value)
            <tr>
               <td class="text-gray-900">
                  <div class="w-28 h-28">
                     <img src="{{ asset('images/' . $value->image) }}" alt="{{ $value->name }}" class="object-cover transition duration-500 group-hover:scale-105" />
                  </div>
               </td>
               <td>{{$value->name}}</td>
               <td>
                  @if ($value->status)
                  <p class="text-red-600">Active</p>
                  @else
                  <p class="text-red-600">Not Active</p>
                  @endif
               </td>
               <td>
                  <form action="{{ route('slider.delete', ['id' => $value->id]) }}" method="POST">
                     @csrf
                     @method('DELETE')
                     <button onclick="return confirm('Do you want to delete?')" type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full">
                        Delete
                     </button>
                  </form>
               </td>
               <td>
                  <form action="{{ route('slider.update', ['id' => $value->id]) }}" method="GET">
                     @csrf
                     <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full">
                        Update
                     </button>
                  </form>
               </td>
            </tr>
            @endforeach
            @else
            <tr>
               <td colspan="5">
                  <h1>No sliders</h1>
               </td>
            </tr>
            @endif
         </tbody>
      </table>
   </div>
</div>
@endsection