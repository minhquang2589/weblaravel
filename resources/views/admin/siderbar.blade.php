<div class="flex w-full h-screen flex-col justify-between border-e">
   <div class="px-4 py-6">
      <ul class=" space-y-1">
         <li>
            <details class="group [&_summary::-webkit-details-marker]:hidden">
               <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black">
                  <span class="text-sm font-medium">Products </span>
                  <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                     </svg>
                  </span>
               </summary>
               <ul class="mt-2 space-y-1 px-4">
                  <li>
                     <a href="/uploadproduct" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black">
                        Upload
                     </a>
                  </li>

                  <li>
                     <a href="/producttable" class="block rounded-lg px-4 py-2 text-sm font-medium  text-gray-800 hover:bg-gray-300 hover:text-black">
                        Update
                     </a>
                  </li>
               </ul>
            </details>
         </li>
         <li>
            <details class="group [&_summary::-webkit-details-marker]:hidden">
               <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black">
                  <span class="text-sm font-medium">Vouchers </span>
                  <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                     </svg>
                  </span>
               </summary>
               <ul class="mt-2 space-y-1 px-4">
                  <li>
                     <a href="{{Route('vouchers.upload')}}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black">
                        Upload
                     </a>
                  </li>
                  <li>
                     <a href="{{Route('vouchers.view')}}" class="block rounded-lg px-4 py-2 text-sm font-medium  text-gray-800 hover:bg-gray-300 hover:text-black">
                        Update
                     </a>
                  </li>
               </ul>
            </details>
         </li>
         <li>
            <details class="group [&_summary::-webkit-details-marker]:hidden">
               <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black">
                  <span class="text-sm font-medium">Section </span>
                  <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                     </svg>
                  </span>
               </summary>
               <ul class="mt-2 space-y-1 px-4">
                  <li>
                     <a href="{{route('upload.section')}}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black">
                        Upload
                     </a>
                  </li>
                  <li>
                     <a href="{{route('section.nd')}}" class="block rounded-lg px-4 py-2 text-sm font-medium  text-gray-800 hover:bg-gray-300 hover:text-black">
                        Update
                     </a>
                  </li>
               </ul>
            </details>
         </li>
         <li>
            <details class="group [&_summary::-webkit-details-marker]:hidden">
               <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2 text-gray-800 hover:bg-gray-300 hover:text-black">
                  <span class="text-sm font-medium">Slider </span>
                  <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                     </svg>
                  </span>
               </summary>
               <ul class="mt-2 space-y-1 px-4">
                  <li>
                     <a href="{{route('slider.upload')}}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-300 hover:text-black">
                        Upload
                     </a>
                  </li>
                  <li>
                     <a href="/slider" class="block rounded-lg px-4 py-2 text-sm font-medium  text-gray-800 hover:bg-gray-300 hover:text-black">
                        Update
                     </a>
                  </li>
               </ul>
            </details>
         </li>
         <li>
            <a href="{{Route('discount.view')}}" class="block hover:bg-gray-300 rounded-lg text-gray-800 px-4 py-2 text-sm font-medium ">
               Discounts
            </a>
         </li>
         <li>
            <a href="/customers" class="block hover:bg-gray-300 rounded-lg text-gray-800 px-4 py-2 text-sm font-medium ">
               Customers
            </a>
         </li>
         <li>
            <a href="/ordermanagements" class="block hover:bg-gray-300 rounded-lg text-gray-800 px-4 py-2 text-sm font-medium ">
               Order Managements
            </a>
         </li>
         <li>
            <details class="group [&_summary::-webkit-details-marker]:hidden">
               <summary class="flex cursor-pointer items-center justify-between rounded-lg px-4 py-2  hover:bg-gray-300 hover:text-black">
                  <span class="text-sm font-medium"> Account </span>
                  <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                     </svg>
                  </span>
               </summary>
               <ul class="mt-2 space-y-1 px-4">
                  <li>
                     <a href="/usermanagement" class="block rounded-lg px-4 py-2 text-sm font-medium  text-gray-800 hover:bg-gray-300 hover:text-black">
                        User
                     </a>
                  </li>
               </ul>
            </details>
         </li>
      </ul>
   </div>
</div>