<?php

namespace App\Providers;

use App\SocialMedia\AbstractSocialMedia;
use App\SocialMedia\Facebook;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use App\SocialMedia\SocialMedia;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AbstractSocialMedia::class, function ($app){
            $http = new Client();
            if(request()->get('socialMedia') == SocialMedia::FACEBOOK){
                return new Facebook($http);
            }
            return new Facebook($http);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
