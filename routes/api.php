<?php

use App\Http\Resources\UserRessource;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/users', function () {
    return UserRessource::collection(User::all());
});
