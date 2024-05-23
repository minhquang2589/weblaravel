@extends('admin.dashboard')

@section('title', 'Section - Edit')
<!--  -->
@section('content')
<div class="">
   <div class="flex mt-14 mb-10 ml-20">
      <h3><strong class="text-xl">Section update</strong></h3>
   </div>
   <div class="flex justify-center mb-4">
      <table class="lg:w-1/2 w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm">
         <thead>
            <tr>
               <th class="px-4 py-2 font-medium text-gray-900">Image</th>
               <th class="px-4 py-2 font-medium text-gray-900">Status</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Title</th>
               <th class=" px-4 py-2 font-medium text-gray-900">Action</th>
            </tr>
         </thead>
         <tbody class="divide-y divide-gray-200">
            @if ( isset($section_02) && $section_02->count() > 0)
            @foreach($section_02 as $value)
            <tr>
               <td class="text-gray-900">
                  <div class="w-28 h-28">
                     <img src="{{ asset('images/' . $value->image) }}" alt="{{ $value->name }}" class="object-cover transition duration-500 group-hover:scale-105" />
                  </div>
               </td>
               <td>
                  @if ($value->status)
                  <p class="text-red-600">Active</p>
                  @else
                  <p class="text-red-600">Not Active</p>
                  @endif
               </td>
               <td class=" px-4 py-2 text-gray-900">{{ $value->title }}</td>
               <td>
                  <form action="{{ route('section_02.delete') }}" method="POST">
                     @csrf
                     <input type="hidden" name="sectionID" value="{{$value->id}}">
                     <button onclick="return confirm('Do you want to delete?')" type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full">
                        Delete
                     </button>
                  </form>
               </td>
               <td>
                  <form action="{{ route('section_02.update',['section_id' => $value->id ]) }}" method="get">
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
                  <h1>No sections</h1>
               </td>
            </tr>
            @endif
         </tbody>
      </table>
   </div>
</div>


@endsection