<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(MemberController::class)->group(function(){
    Route::get('/','index')->name('member.list');
    Route::get('/member-create','create')->name('member.create');
    Route::post('/member-store','store')->name('member.store');
    Route::post('/member/delete','destroy')->name('member.destroy');
    Route::get('/member/edit/{id}','edit')->name('member.edit'); 
    Route::put('/member/update/{id}','update')->name('member.update');

    // Route::get('/member/show/{product}','show')->name('member.show');
    // Route::get('/member/edit/{product}','edit')->name('member.edit');
    // Route::put('/member/{product}','update')->name('member.update');
   
});
