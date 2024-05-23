<div class="my-5 mb-3 mt-10 mx-3 flex justify-center	">
  <div>
    <h1 class="text-xl font-bold mt-7 text-gray-900 sm:text-3xl">Related product</h1>
  </div>
</div>
<span class="flex items-center">
  <span class="h-px flex-1 bg-gray-300"></span>
</span>
<div id="productKankei" class="grid grid-cols-2 mx-6 lg:grid-cols-5 md:grid-cols-4 lg:gap-2 lg:mt-8 mt-4 mb-8 "></div>
<div class="flex w-full items-center justify-center ">
  <button class="text-gray-700  hover:underline" id="loadMoreButton">Load more</button>
</div>
<script>
  /////load more peoducts 
  document.addEventListener("DOMContentLoaded", function() {
    loadMoreProducts()
  });
  var currentPage = 1;
  var isLoading = false;

  function loadMoreProducts() {
    if (isLoading) return;
    isLoading = true;
    $.ajax({
      url: "{{ route('loadmoreproducts') }}",
      type: 'GET',
      data: {
        page: currentPage
      },
      success: function(response) {
        if (response.productsMore.length > 0) {
          $.each(response.productsMore, function(index, product) {
            var formattedPrice = (product.price).toLocaleString('vi-VN', {
              style: 'currency',
              currency: 'VND'
            });
            var html = `
                  <div class="h-full rounded-lg mb-3">
                      <div class="group rounded-xl relative block overflow-hidden">
                          <button class="absolute end-0 lg:end-4 top-4 z-10 p-1">
                              ${product.discount_quantity > 0 && product.discount > 0 ? `<span class="rounded-full mr-1 text-red-600 px-0.5 py-0.2 lg:px-1 lg:py-0.5 text-[12px]">- ${product.discount}%</span>` : ''}
                          </button>
                          <div>
                              <img src="{{ asset('images/') }}/${product.image}" alt="${product.name}" class="primage min-h-full rounded-t-2xl w-full object-cover transition duration-500 group-hover:scale-105" />
                          </div>
                          <div class="relative">
                              <div class="flex">
                                  <h3 class="lg:mt-1 mt-1   text-gray-700">${product.name}</h3>
                                  <div class="mr-4">
                                      ${product.is_new ? `<span class="rounded-full ml-2 text-white bg-red-600 px-1 py-0.5 lg:px-1.5 lg:py-1 text-xs"> New </span>` : ''}
                                  </div>
                              </div>
                              <p class="mt-1.5 lg:text-sm text-[11px] text-gray-500 transition hover:text-gray-800">${(formattedPrice)}</p>
                              <div class ="flex justify-center mt-1">
                                  <a href="{{ route('product.view', ['id' => ':productId']) }}" class="group relative justify-center flex items-center overflow-hidden rounded-full border w-fit px-6 py-1.5 lg:px-6 lg:py-2 text-gray-500 focus:outline-none focus:ring active:text-gray-600">
                                      <div>
                                          <button class="text-sm font-medium transition-all group-hover:me-4" type="button">View Product</button>
                                      </div>
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              `;
            html = html.replace(':productId', product.id);
            $('#productKankei').append(html);
          });
          isLoading = false;
          currentPage++;
        }
        if (response.hasMore == false) {
          $('#loadMoreButton').text('End').prop('disabled', true);

        }

      },
      error: function(xhr, status, error) {
        console.error(error);
        isLoading = false;
      }
    });
  }
  $('#loadMoreButton').click(function() {
    loadMoreProducts();
  });
</script>