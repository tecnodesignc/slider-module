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
$router->group(['prefix' => '/slider/v1'], function (Router $router) {
    $router->group(['prefix' => '/sliders'], function (Router $router) {

        $router->get('/', [
            'as' => 'api.slider.slider.index',
            'uses' => 'SliderApiController@index',
            //'middleware' => 'token-can:slider.sliders.index'
        ]);

        $router->post('/', [
            'as' => 'api.slider.slider.store',
            'uses' => 'SliderApiController@store',
            'middleware' => ['api.token', 'can:slider.sliders.create']
        ]);

        $router->get('/{slider}', [
            'as' => 'api.slider.slider.show',
            'uses' => 'SliderApiController@show',
            //'middleware' => 'token-can:slider.sliders.index'
        ]);

        $router->put('/{slider}', [
            'as' => 'api.slider.slider.update',
            'uses' => 'SlideApiController@update',
            'middleware' => ['api.token', 'token-can:slider.sliders.edit']
        ]);

        $router->delete('/{slider}', [
            'as' => 'api.slider.slider.destroy',
            'uses' => 'SliderApiController@destroy',
            'middleware' => ['api.token', 'token-can:slider.sliders.destroy']
        ]);

    });
    $router->group(['prefix' => '/slides', 'middleware' => ['api.token']], function (Router $router) {

        $router->get('/', [
            'as' => 'api.slider.slide.index',
            'uses' => 'SlideApiController@index',
            'middleware' => 'token-can:slider.slides.index'
        ]);

        $router->post('/', [
            'as' => 'api.slider.slide.store',
            'uses' => 'SlideApiController@store',
            'middleware' => 'can:slide.slides.create'
        ]);

        $router->get('/{slide}', [
            'as' => 'api.slider.slider.show',
            'uses' => 'SlideApiController@show',
            'middleware' => 'token-can:slider.slides.index'
        ]);

        $router->put('/{slide}', [
            'as' => 'api.slider.slider.update',
            'uses' => 'SlideApiController@update',
            'middleware' => 'token-can:slider.slides.edit'
        ]);

        $router->delete('/{slide}', [
            'as' => 'api.slider.slide.destroy',
            'uses' => 'SlideApiController@destroy',
            'middleware' => 'token-can:slider.slides.destroy'
        ]);

    });
});
