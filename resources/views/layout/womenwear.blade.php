@extends('dashboard')

@section('title', 'For Womens')

@section('content')
@if(Request::path()=='product/womens')
@include('layout.slider')
@endif
<div class="my-5 mb-3 mx-3 flex justify-center	">
   <a href="">
      <div class="font-medium text-sm text-gray-600 hover:text-gray-800">For Women's</div>
   </a>
</div>
<!--  -->
<span class="flex items-center">
   <span class="h-px flex-1 bg-gray-300"></span>
</span>
<!--  -->
<div class="my-2 mx-10 mt-3 ml-6">
   <nav aria-label="Breadcrumb">
      <ol class="flex items-center gap-1 text-sm text-gray-600">
         <li>
            <a href="{{url('')}}" class="block transition hover:text-gray-700">
               <span class="sr-only"> Home </span>
               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
               </svg>
            </a>
         </li>
         <li class="rtl:rotate-180">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
               <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
         </li>
         <li>
            <a href="" class="block transition hover:text-gray-700"> Women's </a>
         </li>
      </ol>
   </nav>
</div>
<!-- product  -->
<div class="grid grid-cols-1 lg:grid-cols-6 lg:px-2">
   <div class="h-full px-2 standing ">
      @include('layout.filter')
   </div>
   <div class="h-fit moving rounded-lg  lg:col-span-5">
      <div id="womenContainer" class="grid grid-cols-2 lg:mx-6 lg:grid-cols-4 2xl:grid-cols-5 lg:gap-2"></div>
      <div class="flex mt-2 w-full items-center justify-center ">
         <button class="text-gray-800  hover:underline" id="loadMoreWomenButton">Load more</button>
      </div>
   </div>
</div>

<script>
   document.addEventListener("DOMContentLoaded", function() {
      getWomenProduct()

   });
   ////get women product
   var womenPage = 1;
   var womenisLoading = false;

   function getWomenProduct() {
      if (womenisLoading) return;
      womenisLoading = true;
      $.ajax({
         type: 'GET',
         url: "{{ route('get.women.product') }}",
         data: {
            page: womenPage
         },
         success: function(response) {
            if (response.success) {
               if (response.productforwomen.length > 0) {
                  var products = response.productforwomen;
                  var productsHtml = '';
                  products.forEach(function(product) {
                     var priceVND = product.price.toLocaleString('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                     });
                     var discountBadge = '';
                     if (product.discount_quantity > 0 && product.status == 'Active' && product.discount>0) {
                        discountBadge = '<span class="mr-1 text-red-600 px-1 py-0.5 text-xs font-medium">- ' + product.discount + '%</span>';
                     }
                     var isNewBadge = '';
                     if (product.is_new) {
                        isNewBadge = '<span class="rounded-full mr-1 text-white bg-red-600 px-1 py-0.5 lg:px-2 lg:py-1 text-xs"> New </span>';
                     }
                     var productHtml = `
                                <div class="w-full rounded-lg">
                                    <div class="group rounded-xl relative block overflow-hidden">
                                        <button class="absolute end-4 top-4 z-10 p-1">${discountBadge}</button>
                                        <div>
                                            <img src="{{ asset('images/') }}/${product.image}" alt="${product.image}" class="primage rounded-t-2xl w-full object-cover transition duration-500 group-hover:scale-105" />
                                        </div>
                                        <div class="relative p-6">
                                            <div class="flex items-baseline lg:items-start">
                                                <h3 class="mr-3 flex text-[11px] lg:text-sm font-medium">${product.name}</h3>
                                                <div class="mr-4">${isNewBadge}</div>
                                            </div>
                                            <p class="mt-1.5 text-[11px] lg:text-sm text-gray-600 transition hover:text-gray-800">${priceVND}</p>
                                            <div>
                                                <a data-product-id="${product.id}" id="addToCartBtnView${product.id}" class="group relative justify-center flex items-center overflow-hidden rounded-full border py-1.5 mt-2 g:mt-3 lg:mx-10 lg:py-1.5 text-gray-500 focus:outline-none focus:ring active:text-gray-600">
                                                    <div>
                                                        <button class="text-sm font-medium transition-all group-hover:me-4">View Product</button>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                     productsHtml += productHtml;
                  });
                  $('#womenContainer').append(productsHtml);
                  womenisLoading = false;
                  womenPage++;
               } else {
                  $('#loadMoreWomenButton').text('End').prop('disabled', true).addClass('sold-out-ticket');
               }
            }
         },
         error: function(xhr, status, error) {
            // console.log(response);
            womenisLoading = false;
         }
      });
   }
   $('#loadMoreWomenButton').click(function() {
      getWomenProduct();
   });
</script>
@endsection