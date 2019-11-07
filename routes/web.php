<?php

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/',[
    'uses'=>'FrontendController@getWelcome',
    'as'=>'/'
]);

Route::get('/post-images/{file_name}',[
    'uses'=>'FrontendController@getImage',
    'as'=>'images'
]);

Route::get('/category/id/{cat_id}/posts',[
    'uses'=>'FrontendController@getPostsByCategory',
    'as'=>'posts.by.category'
    ]);

Route::get('/search/post',[
    'uses'=>'FrontendController@getSearchPost',
    'as'=>'search.posts'
]);

Route::get('/add/to/card/{id}',[
    'uses'=>'FrontendController@addToCart',
    'as'=>'add.to.cart'
]);

Route::get('/shopping/cart',[
    'uses'=>'FrontendController@getShoppingCart',
    'as'=>'shopping.cart'
]);

Route::get('/increase/cart/{id}',[
    'uses'=>'FrontendController@getIncreaseCart',
    'as'=>'increase.cart'
]);

Route::get('/decrease/cart/{id}',[
    'uses'=>'FrontendController@getDecreaseCart',
    'as'=>'decrease.cart'
]);

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix'=>'user','middleware'=>'auth'],function(){

    Route::post('/checkout',[
        'uses'=>'FrontendController@postCheckout',
        'as'=>'checkout'
    ]);

    Route::get('/dashboard',[
        'uses'=>'HomeController@index',
        'as'=>'dashboard'
    ]);//->middleware('auth');
    Route::post('/update/user',[
        'uses'=>'UserController@postUpdateUser',
        'as'=>'update.user'
    ]);
    Route::get('/delete/user/id/{id}',[
        'uses'=>'UserController@getDeleteUser',
        'as'=>'delete.user'
    ]);

});

Route::group(['prefix'=>'admin','middleware'=>'role:Admin'],function (){
    Route::get('/waiting/deliver/{id}',[
        'uses'=>'OrderController@getDeliver',
        'as'=>'wait.deliver'
    ]);
    Route::get('/users',[
        'uses'=>'UserController@getUsers',
        'as'=>'users'
    ]);
    Route::post('/assign/user/role',[
        'uses'=>'UserController@postAssignUserRole',
        'as'=>'assign.user.role'
    ]);
});

Route::group(['prefix'=>'posts','middleware'=>'role:Admin'],function(){
    Route::get('/orders/filter/by/month',[
        'uses'=>'OrderController@getOrders',
        'as'=>'filter_by_month'
    ]);
    Route::get('/orders/filter/by/date',[
        'uses'=>'OrderController@getOrders',
        'as'=>'filter_by_date'
    ]);
    Route::get('/orders',[
        'uses'=>'OrderController@getOrders',
        'as'=>'orders'
    ]);
    Route::get('/categories',[
        'uses'=>'PostController@getCategories',
        'as'=>'posts.categories'
    ]);
    Route::post('/new/categories',[
        'uses'=>'PostController@postNewCategories',
        'as'=>'new.category'
        ]);
    Route::get('/delete/category/id/{id}',[
        'uses'=>'PostController@getDeleteCategory',
        'as'=>'delete.category'
    ]);
    Route::post('/update/category',[
        'uses'=>'PostController@postUpdateCategory',
        'as'=>'update.category'
    ]);
    Route::get('/all',[
        'uses'=>'PostController@getPosts',
        'as'=>'posts'
    ]);
    Route::get('/new/post',[
        'uses'=>'PostController@getNewPost',
        'as'=>'post.new'
    ]);
    Route::post('/add/post',[
        'uses'=>'PostController@postNewPost',
        'as'=>'post.add'
    ]);
    Route::get('/posts-image/{file_name}',[
        'uses'=>'PostController@getImage',
        'as'=>'posts.image'
    ]);
    Route::get('/drop/post/{id}',[
        'uses'=>'PostController@getDropPost',
        'as'=>'post.drop'
    ]);
         Route::get('/post/id/{id}/edit',[
             'uses'=>'PostController@getEditPost',
             'as'=>'edit.post'
    ]);
    Route::post('/update/post',[
        'uses'=>'PostController@postUpdatePost',
        'as'=>'update.post'
    ]);
    Route::get('/search/post',[
        'uses'=>'PostController@getSearchPost',
        'as'=>'search.post'
    ]);
    Route::get('/search/post',[
        'uses'=>'PostController@getSearchPost',
        'as'=>'search.post'
    ]);
});
