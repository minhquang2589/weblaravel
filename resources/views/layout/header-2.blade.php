<meta name="csrf-token" content="{{ csrf_token() }}">

<header class="z-10 w-full">
  <div class="mx-auto max-w-screen-xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="md:flex md:items-center md:gap-12">
        <a class="block " href="{{ url('/') }}">
          <img src="" alt="Logo">
        </a>
      </div>
      <div class="hidden md:block">
        <nav aria-label="Global">
          <ul class="flex items-center gap-7 text-sm">
            <li class="dropdown-1" onmouseover="openDropdown()" onmouseout="startTimer()">
              <a class=" hover:text-gray-800 hover:underline" href="{{ Route('product.view.view') }}">Product</a>
              <div id="dropdownMenu-1" class="dropdown-menu-1 ">
                <div id="dropdownMenu-1" class="dropdown-menu-1 ">
                  <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.bestseller.view') }}">Best Seller</a>
                  <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.new') }}">New Product</a>
                  <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.formen') }}">Men's wear</a>
                  <a class="dropdown-option-1 hover:text-gray-800" href="{{ Route('product.forwomen') }}">Women's wear</a>
                  <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.forunisex') }}">For unisex</a>
                  <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('discount.view.view') }}">Discount</a>
                </div>
              </div>
            </li>
            <li>
              <a class=" hover:text-gray-800 hover:underline" href="/about"> About </a>
            </li>
            <li>
              <a class=" hover:text-gray-800 hover:underline" href="/blog"> Blog </a>
            </li>
            <li>
              <a class=" hover:text-gray-800 hover:underline" href="/contact">contact </a>
            </li>
          </ul>
        </nav>
      </div>
      <!-- button -->
      <div class="flex gap-1 mb:gap-1  items-center">
        <div class="sm:flex items-center flex sm:gap-3">
          @php
          if (Auth::check()) {
          echo '<a class="rounded-xl bg-gray-800 hover:hover:bg-black px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('logout') . '">Logout</a>';
          } elseif (Request::is('login')) {
          echo '<a class="rounded-xl bg-gray-800 hover:hover:bg-black px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('register') . '">Register</a>';
          } else {
          echo '<a class="rounded-xl bg-gray-800 hover:hover:bg-black px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('login') . '">Login</a>';
          }
          @endphp
        </div>
      </div>
    </div>
  </div>
</header>
<span class="flex items-center">
  <span class="h-px flex-1 bg-gray-300"></span>
</span>