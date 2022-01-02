<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController; //add jwt AuthController
use App\Http\Controllers\Api\EmployeeController; //add employee Controller
use App\Http\Controllers\Api\SupplierController; //add supplier Controller
use App\Http\Controllers\Api\CategoryController; //add Category Controller
use App\Http\Controllers\Api\ProductController; //add Product Controller
use App\Http\Controllers\Api\ExpenseController; //add Expense Controller
use App\Http\Controllers\Api\SalaryController; //add Salary Controller
use App\Http\Controllers\Api\CustomerController; //add Customer Controller
use App\Http\Controllers\Api\CartController; //add Cart Controller
use App\Http\Controllers\Api\PosController; //add Pos Controller
use App\Http\Controllers\Api\OrderController; //add Order Controller
use App\Http\Controllers\Api\PlaylistController; //add Playlist Controller




Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::get('forget/{id}', [AuthController::class, 'GetPassword']);
    Route::post('reset', [AuthController::class, 'ResetPassword']);

    // Route::apiResource('/employee','Api\EmployeeController');
});


Route::get('employee', [EmployeeController::class, 'index']);
Route::post('employee', [EmployeeController::class, 'store']);
Route::delete('employee/{id}', [EmployeeController::class, 'destroy']);
Route::patch('employee/{id}', [EmployeeController::class, 'update']);
Route::get('employee/{id}', [EmployeeController::class, 'show']);

//routes for supplier
Route::get('supplier', [SupplierController::class, 'index']);
Route::post('supplier', [SupplierController::class, 'store']);
Route::delete('supplier/{id}', [SupplierController::class, 'destroy']);
Route::patch('supplier/{id}', [SupplierController::class, 'update']);
Route::get('supplier/{id}', [SupplierController::class, 'show']);

//routes for Category
Route::get('category', [CategoryController::class, 'index']);
Route::post('category', [CategoryController::class, 'store']);
Route::delete('category/{id}', [CategoryController::class, 'destroy']);
Route::patch('category/{id}', [CategoryController::class, 'update']);
Route::get('category/{id}', [CategoryController::class, 'show']);

//routes for Product
Route::get('product', [ProductController::class, 'index']);
Route::post('product', [ProductController::class, 'store']);
Route::delete('product/{id}', [ProductController::class, 'destroy']);
Route::patch('product/{id}', [ProductController::class, 'update']);
Route::get('product/{id}', [ProductController::class, 'show']);

//routes for Expenses
Route::get('expense', [ExpenseController::class, 'index']);
Route::post('expense', [ExpenseController::class, 'store']);
Route::delete('expense/{id}', [ExpenseController::class, 'destroy']);
Route::patch('expense/{id}', [ExpenseController::class, 'update']);
Route::get('expense/{id}', [ExpenseController::class, 'show']);

//routes for salary
Route::post('salary/paid/{id}', [SalaryController::class, 'Paid']);
Route::get('salary', [SalaryController::class, 'AllSalary']);
Route::get('salary/view/{id}', [SalaryController::class, 'ViewSalary']);


Route::get('edit/salary/{id}', [SalaryController::class, 'EditSalary']);
Route::post('salary/update/{id}', [SalaryController::class, 'UpdateSalary']);

//stock
Route::post('stock/update/{id}', [ProductController::class, 'StockUpdate']);

//Customer
Route::get('customer', [CustomerController::class, 'index']);
Route::post('customer', [CustomerController::class, 'store']);
Route::delete('customer/{id}', [CustomerController::class, 'destroy']);
Route::patch('customer/{id}', [CustomerController::class, 'update']);
Route::get('customer/{id}', [CustomerController::class, 'show']);

Route::get('/getting/product/{id}', [PosController::class, 'GetProduct']);

//ADD TO CART ROUTE
Route::get('/addToCart/{id}', [CartController::class, 'AddToCart']);
Route::get('/cart/product', [CartController::class, 'CartProduct']);

Route::delete('/remove/cart/{id}', [CartController::class, 'removeCart']);

Route::get('/increment/{id}', [CartController::class, 'increment']);
Route::get('/decrement/{id}', [CartController::class, 'decrement']);


//Vat Route
Route::get('/vats', [CartController::class, 'Vats']);

Route::post('/orderdone', [PosController::class, 'OrderDone']);

//Order Route
Route::get('/orders', [OrderController::class, 'TodayOrder']);

Route::get('/order/details/{id}', [OrderController::class, 'OrderDetails']);
Route::get('/order/orderdetails/{id}', [OrderController::class, 'OrderDetailsAll']);

Route::post('/search/order', [PosController::class, 'SearchOrderDate']);


//Admin Home Page Route
Route::get('/today/sell', [PosController::class, 'TodaySell']);
Route::get('/today/income', [PosController::class, 'TodayIncome']);
Route::get('/today/due', [PosController::class, 'TodayDue']);
Route::get('/today/expense', [PosController::class, 'TodayExpense']);

Route::get('/today/stockout', [PosController::class, 'StockOut']);

//music player api
Route::get('/music/getsongdata', [PlaylistController::class, 'GetSongData']);
Route::post('/save/music', [PlaylistController::class, 'SaveMusic']);
Route::delete('/deletesong/{id}', [PlaylistController::class, 'Destroy']);
Route::post('/editsong/{id}', [PlaylistController::class, 'EditMusic']);

