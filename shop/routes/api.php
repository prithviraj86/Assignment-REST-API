<?php

use Illuminate\Http\Request;
use App\Shop;
use App\Products;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('shop', 'ShopController@store');
Route::post('shop/{sid}/product', 'ShopController@storeProduct');
Route::post('shop/{sid}/products', 'ShopController@getPro');
Route::put('shop/{sid}/product/{pid}', 'ShopController@upProduct');
Route::delete('shop/{sid}/product/{pid}', 'ShopController@delProduct');

// Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
// });
// Route::post('shop', function(Request $request) {
    // return Shop::create($request->all);
// });

// Route::put('articles/{id}', function(Request $request, $id) {
    // $article = Article::findOrFail($id);
    // $article->update($request->all());

    // return $article;
// });

// Route::delete('articles/{id}', function($id) {
    // Article::find($id)->delete();

    // return 204;
// })
