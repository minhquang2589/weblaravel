<!-- -->
@extends('admin.dashboard')
@section('title', 'Table')
<!--  -->
@section('content')
<div class="">
   <div class="flex justify-start mt-20 ml-20">
      <h1><strong class="text-3xl">Product</strong></h1>
   </div>
   <div class="flex justify-center mt-7	">
      <div class="overflow-x-auto mr-5 w-9/12 rounded-lg border border-gray-200">
         <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
            <thead class="ltr:text-left rtl:text-right">
               <tr>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Name</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Price</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Color</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Size</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Image</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Is_New</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Sale count</th>
                  <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Action</th>
               </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
               @foreach($products as $product)
            <tbody class="divide-y divide-gray-200">
               <tr>
                  <td class=" px-4 py-2 text-gray-900">{{ $product->id }} - {{ $product->name }}</td>
                  <td class=" px-4 py-2 text-gray-900">{{ number_format($product->price/ 1000, 3, ',', ',') }}đ</td>
                  <td class=" pl-4 py-2 text-[11px] text-gray-900 ">
                     @foreach($stock->where('product_id', $product->id) as $productVariant)
                     @if($productVariant->color)
                     {{ $productVariant->color->color }}
                     <span class="flex items-center">
                        <span class="h-px flex-1 bg-gray-500"></span>
                     </span>
                     @endif
                     @endforeach
                  </td>
                  <td class="text-[11px] py-2 text-gray-900">
                     @foreach($stock->where('product_id', $product->id) as $productVariant)
                     @if($productVariant->size)
                     {{ $productVariant->size->size }} - {{ $productVariant->quantity }}
                     <span class="flex items-center">
                        <span class="h-px flex-1 bg-gray-500"></span>
                     </span>
                     @endif
                     @endforeach
                  </td>
                  <td>
                     <div class="w-28">
                        <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}" class="object-cover transition duration-500 group-hover:scale-105" />
                     </div>
                  </td>
                  <td>
                     @if ($product->is_new)
                     <p class=" flex justify-center rounded-full text-white bg-red-600 py-1 text-xs">new</p>
                     @else
                     <p class="flex justify-center rounded-full text-white bg-red-600 px-1.5 py-1 text-xs">Not new</p>
                     @endif
                  </td>
                  <td class=" flex justify-center mt-10 text-gray-900">{{ $product->sales_count }}</td>
                  <td>
                     <form action="{{ route('productmanagement.delete', ['id' => $product->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Do you want to delete this product?')" type="submit" class="bg-red-600 hover:bg-red-800 text-white font-bold py-2 px-4 rounded-full">
                           Delete
                        </button>
                     </form>
                  </td>
                  <td>
                     <form action="{{ route('product.edit', ['id' => $product->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-full">
                           Update
                        </button>
                     </form>
                  </td>
               </tr>
            </tbody>
            @endforeach
            </tbody>
         </table>
         <div class="mt-4 flex justify-center">
            <div class="p-1">{{ $products->links() }}</div>
         </div>
      </div>
   </div>
</div>
<!--  -->
@endsection