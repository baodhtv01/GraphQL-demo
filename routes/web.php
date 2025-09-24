<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/graphql-demo', function () {
    return view('graphql-demo');
});
