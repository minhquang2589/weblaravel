<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.8.1/alpine.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/css/header/header.css')
    <style>
        .notificationAddcart {
            position: fixed;
            top: 25%;
            left: 50%;
            height: 80px;
            display: flex;
            font-size: larger;
            justify-content: center;
            align-items: center;
            width: fit-content;
            z-index: 9999;
            transform: translateX(-50%);
            background-color: rgba(192, 192, 192, 0.6);
            color: black;
            padding: 10px 80px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .standing {
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            position: sticky;
            top: 65px;

        }

        .sidebar {
            display: none;
        }

        .sasidebar {
            display: block;
        }

        @media screen and (max-width: 1000px) {
            .primage {
                height: 100%;
            }

            .standing {
                display: none;
            }
        }

        @media only screen and (max-width: 768px) {
            .sidebar {
                display: block;
            }

            .notificationAddcart {
                height: 60px;
                width: 290px;
                padding: 10px 25px;
            }

            .standing {
                display: none;
            }
        }
    </style>
</head>
@include('layout.header')
<body>
    <div class="darkenn">
        <div>
            <span class="flex items-center">
                <span class="h-px flex-1 bg-gray-300"></span>
            </span>
            @yield('content')
        </div>
        <div class="sidebar">
            @if(session('isAdmin'))
            @include('sa.sasidebar')
            @else
            @include('layout.sidebar')
            @endif
        </div>
    </div>
    @if(Request::path()=='product/mens' || Request::path()=='product/unisexs' || Request::path()=='/' || Request::path()=='product/bestsellers' || Request::path()=='new/product'|| Request::path()=='product/womens' )
    @include('layout.footer')
    @else
    @include('layout.footer')
    @endif

</body>
<script>
    /////
    const setup = () => {
        return {
            isSidebarOpen: false,
        };
    };

    document.addEventListener("DOMContentLoaded", function() {
        filterContent();
        updateViewCart();
        updateCartCount();
        SubtotalTotal();
    });
    ///
    function filterContent() {
        $.ajax({
                url: "{{ route('filter.content') }}",
                method: 'GET',
            }).done(function(response) {
                $('#newCount').text('(' + response.newCount + ')');
                $('#saleCount').text('(' + response.discountCount + ')');
                $('#instockCount').text('(' + response.instockCount + ')');
                $('#outstockCount').text('(' + response.outstockCount + ')');
            })
            .fail(function(xhr, status, error) {});
    }
    //Thông báo 
    function showNotification(message) {
        const notification = document.createElement('div');
        notification.classList.add('notificationAddcart');
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.remove();
        }, 2100);
    }
    ///button view product
    $(document).on('click', '[id^="addToCartBtnView"]', function(event) {
        event.preventDefault();
        var productId = $(this).data('product-id');
        var productViewUrl = "/view/" + productId;
        window.location.href = productViewUrl;
    });

    function openCart() {
        updateViewCart();
        var cart = document.getElementById("cart-view");
        var darken = document.querySelector(".darkenn");
        cart.style.display = "block";
        darken.classList.add("darken");
    }
    document.getElementById("cartQuantity").addEventListener("click", function() {
        openCart();
    });
    document.getElementById("cartQuantity").addEventListener("mouseenter", function() {
        openCart();
    });

    function closeCart() {
        var cart = document.getElementById("cart-view");
        cart.style.display = "none";
        var darken = document.querySelector(".darkenn");
        darken.classList.remove("darken");
    }

    document.getElementById("cart-view").addEventListener("mouseleave", function() {
        closeCart();
    });
    //////// update view cart
    function updateViewCart() {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
                type: "POST",
                url: "{{ route('cart.update.time') }}",
                data: {
                    _token: csrfToken
                },
            }).done(function(response) {
                var cartData = response.cart;
                var cartItemsHtml = '';
                if (Object.keys(cartData).length > 0) {
                    for (var key in cartData) {
                        var item = cartData[key];
                        var priceVND = item.price.toLocaleString('vi-VN', {
                            style: 'currency',
                            currency: 'VND'
                        });
                        cartItemsHtml += `
                        <div class="grid grid-cols-3 items-center ml-10 ">
                            <div class="">
                                <img src="/images/${item.image}" alt="" class="rounded object-cover">
                            </div>
                            <div class=" ml-4 mb-6">
                                <div class ="flex justify-start">
                                <p class=" mt-3 text-gray-800">${item.name}</p>
                                </div>
                                <p class="text-[10px] text-gray-600">Color: ${item.color}</p>
                                <p class=" text-[10px] text-gray-600">${item.quantity} x ${priceVND}</p>
                                <p class=" text-[10px] text-gray-600">Size: ${item.size}</p>
                            </div>
                            <div class="ml-4">
                                <form method="POST" action="{{ route('cart.view.remove') }}">
                                    @csrf
                                    <input type="hidden" name="product_id" value="${item.id}">
                                    <input type="hidden" name="size" value="${item.size}">
                                    <input type="hidden" name="color" value="${item.color}">
                                    <button type="button" class="text-gray-600 transition hover:text-red-600 remove-item-view-cart"
                                            data-product-id="${item.id}"
                                            data-size="${item.size}"
                                            data-color="${item.color}">
                                        <span class="sr-only">Remove item</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <span class="flex items-center">
                            <span class="h-px flex-1 bg-gray-300"></span>
                        </span>
                    `;
                    }
                } else {
                    cartItemsHtml = `
                    <p class="text-sm my-5 text-center text-gray-700">Your cart is empty!</p>
                    <span class="flex mt-2 items-center">
                        <span class="h-px flex-1 bg-gray-300"></span>
                    </span>
                `;
                }
                $('#cartItems').html(cartItemsHtml);
            })
            .fail(function(xhr, status, error) {
                // console.error(error);
            });
    }
    //// ////thêm sản phẩm và giỏ hàng 
    $('[id^="addToCartBtn"]').click(function(event) {
        var isMessageVisible = false;
        event.preventDefault();
        var addToCartForm = $(this).closest('form');
        var size = addToCartForm.find('#size').val();
        var color = addToCartForm.find('#color').val();
        var discountPercent = $('#discountPercent').val();
        if (size === 'selectsize' || color === 'selectcolor') {
            if (!isMessageVisible) {
                $('#checkoutMessage').text('Pls select size and color.').fadeIn();
                isMessageVisible = true;
                setTimeout(function() {
                    $('#checkoutMessage').fadeOut(function() {
                        isMessageVisible = false;
                    });
                }, 2000);
            }
            return;
        }
        var formData = addToCartForm.serialize();
        formData += '&discountPercent=' + discountPercent;
        var productId = addToCartForm.find('input[name="product_id"]').val();
        if ($(this).hasClass('out-of-stock-button')) {
            return;
        }
        $.ajax({
            url: addToCartForm.attr('action'),
            method: 'POST',
            data: formData,
        }).done(function(response) {
            if (response.success) {
                updateCartCount();
                showNotification('Đã thêm vào giỏ hàng!');
            } else {
                showNotification(response.error);
            }
        }).fail(function(xhr, status, error) {
            console.error(error);
        });
    });

    //buy now button
    $('[id^="CheckOutBtn"]').click(function(event) {
        var isMessageVisible = false;
        event.preventDefault();
        var addToCartForm = $(this).closest('form');
        var size = addToCartForm.find('select[name="size"]').val();
        var color = addToCartForm.find('select[name="color"]').val();
        var discountPercent = addToCartForm.find('#discountPercent').val();
        if (size === "selectsize" || color === "selectcolor") {
            if (!isMessageVisible) {
                $('#checkoutMessage').text('Pls select size and color.').fadeIn();
                isMessageVisible = true;
                setTimeout(function() {
                    $('#checkoutMessage').fadeOut(function() {
                        isMessageVisible = false;
                    });
                }, 2000);
            }
            return;
        }
        var formData = addToCartForm.serialize();
        if ($(this).hasClass('out-of-stock-button')) {
            return;
        }
        $.ajax({
            url: addToCartForm.attr('action'),
            method: 'POST',
            data: formData,
        }).done(function(response) {
            updateCartCount();
            window.location.href = "{{ route('checkout') }}";
        }).fail(function(xhr, status, error) {
            console.error(error);
        });
    });


    /////kiểm tra xem còn product hay không 
    var sizeSelected = false;
    var colorSelected = false;
    $('select[name="size"]').on('change', function() {
        sizeSelected = $(this).val() !== '';
        checkStock();
    });
    $('select[name="color"]').on('change', function() {
        colorSelected = $(this).val() !== '';
        checkStock();
    });

    function checkStock() {
        if (sizeSelected && colorSelected) {
            var size = $('select[name="size"]').val();
            var color = $('select[name="color"]').val();
            var productId = $('input[name="productCheck_id"]').val();
            $.ajax({
                    url: "{{ route('checkStock') }}",
                    type: "POST",
                    data: {
                        product_id: productId,
                        size: size,
                        color: color,
                        _token: "{{ csrf_token() }}"
                    },
                })
                .done(function(response) {
                    if (response.status == 'available') {
                        $('#addToCartBtn' + productId).removeClass('out-of-stock-button').prop('disabled', false);
                        $('#CheckOutBtn').removeClass('out-of-stock-button').prop('disabled', false);
                        $('#availability').text(response.data.productVariant.quantity + ' item in stock').removeClass('out-of-stock');
                        $('#totalInStock').text('').removeClass('out-of-stock');
                    } else {
                        $('#availability').text('Out of stock').addClass('out-of-stock');
                        $('#totalInStock').text('').addClass('out-of-stock');
                        $('#addToCartBtn' + productId).addClass('out-of-stock-button').prop('disabled', true);
                        $('#CheckOutBtn').addClass('out-of-stock-button').prop('disabled', true);
                    }
                })
                .fail(function(xhr, status, error) {});
        }
    }

    /////check stock tổng thể của sản phẩm
    $(document).ready(function() {
        var productId = $('#checkquantitystock').val();
        $.ajax({
                url: "{{ route('checkQuantityStock') }}",
                type: "POST",
                data: {
                    product_id: productId,
                    _token: "{{ csrf_token() }}"
                },
            })
            .done(function(response) {
                if (response.totalQuantity <= 0) {
                    $('#soldOutMessage').text('Sold out').addClass('sold-out-css');
                    $('#addToCartBtn' + productId).addClass('out-of-stock-button').prop('disabled', true);
                    $('#CheckOutBtn').addClass('out-of-stock-button').prop('disabled', true);
                } else {
                    $('#totalInStock').text(response.totalQuantity + ' item in stock');
                    $('#soldOutMessage').removeClass('sold-out-css');
                }
            })
            .fail(function(xhr, status, error) {});
    });

    ////// xoá sản phẩm trong cart 
    function deleteFormCart() {
        $('form.remove-from-cart-cart').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var method = form.attr('method');
            var data = form.serialize();
            $.ajax({
                    url: url,
                    type: method,
                    data: data,
                })
                .done(function(response) {
                    if (response.success) {
                        showNotification('Remove successfully!')
                        form.closest('li').remove();
                        updateCartCount();
                        updateViewCart();
                        SubtotalTotal();
                    } else {
                        // console.log(response.error);
                    }
                })
                .fail(function(xhr, status, error) {
                    // console.error("error:", error);
                });
        });
    }
    deleteFormCart();


    ////// xoá sản phẩm trong view cart 
    function deleteFormViewCart() {
        $('#cartItems').on('click', '.remove-item-view-cart', function(e) {
            e.preventDefault();
            var productId = $(this).data('product-id');
            var size = $(this).data('size');
            var color = $(this).data('color');
            $.ajax({
                    type: 'POST',
                    url: '{{ route("cart.view.remove") }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        size: size,
                        color: color
                    }
                })
                .done(function(response) {
                    updateViewCart();
                    updateCartCount();
                    SubtotalTotal();
                })
                .fail(function(xhr, status, error) {
                    console.error(error);
                });
        });
    }
    deleteFormViewCart();
    ///
    function updateCartCount() {
        $.ajax({
                url: "{{ route('cart.quantity') }}",
                method: 'GET',

            }).done(function(response) {
                $('#cartCount').text(response.cartQuantity);
            })
            .fail(function(xhr, status, error) {});
    }
    ////
    const voucherInput = document.getElementById('voucherInput');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    let isVoucherApplied = false;

    $('#applyVoucherButton').click(function() {
        applyVoucher();
    });
    if (voucherInput) {
        voucherInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                applyVoucher();
            }
        });
    }


    function applyVoucher() {
        const voucherCode = voucherInput.value;
        if (voucherCode.trim() === '') {
            $('#voucherMessage').html('Vui lòng nhập Vouchers');
            return;
        }
        if (isVoucherApplied) {
            return;
        }
        $.ajax({
            type: 'POST',
            url: '/check-voucher',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                voucher_code: voucherCode,
            },
            success: function(response) {
                if (response.success) {
                    $('#voucherMessage').html('Voucher áp dụng thành công - ' + response.dataInVoucher.VoucherValue + '%');
                    var oldDiscount = parseFloat($('#CartDiscount').text().replace('%', ''));
                    var newDiscount = parseFloat(response.discount);
                    var totalDiscount = oldDiscount + newDiscount;
                    $('#CartDiscount').text(totalDiscount + '%');
                    $.ajax({
                        url: "{{ route('cart.total.subtotal') }}",
                        method: 'GET',
                        data: {
                            voucher_discount: totalDiscount,
                        },
                        success: function(subtotalResponse) {
                            var newSubtotal = response.dataInVoucher.newSubtotal;
                            var newdiscount = response.dataInVoucher.totalDiscountAmount;
                            updateSubtotal(newSubtotal, newdiscount);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });

                    isVoucherApplied = true;
                } else {
                    $('#voucherMessage').html(response.message);
                }

            },

            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // $('#voucherMessage').html('Vui lòng thử lại sau.');
            }
        });
    }
    //
    function updateSubtotal(newSubtotal, newdiscount) {
        var subtotalVND = newSubtotal.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
        var newdiscount = newdiscount.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
        $('#cartSubtotal').text(subtotalVND);
        $('#CartDiscount').text('- ' + newdiscount);
    }
    ///update subtotal, total trong cart
    function SubtotalTotal() {
        $.ajax({
            url: "{{ route('cart.total.subtotal') }}",
            method: 'GET',
        }).done(function(response) {
            $('#cartquantity').text(response.dataSubtotalTotal.cartQuantity + ' items');
            var subtotalVND = response.dataSubtotalTotal.subtotal.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            var totalVND = response.dataSubtotalTotal.total.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            var discountPercent = response.dataSubtotalTotal.totalDiscountAmount.toLocaleString('vi-VN', {
                style: 'currency',
                currency: 'VND'
            });
            $('#cartSubtotal').text(subtotalVND);
            $('#CartDiscount').text('- ' + discountPercent);
            $('#cartTotal').text(totalVND);
        }).fail(function(xhr, status, error) {});
    }
    ///quantity button click
    $(document).ready(function() {
        $('.increaseQuantityBtn').on('click', function() {
            increaseQuantity($(this));
        });

        $('.decreaseQuantityBtn').on('click', function() {
            decreaseQuantity($(this));
        });

        $('.quantityInput').on('input', function() {
            updateQuantity($(this));
        });
    });
    $(document).on('keypress', 'input', function(e) {
        if (e.which == 13) {
            e.preventDefault();
            var form = $(this).closest('form');
            if (form.length > 0) {
                updateQuantity(form);
            }
        }
    });

    function increaseQuantity(btn) {
        var quantityInput = btn.parent().find(".quantityInput");
        var currentValue = parseInt(quantityInput.val());
        quantityInput.val(currentValue + 1);
        updateQuantity(quantityInput);
    }

    function decreaseQuantity(btn) {
        var quantityInput = btn.parent().find(".quantityInput");
        var currentValue = parseInt(quantityInput.val());
        if (currentValue > 1) {
            quantityInput.val(currentValue - 1);
            updateQuantity(quantityInput);
        }
    }

    function updateQuantity(input) {
        var formData = input.closest('form').serialize();
        var url = input.closest('form').attr('action');
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            success: function(response) {
                if (response.success) {
                    SubtotalTotal();
                } else {
                    showNotification(response.message)
                }
            },
            error: function(xhr, status, error) {
                // console.error(error);
                // if (xhr.responseJSON && xhr.responseJSON.message) {
                //     console.error(xhr.responseJSON.message);
                // }
            }
        });
    }
</script>

</html>