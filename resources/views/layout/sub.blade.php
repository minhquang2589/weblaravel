@extends('dashboard')
@section('title', 'Product')
@section('content')
<!-- contact  -->
<div class="">
  <div class="mx-auto max-w-screen-xl px-5 py-24 lg:flex lg:h-screen lg:items-center">
    <div class="mx-auto max-w-xl text-center">
      <h1 class="text-3xl font-extrabold sm:text-5xl">
        Thank you for subscribe
        <strong class="font-extrabold text-red-700 italic sm:block"> You will receive the latest product information sent to your registered email!</strong>
      </h1>
      <div class="mt-8 flex flex-wrap justify-center gap-4">
        <a class="block w-full rounded bg-red-600 px-12 py-3 text-sm font-medium text-white shadow hover:bg-red-700 focus:outline-none focus:ring active:bg-red-500 sm:w-auto" href="{{ url('/product') }}">
          Back to home
        </a>
      </div>
    </div>
  </div>
</div>
@endsection