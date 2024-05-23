<header class="z-10">
  <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="md:flex md:items-center md:gap-12">
        <a class="block " href="{{ url('/product') }}">
          <img src="" alt="Logo">
        </a>
      </div>
      <div class="hidden md:block">
        <nav aria-label="Global">
          <ul class="flex items-center gap-6 text-sm">
            <li>
              <a class="text-gray-500 transition hover:text-gray-500/75" href="{{ url('/') }}">Home</a>
            </li>
            <li>
              <a class="text-gray-500 transition hover:text-gray-500/75" href="/product"> Product </a>
            </li>
            <li>
              <a class="text-gray-500 transition hover:text-gray-500/75" href="/about"> About </a>
            </li>
            <li>
              <a class="text-gray-500 transition hover:text-gray-500/75" href="blog"> Blog </a>
            </li>
            <li>
              <a class="text-gray-500 transition hover:text-gray-500/75" href="/contact">contact </a>
            </li>
            <li>
              <a class="text-gray-500 transition hover:text-gray-500/75" href="/profile"> Profile </a>
            </li>
          </ul>
        </nav>
      </div>
      <!--  -->
      <!-- <div class="flex items-center gap-4">
          <div class="sm:flex sm:gap-4">
              @php
                  if (Auth::check()) {
                      echo '<div class="mt-2 mr-4">
                              <img src="" alt="Avatar"> 
                            </div>';
                      echo '<a class="rounded-xl bg-indigo-500 hover:bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('logout') . '">Logout</a>';
                  } elseif (Request::is('login')) {
                      echo '<a  class="rounded-xl bg-indigo-500 hover:bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('register') . '">Register</a>';
                  } else {
                      echo '<a  class="rounded-xl bg-indigo-500 hover:bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('login') . '">Login</a>';
                  }
              @endphp
          </div>
      </div> -->
      <!--  -->
      <div class="flex items-center gap-4">
        <div class="sm:flex sm:gap-4">

          <!-- Image avatar -->
          @php
          if (Auth::check()) {
          echo '<div class="mt-2">
            <img src="" alt="Avatar">
          </div>';
          echo '<a class="rounded-xl bg-red-600	 hover:hover:bg-red-800 px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('logout') . '">Logout</a>';
          } elseif (Request::is('login')) {
          echo '<a class="rounded-xl bg-red-600 hover:hover:bg-red-800 px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('register') . '">Register</a>';
          } else {
          echo '<a class="rounded-xl bg-red-600 hover:hover:bg-red-800 px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('login') . '">Login</a>';
          }
          @endphp
        </div>
        <!-- menu button -->
        <div>
          <a href="/cart">cart</a>
        </div>

        <!-- end menu button -->
      </div>
    </div>
  </div>
  <span class="flex items-center">
    <span class="h-px flex-1 bg-slate-100"></span>
  </span>
</header>
<!-- end header  -->