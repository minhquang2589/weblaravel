<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
    @vite('resources/css/cart/viewcart.css')
    @vite('resources/css/header/header.css')
    <style>
        @media screen and (max-width: 1000px) {
            .primage {
                height: 100%;
            }
        }
    </style>
</head>
@include('layout.header-2')

<div class="lg:flex">
    <div class="lg:w-1/2 xl:max-w-screen-sm">
        <div class="py-12 lg:bg-white flex justify-center lg:justify-start lg:px-12">
        </div>
        <div class="mt-10 px-12 sm:px-24 md:px-48 lg:px-12 lg:mt-16 xl:px-24 xl:max-w-2xl">
            <h2 class="text-center flex justify-center text-4xl text-gray-800 font-display font-semibold lg:text-left xl:text-4xl
            xl:text-bold">Log in</h2>
            <div class="mt-12 bg-white shadow-md  px-8 pt-6 pb-8 mb-4 ">
                <!-- form -->
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div>
                        <div class="text-sm font-bold text-gray-700 tracking-wide">Email Address</div>
                        <input value="{{ old('email', session('existingUser.email')) }}" class="w-full  text-sm py-2 border-b border-gray-300 focus:outline-none focus:border-gray-800" type="email" id="email" name="email" for="email" placeholder="mike@gmail.com">
                        @error('email')
                        <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                            <span class="block sm:inline text-xs">{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div class="mt-8">
                        <div class="flex justify-between items-center">
                            <div class="text-sm font-bold text-gray-700 tracking-wide">
                                Password
                            </div>
                            <div>
                                <a href="/forgotpassword" class="text-xs font-display font-semibold text-red-600 hover:text-red-800 cursor-pointer">
                                    Forgot Password?
                                </a>
                            </div>
                        </div>
                        <input class="w-full  text-sm py-2 border-b border-gray-300 focus:outline-none focus:border-gray-800" type="password" id="password" name="password" for="password" placeholder="Enter your password">
                        @error('password')
                        <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                            <span class="block sm:inline text-xs">{{ $message }}</span>
                        </div>
                        @enderror
                        @if(session('existingUser'))
                        <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                            <span class="block sm:inline text-xs">{{ session('existingUser')['message'] }}</span>
                        </div>
                        @endif
                    </div>
                    <!-- thong bao loi cho nguoi dung khi chua co account -->
                    @if (session('error'))
                    <div class="mt-1 text-xs text-red-700 rounded-xl">
                        {{ session('error') }}
                    </div>
                    @endif
                    <!--  -->
                    <div class="mt-10">
                        <button type="submit" class="bg-gray-700 text-gray-100 p-4 w-full rounded-full tracking-wide font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-gray-800 shadow-lg">
                            Log In
                        </button>
                    </div>
                </form>
                <!--end form -->
                <div class="mt-12 text-sm font-display font-semibold text-gray-700 text-center">
                    Don't have an account ? <a href="{{ Route('register') }}" class="cursor-pointer text-red-600 hover:text-red-800">Sign up</a>
                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    <div class="hidden w-full h-2/5	 lg:flex items-center justify-center  flex-1 ">
        <div class=" z-1 transform duration-200 hover:scale-110 cursor-pointer">
            <img class="w-full mx-auto" xmlns="" id="f080dbb7-9b2b-439b-a118-60b91c514f72" data-name="Layer 1" viewBox="0 0 528.71721 699.76785" src="https://tailwindcss.com/_next/static/media/installation.50c59fdd.jpg" alt="image">
        </div>
    </div>
</div>
<!--  -->
</html>