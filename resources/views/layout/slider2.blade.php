<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
   .sl_2 {
      position: relative;
      height: 100%;
   }

   .sl_2 {
      background: #eee;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      margin: 0;
      padding: 0;
   }



   .swiper {
      width: 100%;
      height: 100%;
   }

   .swiper-slide {
      text-align: center;
      font-size: 18px;
      /* background: #fff; */
      display: flex;
      justify-content: center;
      align-items: center;
   }

   .swiper-button-next,
   .swiper-button-prev {
      color: gray;
   }

   .swiper-pagination {
      color: gray;
   }

   .img2 {
      display: flex;
      height: 88%;
   }

   @media screen and (max-width: 720px) {
      .sl_2 {
         height: 120px;
         width: 100%;
      }

      .swiper-button-next {
         width: 10px;
      }

      .img2 {
         height: 100%;
      }
   }

   @media screen and (max-width: 1000px) {
      .sl_2 {
         height: 70%;
         width: 100%;
      }

      .swiper-button-next {
         width: 10px;
      }

      .img2 {
         height: 100%;
      }
   }
</style>

<div class="sl_2">
   <!-- Swiper -->
   <div class="swiper mySwiper-2">
      <div class="swiper-wrapper img2 ">
         @if(isset($discountProduct))
         @foreach( $discountProduct as $product)
         @if ($product->discount_quantity > 0 && $product->discount>0)
         <div class="swiper-slide">
            <div class="group  rounded-xl relative block overflow-hidden">
               <div class="flex justify-center">
                  <a class="absolute end-1 top-1 lg:end-4 lg:top-6 z-10 lg:p-1">
                     <span class="rounded-full mr-1 lg:text-white text-red-600 lg:bg-red-600 lg:px-1.5 lg:py-0.5 text-xs font-medium">- {{ $product->discount }}%</span>
                  </a>
               </div>
               <a class="z-10" data-product-id="{{ $product->id }}" id="addToCartBtnView{{$product->id}}">
                  <img class="img_slider object-cover transition duration-500 group-hover:scale-105" src="{{ asset('images/' . $product->image) }}" alt="{{ $product->image }}" />
               </a>
            </div>
         </div>
         @endif
         @endforeach
         @else
         <h1>No products</h1>
         @endif
      </div>
      <div>
         <div class="swiper-button-next"></div>
         <div class="swiper-button-prev"></div>
      </div>
      <div class="swiper-pagination "></div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script>
      var swiper2 = new Swiper(".mySwiper-2", {
         slidesPerView: 3,
         // spaceBetween: 1,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
            type: "fraction",
         },
         navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
         },
         breakpoints: {
            768: {
               slidesPerView: 4,
            },
            1000: {
               slidesPerView: 5,
            },
         },
      });
   </script>
</div>
<!-- 
<div class="sl_2">
   <div class="swiper mySwiper-3">
      <div class="swiper-wrapper">
         @if(isset($products))
         @foreach( $products as $product)
         <div class="swiper-slide">
            <div class="group  rounded-xl relative block overflow-hidden">
               <div class="flex justify-center">
                  <button class="absolute end-1 top-1 lg:end-4 lg:top-6 z-10 lg:p-1">
                     @if ($product->discount_quantity > 0)
                     <span class="rounded-full mr-1 lg:text-white text-red-600 lg:bg-red-600 lg:px-1.5 lg:py-0.5 text-xs font-medium">- {{ $product->discount }}%</span>
                     @endif
                  </button>
               </div>

               <img class="img_slider object-cover transition duration-500 group-hover:scale-105" src="{{ asset('images/' . $product->image) }}" alt="{{ $product->image }}" />
            </div>
         </div>
         @endforeach
         @endif
      </div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-pagination"></div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
   <script>
      var swiper2 = new Swiper(".mySwiper-3", {
         slidesPerView: 3,
         spaceBetween: 2,
         manipulation: true,
         pagination: {
            el: ".swiper-pagination",
            clickable: true,
         },
         navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
         },
         breakpoints: {
            768: {
               slidesPerView: 4,
            },
         },
      });
   </script>
</div> -->