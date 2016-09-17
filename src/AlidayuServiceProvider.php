<?php
namespace Chao\Tts;

use Illuminate\Support\ServiceProvider;

class AlidayuServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    // 发布TTS配置文件
    $this->publishes([
      __DIR__ . '/../config/tts.php' => config_path('tts.php'),
    ]);
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind('Chao\Tts\SingleCallApi', 'Chao\Tts\SingleCallPusher');
    $this->app->singleton('tts', function ($app) {
      return $app->make('Chao\Tts\SingleCallApi');
    });
  }

  public function provides()
  {
    return ['tts'];
  }
}
