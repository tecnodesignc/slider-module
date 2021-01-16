<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group(['prefix' => '/slide'], function (Router $router) {
  $router->get('/', [
    'as' => 'api.slide.index',
    'uses' => 'SlideApiController@index'
  ]);

  $router->get('/{id}', [
    'as' => 'api.slide.show',
    'uses' => 'SlideApiController@show'
  ]);

  $router->post('/update', [
    'as' => 'api.slide.update',
    'uses' => 'SlideController@update',
    'middleware' => 'token-can:slider.slides.update',
  ]);

  $router->post('/delete', [
    'as' => 'api.slide.delete',
    'uses' => 'SlideController@delete',
    'middleware' => 'token-can:slider.slides.destroy'
  ]);
});
