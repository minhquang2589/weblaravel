<div class="flex items-center justify-between bg-gray-600">
   <div>
      <span class="ml-3 text-white text-sm"> Admin {{$userData['name']}}</span>
   </div>
   <div class="text-white text-sm">
      <div class="flex">
         <a class="hover:underline" href="/admin">Dashboard</a>
      </div>
   </div>
   <div class="text-white mt-1 text-sm mr-3">
      <span class="hover:underline">
         @php
         if (Auth::check()) {
         echo '<a href="/logout"><span>Logout</span></a>';
         } else {
         echo '<a href="/login"><span>Login</span></a>';
         }
         @endphp
      </span>
   </div>


</div>