<?php
use App\Controllers\ContactController;
use App\Controllers\LegalController;
use App\Controllers\PropertyController;
use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AjaxController;

Router::get('/', [HomeController::class, 'index']);
Router::get('/ajax/towns', [AjaxController::class, 'towns']);
Router::get('/property/{id}', [PropertyController::class, 'show']);
Router::post('/contact', [ContactController::class, 'send']);
Router::get('/ajax/properties', [AjaxController::class, 'list']);

Router::get('/legal',   [LegalController::class, 'legal']);
Router::get('/privacy', [LegalController::class, 'privacy']);
Router::get('/cookies', [LegalController::class, 'cookies']);