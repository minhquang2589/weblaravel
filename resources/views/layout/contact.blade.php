<!--  -->

@extends('dashboard')

@section('title', 'Contact')

@section('content')
<!--  -->
<span class="flex items-center">
   <span class="h-px flex-1 bg-slate-100"></span>
</span>
<div class="my-2 ml-3 ">
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
            <a href="" class="block transition hover:text-gray-700">Contact</a>
         </li>
      </ol>
   </nav>
</div>
<!-- contact  -->
<div class="flex justify-center">
   <div class="mt-14 grid grid-cols-1 gap-2 lg:grid-cols-3 lg:gap-5">
      <div class="h-h-fit  ">
         <h1><strong class=" flex justify-center italic lg:col-span-1">CONTACT </strong></h1>
      </div>
      <div class="h-96 w-full lg:col-span-1">
         <span class="text-sm italic">CUSTOMER SERVICE</span>
         <p class="text-xs mt-20 italic">If you have any questions, please contact via this email: </p>
         <p class="text-xs">Ngominhquang724@gmail.com</p>
         <p class="text-xs mt-8 italic">Return Address:</p>
         <p>Viet Nam, Ha Noi, My Dinh, Tu Liem</p>
         <p class="text-xs	mt-0">Vietnam: +84 12345678</p>
         <p class="text-xs	">Japanese: +84 12345678</p>
         <p class="text-xs mt-1 italic	">Monday to Sunday 10am—8pm!</p>
         <p class="text-xs mt-10 italic"><strong>Thank You!</strong></p>
      </div>
      <div class="w-full h-full">
         <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d5519.541481512484!2d105.77900925393396!3d21.028098869540546!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1713101578257!5m2!1svi!2s" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
   </div>
</div>

@endsection