<!--  -->


<span class="flex items-center mt-10 ">
    <span class="h-px flex-1 bg-gray-300"></span>
</span>
<footer>
    <div>
        <div class="bg-white dark:bg-gray-900">
            <div class=" mx-auto max-w-screen-xl pb-4 lg:pb-10 ">
                <div class="  mx-3 my-3 lg:mt-8 lg:my-0 sm:text-center">
                    <h2 class="mb-4 text-xl font-extrabold tracking-tight text-gray-900 sm:text-3xl dark:text-white">Sign up for our newsletter</h2>
                    <p class="mx-auto mb-8 max-w-2xl text-sm  text-gray-500 sm:text-sm dark:text-gray-400">Stay up to date with the roadmap progress, announcements and exclusive discounts feel free to sign up with your email.</p>
                    <form action="{{ route('subscribe') }}" method="POST">
                        @csrf
                        <div class="items-center mx-auto mb-2 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
                            <div class="relative w-full">
                                <label for="email" name="subemail" class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email address</label>
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                        <path d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                                        <path d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                                    </svg>
                                </div>
                                <input class="block p-3 pl-9 w-full text-sm text-gray-900 bg-white rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email" type="email" for="subemail" id="subemail" name="subemail">
                            </div>
                            <div>
                                <button id="subscribeForm" type="submit" class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer  border-gray-500 bg-gray-500 hover:hover:bg-gray-700 sm:rounded-none sm:rounded-r-lg  focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Subscribe</button>
                            </div>
                        </div>
                        <div class="mx-auto max-w-screen-sm text-sm text-left text-gray-500 newsletter-form-footer dark:text-gray-300">We care about the protection of your data. <a href="" class="font-medium text-gray-600 dark:text-primary-500 hover:underline">Read our Privacy Policy</a>.</div>
                    </form>
                    <!-- end form -->
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col items-center  text-center text-surface mb-2 text-gray-500">
        <div class="">
            <div class="w-full flex pb-3 text-center">
                © 2024 Design by Minh Quang
                <div class="pl-4 flex">
                    <!-- <a class="mr-2 hover:text-blue-600" href="{{url('/contact')}}">Contact</a> -->
                    <div class="flex">
                        <a href="https://www.facebook.com/ngoomqct" target="_blank" type="button" class="rounded-full hover:text-blue-600 mr-3 m bg-transparent p-0 font-medium uppercase leading-normal text-surface transition duration-150 ease-in-out hover:bg-neutral-100 focus:outline-none focus:ring-0 dark:text-white dark:hover:bg-secondary-900" data-twe-ripple-init>
                            <span class="[&>svg]:h-5 [&>svg]:w-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 320 512">
                                    <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z" />
                                </svg>
                            </span>
                        </a>
                        <a href="https://www.instagram.com/258923_/" target="_blank" type="button" class="rounded-full hover:text-blue-600 bg-transparent p-0 font-medium uppercase leading-normal text-surface transition duration-150 ease-in-out hover:bg-neutral-100 focus:outline-none focus:ring-0 dark:text-white dark:hover:bg-secondary-900" data-twe-ripple-init>
                            <span class="[&>svg]:h-5 [&>svg]:w-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                                    <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</footer>
<!-- @if (session('success'))
    <script>
        // Display an alert with the success message
        alert("{{ session('success') }}");
    </script>
@endif -->
<script>
    document.getElementById('subscribeForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);
        axios.post(this.action, formData)
            .then(function(response) {
                console.log(response.data);
                window.location.href = '{{ route("home") }}';
            })
            .catch(function(error) {
                console.error('Error subscribing:', error);
            });
    });
</script>