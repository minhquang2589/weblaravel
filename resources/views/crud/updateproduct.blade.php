@extends('admin.dashboard')
@section('title', 'Update Products')
@section('content')
<style>
   .color-input label {
      margin-right: 10px;
   }

   .colorInputs input {
      margin: 2px;
      font-size: 0.875rem;
      border: 2px;
      border-color: #3b82f6;
      color: black;

   }
</style>
<div class="mx-6 lg:mx-0">
   <div class="flex justify-start mt-14 mb-10 ml-20">
      <h3><strong class="text-3xl">Update Product</strong></h3>
   </div>
   <div class="flex justify-center">
      <div class="mb-4">
         <div>
            <table class="lg:w-1/2 w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm">
               <thead class="ltr:text-left rtl:text-right">
                  <tr>
                     <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Name</th>
                     <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Price</th>
                     <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Color</th>
                     <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Size</th>
                     <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Discount</th>
                     <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Is_New</th>
                  </tr>

               </thead>
               <tbody class=" divide-gray-200">
                  <tr>
                     <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{$product->name}}</td>
                     <td class="whitespace-nowrap px-4 py-2 text-gray-900">{{ number_format($product->price/ 1000, 3, ',', ',') }}đ</td>
                     <td class="text-[11px] pl-4 py-2 text-gray-900 ">
                        @foreach($stock->where('product_id', $product->id) as $productVariant)
                        @if($productVariant->color)
                        {{ $productVariant->color->color }}
                        <span class="flex items-center">
                           <span class="h-px flex-1 bg-gray-500"></span>
                        </span>
                        @endif
                        @endforeach
                     </td>
                     <td class=" py-2 text-[11px] text-gray-900">
                        @foreach($stock->where('product_id', $product->id) as $productVariant)
                        @if($productVariant->size)
                        {{ $productVariant->size->size }} - {{ $productVariant->quantity }}
                        <span class="flex items-center">
                           <span class="h-px flex-1 bg-gray-500"></span>
                        </span>
                        @endif
                        @endforeach
                     </td>
                     <td class="whitespace-nowrap px-4 py-2 text-gray-900">
                        @if (isset($discountInfo->discount))
                        {{ $discountInfo-> discount}}% -
                        {{ $discountInfo-> total_quantity}}
                        @else
                        <span class="rounded-full ml-2 text-white bg-red-600 px-2 py-1 text-xs">No</span>
                        @endif
                        <br>

                     </td>
                     <td class="px-4 py-2 text-gray-900">
                        @if ($product->is_new)
                        <p class="rounded-full ml-2 text-white bg-red-600 px-2 py-1 text-xs">new</p>
                        @else
                        <p class="rounded-full ml-2 text-white bg-red-600 px-3 py-1 text-xs">Not new</p>
                        @endif
                     </td>
                  </tr>
               </tbody>
            </table>
            <p class="font-medium text-gray-900 text-sm ml-5">Images</p>
            <span class="flex items-center">
               <span class="h-px flex-1 bg-gray-500"></span>
            </span>
         </div>
         <div>

            <table class="lg:w-1/2 w-full mx-2 lg:mx-0 divide-gray-200 bg-white text-sm">
               <tbody class=" divide-gray-200">

                  <tr>
                     @foreach($productImages as $value)
                     <td class=" text-gray-900">
                        <div class="w-28 h-28">
                           <img src="{{ asset('images/' . $value -> image) }}" alt="Images" class="object-cover transition duration-500 group-hover:scale-105" />
                        </div>
                     </td>

                     @endforeach
                  </tr>
               </tbody>
            </table>
         </div>
         <span class="flex items-center mb-3">
            <span class="h-px flex-1 bg-gray-500"></span>
         </span>
      </div>
   </div>
   <form id="clothingForm" class="max-w-md mx-auto" method="POST" action="{{ route('update.product', ['id' => $product->id]) }}" enctype="multipart/form-data">
      @csrf
      @if (session('success'))
      <div class="alert text-blue-600 alert-success mb-3">
         <strong>{{ session('success') }} </strong>
      </div>
      @endif
      <input type="hidden" name="product_id" value="{{$product->id}}">

      <div class="relative z-0 w-full mb-5 group">
         <input type="text" value="{{$product->name}}" name="product_name" id="product_name" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
         <label for="product_name" name="product_name" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Product Name</label>
      </div>
      <div class="relative z-0 w-full mb-2 group">
         <input require type="text" value="{{$product->price}}" name="price" id="price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" />
         <label for="price" name="price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Price</label>
      </div>

      <div class="form-group flex">
         <label>
            <input class="size-4 rounded border-gray-300" type="checkbox" name="is_new" {{ $product->is_new == 1 ? 'checked' : '' }}>
            <span class="text-red-600 ml-3">New</span>
         </label>
      </div>
      <div class="max-w-lg">
         <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Images</label>
         <input require class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" aria-describedby="images" for="images" type="file" id="image-input" name="images[]" multiple>
      </div>
      <div class="colorInputs mt-3" id="colorInputs"> </div>
      <button class="block mr-2 rounded-xl bg-gray-400 px-8 py-1 text-sm text-white transition hover:bg-gray-500" type="button" onclick="addColorInput()">Add color and quantity</button>
      <div class="mt-4">
         <div class="w-full mr-5">
            <div class="">
               <select id="gender" for="gender" name="gender" class="block w-full px-3 sm:px-3 lg:px-5 pt-2 pb-1 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                  <option hidden selected disabled>Choose a gender</option>
                  <option for="gender" value="Men" {{ $productCate->gender === 'Men' ? 'selected' : '' }}>Men</option>
                  <option for="gender" value="Women" {{ $productCate->gender === 'Women' ? 'selected' : '' }}>Women</option>
                  <option for="gender" value="Unisex" {{ $productCate->gender === 'Unisex' ? 'selected' : '' }}>Unisex</option>
               </select>
            </div>
         </div>
      </div>
      <div class="mt-3">
         <textarea class="w-full" name="description" id="editor">{{$product->description}}</textarea>
      </div>

      <!--  -->
      <div class="mb-5 w-full">
         <div class="flex justify-start lg:flex lg:justify-start">
            <button type="submit" id="submit-button" class="text-white mt-6 bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-2xl text-sm w-1/2 sm:w-auto px-20 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
         </div>
   </form>
</div>
</div>
<script>
   let colorCounter = 0;

   function addColorInput() {
      const colorInputsDiv = document.getElementById("colorInputs");
      const colorInputDiv = document.createElement("div");
      colorInputDiv.classList.add("color-input");
      const colorLabel = document.createElement("label");
      colorLabel.textContent = "Color:";
      const colorInput = document.createElement("input");
      colorInput.type = "text";
      colorInput.name = `colors[${colorCounter}]`;
      colorInputDiv.appendChild(colorLabel);
      colorInputDiv.appendChild(colorInput);
      const br = document.createElement("br");
      colorInputDiv.appendChild(br);
      const sizes = ["S", "M", "L", "XL", "2XL"];
      sizes.forEach((size, index) => {
         const sizeLabel = document.createElement("label");
         sizeLabel.textContent = `Size ${size}:`;
         const quantityInput = document.createElement("input");
         quantityInput.type = "number";
         quantityInput.name = `quantities[${colorCounter}][${size}]`;
         const br = document.createElement("br");
         colorInputDiv.appendChild(sizeLabel);
         colorInputDiv.appendChild(quantityInput);
         colorInputDiv.appendChild(br);
      });
      colorInputsDiv.appendChild(colorInputDiv);
      colorCounter++;
   }
   ClassicEditor
      .create(document.querySelector('#editor'), {
         ckfinder: {
            uploadUrl: "{{ route('upload.file') }}?_token={{ csrf_token() }}"
         },
      })
      .catch(error => {
         console.error(error);
      });
</script>

@endsection