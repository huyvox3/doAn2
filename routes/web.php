<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
        ])->group(function () {
            Route::get('/dashboard', function () {
                return view('dashboard');
            })->name('dashboard');
        });
    
    
    Route::get('/home_page',[UserController::class,'homePage'])->middleware('auth','verified');;
    Route::get('/',function(){
        return view('user.home');
    });
    Route::get('/login_page',[UserController::class, 'loginPage']);
 
    //-----User Routes--
    Route::get('/account_age',[UserController::class, 'accountPage']);
    
    // Product
    Route::get('/product_details/{id}', [UserController::class, 'productDetails']);
    Route::get('/product_page',[UserController::class, 'productPage']);
    Route::get('/related_products',[UserController::class, 'relatedProducts']);
    Route::get('/features_products',[UserController::class, 'featuresProducts']);
    Route::get('/latest_products',[UserController::class, 'latestProducts']);
    Route::get('/singe_category_products/{category}',[UserController::class, 'singeCategory']);
    Route::get('/searchProducts',[UserController::class, 'searchProducts']);
    // Cart
    Route::get('/cart_page',[UserController::class, 'cartPage']);
    Route::post('/add_to_cart',[UserController::class,'addToCart']); 
    Route::get('/count_cart',[UserController::class, 'countCart']);
    Route::get('/cart_info',[UserController::class, 'cartInfo']);
    Route::get('/remove_cartItem',[UserController::class, 'removeCartItem']);
    //Orders
    Route::get('/orders',[UserController::class, 'viewOrder'])->name('orders');
    Route::get('/order_details',[UserController::class, 'orderDetails']);
    Route::get('/order_lines',[UserController::class,'orderLines']);
    //Payment

    Route::get('createpaypal',[UserController::class,'createpaypal'])->name('createpaypal');
    Route::get('processPaypal',[UserController::class,'processPaypal'])->name('processPaypal');
    Route::get('processSuccess',[UserController::class,'processSuccess'])->name('processSuccess');
    Route::get('processCancel',[UserController::class,'processCancel'])->name('processCancel');

    //-----End User Routes---


    // Admin Routes
    Route::get('admin_home',[AdminController::class, 'adminHome']);
    Route::get('name',[AdminController::class,'getName']);
    //Products
    Route::get('/add_product',[AdminController::class, 'addProduct']);
    Route::post('/create_product',[AdminController::class, 'createProduct']);
    Route::get('/show_product',[AdminController::class, 'showProduct']);
    Route::get('/delete_product/{id}',[AdminController::class, 'deleteProduct']);
    //Orders
    Route::get('/admin_orders',[AdminController::class, 'orders']);
    Route::get('/order_admin',[AdminController::class, 'orderDetails']);
    Route::get('/confirm_ship',[AdminController::class,'confirmShip']);
    Route::get('/complete_order',[AdminController::class, 'completeOrder']);
    Route::get('/cancel_order',[AdminController::class, 'cancelOrder']);

    Route::get('/send_email',[AdminController::class, 'sendEmail']);
    //Catergory
    Route::get('/view_category',[AdminController::class, 'viewCategory']);
    Route::post('/add_category',[AdminController::class, 'addCategory']);
    Route::get('/delete_category',[AdminController::class, 'deleteCategory']);
    Route::get('/category',[AdminController::class,'category']); 
   