<?php

use App\Http\Controllers\AdminController;
use Laravel\Folio\Folio;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\AuthenMiddleware;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CRUDController;
use App\Http\Controllers\ViewCartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CustomCheckRole;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\ReactController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SliderController;
use App\Models\Product;
use App\Models\featured_sections;



Route::get('/welcome', function () {
    return view('welcome');
});
//////// 
Route::get('/', [UserController::class, 'product'])->name('product');
Route::get('/get-product', [UserController::class, 'getProduct'])->name('get.product');
Route::get('/api/products', [ReactController::class, 'index']);
//////
Route::get('/error', [SectionController::class, 'error'])->name('error.page');
Route::get('/size-guize', [HomeController::class, 'size'])->name('size.guize');
Route::get('/cart/quantity', [CartController::class, 'getCartQuantity'])->name('cart.quantity');
Route::get('/cart-stt-tt', [CartController::class, 'SubtotalTotal'])->name('cart.total.subtotal');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/homepage', [UserController::class, 'homepage'])->name('homepage');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::get('/forgotpassword', [ForgotPasswordController::class, 'index'])->name('forgotpassword');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/do-login', [LoginController::class, 'checklogin'])->name('admin.login');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');
Route::post('/add-to-cart', [CartController::class, 'addcart'])->name('addcart');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart-remove', [CartController::class, 'cartremore'])->name('cart.remove');
Route::post('/cart-view-remove', [CartController::class, 'cartviewremore'])->name('cart.view.remove');
Route::get('/get-cart', [ViewCartController::class, 'viewCart'])->name('get-cart');
Route::post('/cart/update-quantity', [CartController::class, 'updateQuantity'])->name('cart.update-quantity');
Route::post('/check-stock', [ProductController::class, 'checkStock'])->name('checkStock');
Route::post('/check-quantity-stock', [ProductController::class, 'checkQuantityProduct'])->name('checkQuantityStock');
Route::post('/check-quantity-all', [ProductController::class, 'checkQuantityAll'])->name('checkQuantityAll');
Route::get('/load-more', [ProductController::class, 'loadMoreProduct'])->name('loadmoreproducts');
Route::post('/load-more', [ProductController::class, 'loadMoreProduct'])->name('loadmoreproducts');
Route::get('/products', [DashboardController::class, 'productView'])->name('product.view.view');
Route::get('/product/mens', [DashboardController::class, 'productformen'])->name('product.formen');
Route::get('/product/womens', [DashboardController::class, 'productforwomen'])->name('product.forwomen');
Route::get('/product/unisexs', [DashboardController::class, 'productforunisex'])->name('product.forunisex');
Route::get('/get-unisex', [DashboardController::class, 'getUnisex'])->name('get.unisex.product');
Route::get('/get-women', [DashboardController::class, 'getWomen'])->name('get.women.product');
Route::get('/get-men', [DashboardController::class, 'getMen'])->name('get.men.product');
Route::get('/product-view', [DashboardController::class, 'getProductView'])->name('get.productview.product');
Route::get('/product/bestsellers', [DashboardController::class, 'bestsellView'])->name('product.bestseller.view');
Route::get('/get-bestsell', [DashboardController::class, 'getBestSell'])->name('get.bestsell.product');
Route::get('/view/{id}', [ProductController::class, 'view'])->name('product.view');
Route::post('/hand/checkout', [CheckoutController::class, 'handlecheckout'])->name('handlecheckout.checkout');
Route::get('/payment/check', [PaymentController::class, 'paymentwithcredit'])->name('payment.credit');
Route::get('/payment/check', [PaymentController::class, 'paymentwithmeet'])->name('payment.meet');
Route::get('/payment/check', [PaymentController::class, 'paymentwithqr'])->name('payment.qr');
Route::get('/payment/check', [PaymentController::class, 'paymentwithbank'])->name('payment.bank');
Route::get('/payment/check', [PaymentController::class, 'paymentwithpaypal'])->name('payment.paypal');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/cart/update', [CartController::class, 'updateTime'])->name('cart.update.time');
Route::post('/check-voucher', [VouchersController::class, 'checkVouchers'])->name('check-voucher');
Route::get('/new/product', [ProductController::class, 'newproduct'])->name('product.new');
Route::get('/get-new', [ProductController::class, 'getNewproduct'])->name('get.new.product');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/product/discount', [DashboardController::class, 'discountView'])->name('discount.view.view');
Route::get('/get-discount', [DashboardController::class, 'getDiscountView'])->name('get.discount.view');
Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/home', [UserController::class, 'home'])->name('home');
Route::get('/project', [UserController::class, 'project'])->name('project');
Route::get('/blog', [UserController::class, 'blog'])->name('blog');
Route::get('/contact', [UserController::class, 'contact'])->name('contact');
Route::get('/filter-content', [FilterController::class, 'filterContent'])->name('filter.content');
//admin
Route::middleware(['checkRole'])->group(function () {
    Route::get('/send/mail', [EmailController::class, 'sendMail'])->name('send.mail');
    Route::get('admin/', [AdminController::class, 'index']);
    Route::post('/upload-img', [AuthController::class, 'store'])->name('upload.img');
    Route::post('/upload/file', [AuthController::class, 'uploadFile'])->name('upload.file');

    Route::get('/product/{id}/edit', [CRUDController::class, 'edit'])->name('product.edit');
    Route::post('/product/{id}/update', [CRUDController::class, 'update'])->name('update.product');
    Route::get('/productmanagement', [ProductController::class, 'product'])->name('productmanagement');
    Route::delete('/productmanagement/delete/{id}', [ProductController::class, 'removeproduct'])->name('productmanagement.delete');
    Route::delete('/featuredsections/delete/{id}', [SectionController::class, 'featuredsectionsDelete'])->name('featuredsections.delete');
    Route::get('/featuredsections/{id}/edit', [SectionController::class, 'featuredsectionsEdit'])->name('featuredsections.edit');
    Route::get('/featuredsection', [SectionController::class, 'featuredsection'])->name('featuredsection');
    Route::post('/featuredsection/edit', [SectionController::class, 'featuredsectionEdit'])->name('featuredsection.edit');
    Route::post('/featuredsection/update', [SectionController::class, 'featuredsectionsUpdate'])->name('featuredsection.update');

    Route::get('/section/nd', [SectionController::class, 'section_02'])->name('section.nd');
    Route::post('/section-edit', [SectionController::class, 'section_02Edit'])->name('section_02.edit');
    Route::get('/section/{section_id}', [SectionController::class, 'section_02Update'])->name('section_02.update');
    Route::post('/section/update', [SectionController::class, 'sectionUpdate'])->name('section.update');
    Route::get('/section-upload', [SectionController::class, 'upload_section'])->name('upload.section');
    Route::post('/section-delete', [SectionController::class, 'section_02Delete'])->name('section_02.delete');

    Route::get('/producttable', [TableController::class, 'index'])->name('producttable');
    Route::get('/usermanagement', [UserManagementController::class, 'index'])->name('usermanagement');
    Route::delete('/usermanagement/delete/{id}', [UserManagementController::class, 'delete'])->name('usermanagement.delete');
    Route::get('/uploadproduct', [AuthController::class, 'index'])->name('uploadproduct.show');
    Route::post('/uploadproduct', [AuthController::class, 'upload'])->name('uploadproduct');
    Route::get('/customers', [ProductManagementController::class, 'customertable'])->name('customers');
    Route::delete('/customer/delete/{id}', [ProductManagementController::class, 'customerdelete'])->name('customer.delete');
    Route::post('/customer/edit/{id}', [ProductManagementController::class, 'customeredit'])->name('customer.edit');
    Route::get('/ordermanagements', [ProductManagementController::class, 'order'])->name('ordermanagements');
    Route::get('/orderdetail/{id}', [ProductManagementController::class, 'orderdetail'])->name('orderdetail');
    Route::get('/orders/filter', [ProductManagementController::class, 'orderdetail'])->name('order.filter');
    Route::get('/vouchers', [VouchersController::class, 'view'])->name('vouchers.view');
    Route::post('/vouchers/edit', [VouchersController::class, 'edit'])->name('vouchers.edit');
    Route::get('/vouchers/update/{id}', [VouchersController::class, 'updateVouchers'])->name('vouchers.update');
    Route::get('/vouchers/upload', [VouchersController::class, 'uploadVouchers'])->name('vouchers.upload');
    Route::delete('/vouchers/delete/{id}', [VouchersController::class, 'deleteVouchers'])->name('vouchers.delete');
    Route::post('/vouchers/{id}/edit', [VouchersController::class, 'editVouchers'])->name('edit.vouchers');
    Route::get('/slider', [SliderController::class, 'slider'])->name('slider');
    Route::post('/slider/edit', [SliderController::class, 'sliderEdit'])->name('slider.edit');
    Route::delete('/slider/delete/{id}', [SliderController::class, 'sliderDelete'])->name('slider.delete');
    Route::get('/slider/update/{id}', [SliderController::class, 'sliderUpdate'])->name('slider.update');
    Route::post('/slider/update', [SliderController::class, 'editView'])->name('slider.view.update');
    Route::get('/slider/upload', [SliderController::class, 'sliderUpload'])->name('slider.upload');
    Route::get('/discount', [DiscountController::class, 'discountView'])->name('discount.view');
    Route::get('/discount/edit/{id}', [DiscountController::class, 'discountEdit'])->name('discount.edit');
    Route::post('/discount/update', [DiscountController::class, 'discountUpdate'])->name('discount.update');
});
// users
Route::middleware([AuthenMiddleware::class])->group(function () {
    Route::get('/changepassword', [ChangePasswordController::class, 'index'])->name('changepassword');
    Route::post('/change-password', [ChangePasswordController::class, 'change'])->name('change.password');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
});
