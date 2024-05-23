<div class="space-y-2">
   <div class="overflow-hidden rounded border border-gray-400">
      <div class="flex items-center justify-between gap-2 bg-white p-4 text-gray-900 transition">
         <span class="text-sm font-medium">Filter</span>
      </div>
      <div class="border-t border-gray-300 bg-white">
         <ul class="space-y-1 border-gray-200 p-4">
            <li>
               <div class="relative">
                  <input type="text" id="searchKey" name="searchKey" placeholder="Search for ..." class="w-full rounded-md border border-gray-500 py-1 pe-10 sm:text-sm" />
                  <span class="absolute inset-y-0 end-0 grid w-10 place-content-center">
                     <button id="searchButton" type="button" class="text-gray-600 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                     </button>
                  </span>
               </div>
            </li>
         </ul>
      </div>
      <div class="border-t border-gray-200 p-4">
         <div>
            <label for="priceFrom" class="flex items-center gap-2">
               <input type="number" id="priceFrom" placeholder="From" class="w-full border py-0.5 rounded-md border-gray-200 shadow-sm sm:text-sm" />
               <span class="text-sm text-gray-600">đ</span>
            </label>
            <label for="priceTo" class="flex mt-2 items-center gap-2">
               <input type="number" id="priceTo" placeholder="To" class="w-full rounded-md py-0.5 border border-gray-200 shadow-sm sm:text-sm" />
               <span class="text-sm text-gray-600">đ</span>
            </label>
         </div>
      </div>
      <ul class="space-y-1 border-t border-gray-200 p-4">
         <li>
            <label for="filternew" class="inline-flex items-center gap-2">
               <input type="checkbox" id="filternew" class="size-4 rounded border-gray-300" />
               <div class="flex">
                  <span class="text-sm mr-1 font-medium text-gray-700">New</span>
                  <span id="newCount" class="text-sm font-medium text-gray-700"></span>
               </div>
            </label>
         </li>
         <li>
            <label for="filtersale" class="inline-flex items-center gap-2">
               <input type="checkbox" id="filtersale" class="size-4 rounded border-gray-300" />
               <div class="flex">
                  <span class="text-sm mr-1 font-medium text-gray-700">Discount</span>
                  <span id="saleCount" class="text-sm font-medium text-gray-700"></span>
               </div>
            </label>
         </li>
         <li>
            <label for="filterinstock" class="inline-flex items-center gap-2">
               <input type="checkbox" id="filterinstock" class="size-4 rounded border-gray-300" />
               <div class="flex">
                  <span class="text-sm mr-1 font-medium text-gray-700">In Stock </span>
                  <span id="instockCount" class="text-sm font-medium text-gray-700"></span>
               </div>
            </label>
         </li>
         <li>
            <label for="filteroutofstock" class="inline-flex items-center gap-2">
               <input type="checkbox" id="filteroutofstock" class="size-4 rounded border-gray-300" />
               <div class="flex">
                  <span class="text-sm mr-1 font-medium text-gray-700">Out of Stock</span>
                  <span id="outstockCount" class="text-sm font-medium text-gray-700"></span>
               </div>
            </label>
         </li>
      </ul>
      <ul class="space-y-1 border-t border-gray-200 p-2">
         <li>
            <div class="flex py-1 justify-center">
               <button id="resetFilters" type="button" class="text-sm  text-gray-900 hover:underline">
                  Reset
               </button>
            </div>
         </li>
      </ul>
   </div>
</div>