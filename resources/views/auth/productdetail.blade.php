   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

   <style>
      .productdetail {
         /* position: relative; */
         height: 100%;
         font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
         font-size: 14px;
         margin: 0;
         padding: 0;

      }

      .swiper {
         width: 83%;
         height: 100%;
      }

      .image-detail {
         text-align: center;
         font-size: 18px;
         display: block;
         width: 90%;
         height: 100%;
         object-fit: cover;
         margin-left: auto;
         margin-right: auto;
      }


      .button-next {
         color: gray;
         
      }

      .button-prev {
         color: gray;
      }

      @media screen and (max-width: 1000px) {
         .swiper {
            width: 97%;
            height: 100%;
         }

         .image-detail {
            text-align: center;
            display: block;
            width: 90%;
            height: 100%;
            object-fit: cover;
            margin-left: auto;
            margin-right: auto;
         }
      }

      @media only screen and (max-width: 768px) {
         .swiper {
            width: 98%;
            height: 100%;
         }

         .image-detail {
            text-align: center;
            display: block;
            width: 90%;
            height: 100%;
            object-fit: cover;
            margin-left: auto;
            margin-right: auto;
         }
      }
   </style>
   <div class="productdetail">
      <div class="swiper mySwiper">
         <div class="swiper-wrapper">
            @if(!empty($ProductDetailImg))
            @foreach($ProductDetailImg as $values)
            <div class="swiper-slide">
               <img class="image-detail" src="{{ asset('images/' . $values->image) }}" alt="{{ $values->image }}" />
            </div>
            @endforeach
            @else
            <div><img src="" alt="null image"></div>
            @endif
         </div>
         <div class=" button-next swiper-button-next"></div>
         <div class=" button-prev swiper-button-prev"></div>
         <div class="swiper-pagination"></div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <script>
         var swiper = new Swiper(".mySwiper", {
            pagination: {
               el: ".swiper-pagination",
               type: "fraction",
            },
            navigation: {
               nextEl: ".swiper-button-next",
               prevEl: ".swiper-button-prev",
            },
         });
      </script>
   </div>