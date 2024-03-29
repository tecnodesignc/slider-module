<?php

namespace Modules\Slider\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanGetSidebarClassForModule;
use Modules\Slider\Entities\Slider;
use Modules\Slider\Entities\Slide;
use Modules\Slider\Events\Handlers\RegisterSliderSidebar;
use Modules\Slider\Presenters\SliderPresenter;
use Modules\Slider\Repositories\Cache\CacheSlideApiDecorator;
use Modules\Slider\Repositories\Cache\CacheSliderDecorator;
use Modules\Slider\Repositories\Cache\CacheSlideDecorator;
use Modules\Slider\Repositories\Eloquent\EloquentSlideApiRepository;
use Modules\Slider\Repositories\Eloquent\EloquentSliderRepository;
use Modules\Slider\Repositories\Eloquent\EloquentSlideRepository;
use Modules\Core\Traits\CanPublishConfiguration;

class SliderServiceProvider extends ServiceProvider
{
  use CanPublishConfiguration, CanGetSidebarClassForModule ;

  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  /**
   * Register the service provider.
   *
   * @return void
   */
  public function register()
  {
    $this->registerBindings();

      $this->app['events']->listen(
          BuildingSidebar::class,
          $this->getSidebarClassForModule('slider', RegisterSliderSidebar::class)
      );

      $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
          $event->load('frontend', Arr::dot(trans('slider::frontend')));
          $event->load('messages', Arr::dot(trans('slider::messages')));
          $event->load('slider', Arr::dot(trans('slider::slider')));
          $event->load('slides', Arr::dot(trans('slider::slides')));
          $event->load('validation', Arr::dot(trans('slider::validation')));
          // append translations

      });

  }

  /**
   * Register all online sliders on the Pingpong/Menu package
   */
  public function boot()
  {
    $this->publishConfig('slider', 'config');
    $this->publishConfig('slider', 'permissions');

    $this->registerSliders();
    $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'slider');
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array('sliders');
  }

  /**
   * Register class binding
   */
  private function registerBindings()
  {
    $this->app->bind(
      'Modules\Slider\Repositories\SliderRepository',
      function () {
        $repository = new EloquentSliderRepository(new Slider());

        if (!config('app.cache')) {
          return $repository;
        }

        return new CacheSliderDecorator($repository);
      }
    );

    $this->app->bind(
      'Modules\Slider\Repositories\SlideRepository',
      function () {
        $repository = new EloquentSlideRepository(new Slide());

        if (!config('app.cache')) {
          return $repository;
        }

        return new CacheSlideDecorator($repository);
      }
    );

    $this->app->bind(
      'Modules\Slider\Repositories\SlideApiRepository',
      function () {
        $repository = new EloquentSlideApiRepository(new Slide());

        if (!config('app.cache')) {
          return $repository;
        }

        return new CacheSlideApiDecorator($repository);
      }
    );

    $this->app->bind('Modules\Slider\Presenters\SliderPresenter');
  }

  /**
   * Register the active sliders
   */
  private function registerSliders()
  {
    if (!$this->app['encore.isInstalled']) {
      return;
    }
  }

}
