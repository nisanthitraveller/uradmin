<?php

Route::redirect('/', '/login');

Route::redirect('/home', '/admin');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');

    Route::resource('permissions', 'PermissionsController');

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');

    Route::resource('roles', 'RolesController');

    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');

    Route::get('onlineusers', 'UsersController@onlineusers')->name('users.onlineusers');
    Route::resource('users', 'UsersController');

    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');

    Route::resource('products', 'ProductsController');

    Route::delete('teams/destroy', 'TeamController@massDestroy')->name('teams.massDestroy');
    Route::get('teams/members/{teamId}', 'TeamController@members')->name('teams.members');
    Route::get('vomeetings', 'TeamController@vomeetings')->name('teams.vomeetings');
    Route::get('meetings', 'TeamController@meetings')->name('teams.meetings');
    Route::resource('teams', 'TeamController');
    
});
