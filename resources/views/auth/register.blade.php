<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
      <div class="sm:px-24 mt-0 md:px-48 pt-10 lg:px-12 lg:mt-6 xl:px-24">
         <h2 class="text-center flex justify-center text-4xl font-display font-semibold  xl:text-4xl
            xl:text-bold">Register</h2>
         <div class="mt-12">
            <!-- form -->
            <form method="POST" action="{{ route('register.post') }}">
               @csrf
               <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 flex flex-col my-2">
                  <div class="-mx-3 ">
                     <div class="md:w-full px-3">
                        <label class="block  text-sm font-bold tracking-wide text-gray-700 mb-2" for="fullname">
                           Full Name
                        </label>
                        <input class="text-sm  appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-2 px-4 mb-2" id="fullname" name="fullname" type="text" placeholder="Enter Your Name">
                     </div>
                     <div class="md:w-full px-3">
                        <label class="block  text-sm font-bold tracking-wider text-gray-700 mb-2" for="email">
                           Email Address
                        </label>
                        <input class="appearance-none text-sm  block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-2 px-4 mb-3" id="email" name="email" type="text" placeholder="Enter Your Email">
                     </div>
                     <div class="md:w-full px-3">
                        <label class="block  text-sm font-bold tracking-wide text-gray-700 mb-2" for="phone">
                           Phone Number
                        </label>
                        <input class="appearance-none  block w-full bg-grey-lighter text-sm text-grey-darker border border-grey-lighter rounded py-2 px-4 mb-3" id="phone" name="phone" type="tphoneext" placeholder="Enter Your Phone Number">
                     </div>
                  </div>
                  <div class="flex justify-between">
                     <div>
                        <div class="">
                           <label class="block  text-sm font-bold tracking-wide text-gray-700 mb-2" for="birthday">
                              Birthday
                           </label>
                           <input class="appearance-none  block w-full bg-grey-lighter text-sm text-grey-darker border border-grey-lighter rounded py-2 px-6 sm:px-8 lg:px-8 mb-3" id="birthday" name="birthday" type="date" placeholder="Enter Your Phone Number">
                        </div>
                     </div>
                     <div>
                        <div class="w-full mr-5">
                           <label class="block  text-sm font-bold tracking-wide text-gray-700 mb-2" for="gender">
                              Gender
                           </label>
                           <div class="">
                              <select id="gender" for="gender" name="gender" class="block w-full px-4 sm:px-5 lg:px-5 pt-2 pb-3 text-sm text-grey-darker border border-grey-lighter rounded focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                 <option hidden selected disabled>Choose a gender</option>
                                 <option for="gender" value="Male">Male</option>
                                 <option for="gender" value="Female">Female</option>
                              </select>
                           </div>

                        </div>
                     </div>
                  </div>
                  <div class="inline-table">
                     <div class="-mx-3 mb-3">
                        <div class="md:w-full px-3">
                           <label class=" tracking-wide text-gray-700 text-sm font-bold mb-2" for="password">
                              Password
                           </label>
                           <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-2 px-4 " id="password" name="password" type="password" placeholder="*********">
                        </div>
                     </div>
                     <div class="-mx-3 md:flex mb-6">
                        <div class="md:w-full px-3">
                           <label class=" tracking-wide text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                              Confirm Password
                           </label>
                           <input class="appearance-none block w-full bg-grey-lighter text-gray-700 border border-grey-lighter rounded py-2 px-4 mb-3" id="confirm_password" name="confirm_password" type="password" placeholder="*********">
                           <p class="text-gray-600 text-xs italic">Make it as long and as crazy as you'd like</p>
                        </div>
                     </div>
                  </div>
                  <div class="-mx-3 md:flex mb-2">
                     <div class="md:w-full px-3 mb-6 md:mb-0">
                        <label class="block tracking-wide text-gray-700 text-sm font-bold mb-2" for="address">
                           Address
                        </label>
                        <input class="appearance-none  text-sm block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-2 px-4" id="address" name="address" type="text" placeholder="Enter Your Address">
                     </div>
                  </div>
                  @error('fullname')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-xs">{{ $message }}</span>
                  </div>
                  @enderror
                  @error('email')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-xs">{{ $message }}</span>
                  </div>
                  @enderror
                  @error('phone')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-xs">{{ $message }}</span>
                  </div>
                  @enderror
                  @error('birthday')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-xs">{{ $message }}</span>
                  </div>
                  @enderror
                  @error('gender')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-xs">{{ $message }}</span>
                  </div>
                  @enderror
                  @error('password')
                  <div class="mt-0 text-red-700 rounded-xl relative" role="alert">
                     <span class="block sm:inline text-xs">{{ $message }}</span>
                  </div>
                  @enderror

                  <div class="mt-10">
                     <button class="bg-gray-700 text-gray-100 p-4 w-full rounded-full tracking-wide
                        font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-gray-800
                        shadow-lg">
                        Register
                     </button>
                  </div>
                  <div class="mt-12 text-sm font-display font-semibold text-gray-700 text-center">
                     You have account? <a href="{{ Route('login') }}" class="cursor-pointer text-red-600 hover:text-red-800">Sign in</a>
                  </div>
               </div>
            </form>

            <!-- end form -->
         </div>
      </div>
   </div>
   <!-- contnet -->
   <!-- background -->
   <div class="hidden w-full h-2/5	 lg:flex items-center justify-center  flex-1 ">
      <div class=" z-1 transform duration-200 hover:scale-110 cursor-pointer">
         <img class="w-full mx-auto" xmlns="" id="f080dbb7-9b2b-439b-a118-60b91c514f72" data-name="Layer 1" viewBox="0 0 528.71721 699.76785" src="https://tailwindcss.com/_next/static/media/installation.50c59fdd.jpg" alt="image">
      </div>
   </div>
</div>
<!--  -->
</html>