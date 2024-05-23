
@extends('dashboard')

@section('title', 'About')

@section('content')
<div class="my-2 ml-3">
<nav aria-label="Breadcrumb">
  <ol class="flex items-center gap-1 text-sm text-gray-600">
    <li>
      <a href="{{url('')}}" class="block transition hover:text-gray-700">
        <span class="sr-only"> Home </span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
          />
        </svg>
      </a>
    </li>
    <li class="rtl:rotate-180">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4"
        viewBox="0 0 20 20"
        fill="currentColor"
      >
        <path
          fill-rule="evenodd"
          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
          clip-rule="evenodd"
        />
      </svg>
    </li>
    <li>
      <a href="" class="block transition hover:text-gray-700"> About </a>
    </li>
  </ol>
</nav>
</div>
<!--  -->
<!--  -->
<div id="about" class="relative bg-white mr-8 overflow-hidden mt-16">
    <div class="max-w-5xl  ">
        <div class="relative z-1 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
            <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white transform translate-x-1/2"
                fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                <polygon points="50,0 100,0 50,100 0,100"></polygon>
            </svg>
            <div class="pt-1"></div>
            <main class="mt-10 mx-auto max-w-9xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                <div class="sm:text-center lg:text-left">
                    <h2 class="italic my-5 text-2xl tracking-tight font-extrabold text-gray-900 sm:text-3xl md:text-4xl">
                        About me
                    </h2>
                    <h3 class="my-4 italic">Ngô Minh Quang!</h3>
                  <!-- content -->
                    <p class="text-sm">Until the porttitor, for as a protein pill, the bed of the tincidunt dui, he needs to decorate the bed from the non-free. For rhoncus diam ultrices porttitor laoreet. To warm up from, or cartoon network members. In order to decorate the ferry, let it be a lot of laoreet. Sed laoreet, no a posuere ultrices, pure no sad turpis, hendrerit rutrum augue as it is. Fusce malesuada to put free, life dapibus eros facilisis Euismod. But the policy is just as the developer wants. Mauris in the greatest eros.
                    </p>
                </div>
            </main>
        </div>
    </div>
    <!-- image content -->
    <div class="lg:absolute max-w-3xl  lg:inset-y-0 lg:right-0 lg:w-1/2">
        <img class="h-56 w-full object-cover object-top sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://upload.wikimedia.org/wikipedia/commons/1/18/Aptech_Limited_Logo.svg" alt="">
    </div>
</div>

@endsection