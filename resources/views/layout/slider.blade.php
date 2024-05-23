<!-- slider  -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- Demo styles -->
<style>
   .slider_1 {
      position: relative;
      height: 100%;
      margin: 0px 10px 0px 10px;
   }

   .slider_1 {
      height: 500px;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #fff;
      margin: 0;
      padding: 0;
   }

   @media screen and (max-width: 720px) {
      .slider_1 {
         height: 290px;
         margin: 0px 5px 0px 5px;
      }
   }

   @media screen and (max-width: 1000px) {
      .slider_1 {
         height: 350px;
         margin: 0px 5px 0px 5px;
      }
   }

   .swiper_1 {
      width: 100%;
      height: 100%;
   }

   .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
   }

   .swiper-slide img {
      display: block;
      height: 100%;
      object-fit: cover;
   }


   .swiper-image {
      height: 100%;
   }
   .swiper{
      z-index: 1;
   }

   /* .slider-button-next {
      color: gray;
      display: none;
   }

   .slider-button-prev {
      color: gray;
      display: none;
   } */
</style>
<div class="swiper-container swiper">
   <div class="slider_1">
      <div class="swiper_1 mySwiper_1">
         <a class="swiper-wrapper">
            @if(isset($slider))
            @foreach($slider as $product)
            <div class="swiper-slide swiper-image">
               <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->image }}" />
            </div>
            @endforeach
            @else
            <div><img src="" alt="null image"></div>
            @endif
         </a>
         <!-- <div class="swiper-button-next slider-button-next"></div>
         <div class="swiper-button-prev slider-button-prev"></div> -->
         <div class="swiper-pagination"></div>
         <div class="autoplay-progress ">
            <svg style="display: none;"></svg>
            <span style="display: none;"></span>
         </div>
      </div>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
   const progressCircle = document.querySelector(".autoplay-progress svg");
   const progressContent = document.querySelector(".autoplay-progress span");
   var swiper1 = new Swiper(".mySwiper_1", {
      spaceBetween: 5,
      centeredSlides: true,
      autoplay: {
         delay: 1300,
         disableOnInteraction: false
      },
      pagination: {
         el: ".swiper-pagination",
         clickable: true
      },
      navigation: {
         nextEl: ".swiper-button-next",
         prevEl: ".swiper-button-prev"
      },
      on: {
         autoplayTimeLeft(s, time, progress) {
            progressCircle.style.setProperty("--progress", 1 - progress);
            progressContent.textContent = `${Math.ceil(time / 1300)}s`;
         }
      }
   });
</script>