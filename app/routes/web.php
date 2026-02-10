<?php
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AjaxController;

Router::get('/', [HomeController::class, 'index']);
Router::get('/ajax/towns', [AjaxController::class, 'towns']);