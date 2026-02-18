<?php
use App\Controllers\ContactController;
use App\Controllers\PropertyController;
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AjaxController;

Router::get('/', [HomeController::class, 'index']);
Router::get('/ajax/towns', [AjaxController::class, 'towns']);
Router::get('/property/{id}', [PropertyController::class, 'show']);
Router::post('/contact', [ContactController::class, 'send']);
