<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>@yield('title')</title>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.1/alpine.js"></script>
   <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
   @vite('resources/css/app.css')
   @vite('resources/css/header/header.css')
   <style>
      .standing {
         max-height: calc(100vh - 100px);
         overflow-y: auto;
         position: sticky;
         top: 65px;

      }


      @media screen and (max-width: 1000px) {
         .standing {
            display: none;
         }
      }

      @media only screen and (max-width: 768px) {
         .standing {
            display: none;
         }
      }
   </style>
</head>

<body>
   @include('layout.header')
   <span class="flex items-center">
      <span class="h-px flex-1 bg-gray-300"></span>
   </span>
   <div class="grid grid-cols-1 pb-16 gap-1 lg:grid-cols-6">
      <div class="h-fit standing ">
         @include('admin.siderbar')
      </div>
      <div class="h-full  lg:col-span-5">
         @yield('content')
      </div>
   </div>
</body>
<script>
   /////

   document.addEventListener("DOMContentLoaded", function() {
      updateViewCart();
      updateCartCount();
   });
   ///
   function openCart() {
      updateViewCart();
      var cart = document.getElementById("cart-view");
      var darken = document.querySelector(".darkenn");
      cart.style.display = "block";
      darken.classList.add("darken");
   }
   document.getElementById("cartQuantity").addEventListener("click", function() {
      openCart();
   });
   document.getElementById("cartQuantity").addEventListener("mouseenter", function() {
      openCart();
   });

   function closeCart() {
      var cart = document.getElementById("cart-view");
      cart.style.display = "none";
      var darken = document.querySelector(".darkenn");
      darken.classList.remove("darken");
   }

   document.getElementById("cart-view").addEventListener("mouseleave", function() {
      closeCart();
   });
   //////// update view cart
   function updateViewCart() {
      var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      $.ajax({
            type: "POST",
            url: "{{ route('cart.update.time') }}",
            data: {
               _token: csrfToken
            },
         }).done(function(response) {
            var cartData = response.cart;
            var cartItemsHtml = '';
            if (Object.keys(cartData).length > 0) {
               for (var key in cartData) {
                  var item = cartData[key];
                  var priceVND = item.price.toLocaleString('vi-VN', {
                     style: 'currency',
                     currency: 'VND'
                  });
                  cartItemsHtml += `
                        <div class="grid grid-cols-3 items-center ml-10 ">
                            <div class="">
                                <img src="/images/${item.image}" alt="" class="rounded object-cover">
                            </div>
                            <div class=" ml-4 mb-6">
                                <div class ="flex justify-start">
                                <p class=" mt-3 text-gray-800">${item.name}</p>
                                </div>
                                <p class="text-[10px] text-gray-600">Color: ${item.color}</p>
                                <p class=" text-[10px] text-gray-600">${item.quantity} x ${priceVND}</p>
                                <p class=" text-[10px] text-gray-600">Size: ${item.size}</p>
                            </div>
                            <div class="ml-4">
                                <form method="POST" action="{{ route('cart.view.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="${item.id}">
                                    <input type="hidden" name="size" value="${item.size}">
                                    <input type="hidden" name="color" value="${item.color}">
                                    <button type="button" class="text-gray-600 transition hover:text-red-600 remove-item-view-cart"
                                            data-product-id="${item.id}"
                                            data-size="${item.size}"
                                            data-color="${item.color}">
                                        <span class="sr-only">Remove item</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <span class="flex items-center">
                            <span class="h-px flex-1 bg-gray-300"></span>
                        </span>
                    `;
               }
            } else {
               cartItemsHtml = `
                    <p class="text-sm my-5 text-center text-gray-700">Your cart is empty!</p>
                    <span class="flex mt-2 items-center">
                        <span class="h-px flex-1 bg-gray-300"></span>
                    </span>
                `;
            }
            $('#cartItems').html(cartItemsHtml);
         })
         .fail(function(xhr, status, error) {
            // console.error(error);
         });
   }

   ////// xoá sản phẩm trong view cart 
   function deleteFormViewCart() {
      $('#cartItems').on('click', '.remove-item-view-cart', function(e) {
         e.preventDefault();
         var productId = $(this).data('product-id');
         var size = $(this).data('size');
         var color = $(this).data('color');
         $.ajax({
               type: 'POST',
               url: '{{ route("cart.view.remove") }}',
               data: {
                  _token: '{{ csrf_token() }}',
                  product_id: productId,
                  size: size,
                  color: color
               }
            })
            .done(function(response) {
               updateViewCart();
               updateCartCount();
               SubtotalTotal();
            })
            .fail(function(xhr, status, error) {
               console.error(error);
            });
      });
   }
   deleteFormViewCart();
   ///
   function updateCartCount() {
      $.ajax({
            url: "{{ route('cart.quantity') }}",
            method: 'GET',

         }).done(function(response) {
            $('#cartCount').text(response.cartQuantity);
         })
         .fail(function(xhr, status, error) {});
   }
</script>

</html>