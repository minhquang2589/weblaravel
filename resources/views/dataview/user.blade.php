<!-- -->
@extends('admin.dashboard')
@section('title', 'User Managements')
@section('content')
<!-- -->
<div class="flex justify-center mt-20	">
   <div class="overflow-x-auto mr-5 w-9/12 rounded-lg border border-gray-200">
      <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
         <thead class="ltr:text-left rtl:text-right">
            <tr>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">ID</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Name</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Phone</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Genders</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Email</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Address</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Birthday</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Role</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Created_at</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Updated_at</th>
               <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Action</th>
            </tr>
         </thead>
         <tbody class="divide-y divide-gray-200">
            @foreach($users as $user)
            <tr>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->id}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->name}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->phone}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->genders}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->email}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->address}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->birthday}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->role}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->created_at}}</td>
               <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-700">{{$user->updated_at}}</td>
               <td><a href=""></a><button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                     Edit
                  </button></td>
               <td>
                  <form action="{{ route('usermanagement.delete', ['id' => $user->id]) }}" method="POST">
                     @csrf
                     @method('DELETE')
                     <button onclick="return confirm('Do you want to delete this user?')" type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full">
                        Delete
                     </button>
                  </form>
               </td>
            </tr>
            @endforeach
         </tbody>
         <div class="flex justify-center mt-4">
            <div>{{ $users->links() }}</div>
         </div>
      </table>
   </div>
</div>




<!--  -->
@endsection