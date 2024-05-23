<meta name="csrf-token" content="{{ csrf_token() }}">
<header class="z-10 w-full">
  @if(session('userData') && session('userData')['isAdmin'])
  @include('admin.header')
  @endif
  <div class="mx-auto max-w-screen-xl px-6 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <div class="md:flex mr-24 md:items-center md:gap-12">
        <a class="block " href="{{ url('/') }}">
          <img src="" alt="Logo">
        </a>
      </div>
      <div class="hidden ml-24 md:block">
        <nav aria-label="Global">
          <ul class="flex items-center gap-7 mr-10 text-sm">
            <li class="dropdown-1" onmouseover="openDropdown()" onmouseout="startTimer()">
              <a class=" hover:text-gray-800 hover:underline" href="{{ Route('product.view.view') }}">Product</a>
              <div id="dropdownMenu-1" class="dropdown-menu-1 ">
                <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.bestseller.view') }}">Best Seller</a>
                <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.new') }}">New Product</a>
                <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.formen') }}">Men's wear</a>
                <a class="dropdown-option-1 hover:text-gray-800" href="{{ Route('product.forwomen') }}">Women's wear</a>
                <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('product.forunisex') }}">For unisex</a>
                <a class="dropdown-option-1  hover:text-gray-800" href="{{ Route('discount.view.view') }}">Discount</a>
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
      <div class="flex w-full xl:w-1/5 md:w-3/5 2xl:w-2/5 lg:w-1/5	 gap-1 lg:gap-0 sm:gap-0  items-center">
        <div class="w-full mr-2 lg:inline  sm:inline ">
          <form action="{{ route('search') }}" method="GET">
            @csrf
            <div class="relative border-current">
              <input type="text" name="search" placeholder="Search for..." class="w-full  border rounded-md border-gray-400 hover:border-gray-600 py-1 pe-10 shadow-sm sm:text-sm" />
              <span class="absolute inset-y-0 end-0 grid w-10 place-content-center">
                <button type="submit" class="text-gray-700 ">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                  </svg>
                </button>
              </span>
            </div>
          </form>
        </div>
        <div class="rounded-2xl relative lg:p-0 sm:p-0 mr-4 lg:mr-6 sm:mr-5 py-2 text-sm font-medium transition sm:gap-1">
          <div class="hover:cursor-pointer">
            <div onclick="openCart()" class="flex ">
              <svg class="absolute items-center" xmlns="http://www.w3.org/2000/svg" width="38" height="30" viewBox="0 0 24 24">
                <path id="cartQuantity" d="M20 7h-4v-3c0-2.209-1.791-4-4-4s-4 1.791-4 4v3h-4l-2 17h20l-2-17zm-11-3c0-1.654 1.346-3 3-3s3 1.346 3 3v3h-6v-3zm-4.751 18l1.529-13h2.222v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h6v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h2.222l1.529 13h-15.502z" />
              </svg>
              <span class="ml-3.5 mt-2.5" id="cartCount"></span>
            </div>
          </div>
        </div>
        <!-- <div class="sm:flex items-center flex sm:gap-1">
          @php
          if (Auth::check()) {
          echo '<a class="rounded-xl bg-gray-900 hover:hover:bg-black px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('logout') . '">Logout</a>';
          } elseif (Request::is('login')) {
          echo '<a class="rounded-xl bg-gray-900 hover:hover:bg-black px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('register') . '">Register</a>';
          } else {
          echo '<a class="rounded-xl bg-gray-900 hover:hover:bg-black px-5 py-2.5 text-sm font-medium text-white shadow" href="' . route('login') . '">Login</a>';
          }
          @endphp
        </div> -->

        <!--  -->
        <div id="cart-view" class="incart " style="display: none;">
          <div class="flex  justify-end mr-5 mt-4 hover:cursor-pointer ">
            <button class="z-50  closecart" onclick="closeCart()">
              <p class=" border-slate-400	hover:border-slate-900 rounded border px-1">X</p>
            </button>
          </div>
          <div class="mb-4">
            <p class="text-sm text-center font-bold  text-gray-700">Shopping Cart</p>
          </div>
          <span class="flex mt-1 mb items-center">
            <span class="h-px flex-1 bg-gray-300"></span>
          </span>
          <div id="cartItems">
            <!--HTML của giỏ hàng -->
          </div>
          <div class="mt-5 flex justify-center  ">
            <a href="/cart" type="submit" class="flex justify-center w-4/6 rounded-lg bg-black	 px-10 py-1 font-medium text-white">
              View Cart
            </a>
          </div>
          <div class="mt-1 flex justify-center mb-8  ">
            <a href="/checkout" type="submit" class="flex justify-center w-4/6 rounded-lg bg-black	 px-10 py-1 font-medium text-white">
              Check Out
            </a>
          </div>
        </div>
        <!-- end view cart  -->
      </div>
    </div>
  </div>
</header>
<script>
  let timeout;

  function openDropdown() {
    clearTimeout(timeout);
    document.getElementById("dropdownMenu-1").style.display = "block";
  }

  function closeDropdown() {
    document.getElementById("dropdownMenu-1").style.display = "none";
  }

  function startTimer() {
    timeout = setTimeout(closeDropdown, 3000);
  }
</script>