<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/event',function (){
    NewEvent::dispatch();
});

Route::get('/exception',function (){
    throw new Exception("this is an exception");
});

Route::get('/gates',function (){
    if (Gate::forUser(Auth::user())->allows('testGate')) {
        return 'you are allowed to take this action';
    }
    abort(403);
});

Route::get('/http',function (){
    return Http::get('http://ahmed3.sa');
});

Route::get('/logs',function (){
    Log::error("hello from the logs");;
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
//
//Route::get('/auth/redirect', function () {
//    return Socialite::driver('github')->redirect();
//});
//
//Route::get('/auth/callback', function () {
//    $user = Socialite::driver('github')->user();
//
//    // $user->token
//});

require __DIR__.'/auth.php';


Route::name('socialite.')->controller(SocialiteController::class)->group(function (){

        Route::get('{provider}/login','login')->name('login');
        Route::get('{provider}/redirect','redirect')->name('redirect');
    });
