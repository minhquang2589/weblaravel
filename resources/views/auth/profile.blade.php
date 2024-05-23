@extends('dashboard')
@section('title', 'Profile')
@section('content')
@if (!Auth::check())
@php
return redirect('login');
@endphp
@endif

<div class="my-2 ml-3">
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
        <a href="" class="block transition hover:text-gray-700">Profile </a>
      </li>
    </ol>
  </nav>
</div>
<!--  -->
<div>
  <div class="flex justify-center">
    <div class="mt-14 grid grid-cols-1 gap-4 lg:grid-cols-2 lg:gap-8">
      <div class="h-h-fit  ">
        <h1><strong class=" flex justify-center italic lg:col-span-1">Profile User </strong></h1>
      </div>
      <div class="h-96 w-full lg:col-span-1">
        <span class="text-sm italic">{{ $ProfileUser['name'] }}</span>
        <p class="text-xs">Email: {{ $ProfileUser['email'] }}</p>
        <p class="text-xs mt-8 italic">Address: {{ $ProfileUser['address'] }}</p>
        <p class="text-xs	mt-0">Phone: {{ $ProfileUser['phone'] }}</p>
      </div>
    </div>
  </div>
</div>
<!--  -->
<!--  -->


@endsection