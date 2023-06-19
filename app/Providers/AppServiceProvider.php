<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AboutUs\AboutUsService;
use App\Services\AboutUs\AboutUsServiceContract;
use App\Services\ContactUs\ContactUsService;
use App\Services\ContactUs\ContactUsServiceContract;
use App\Services\Disclaimer\DisclaimerService;
use App\Services\Disclaimer\DisclaimerServiceContract;
use App\Services\PrivacyPolicy\PrivacyPolicyService;
use App\Services\PrivacyPolicy\PrivacyPolicyServiceContract;
use App\Services\TermCondition\TermConditionService;
use App\Services\TermCondition\TermConditionServiceContract;
use App\Services\Logout\LogoutService;
use App\Services\Logout\LogoutServiceContract;
use App\Services\ForgotPassword\ForgotPasswordService;
use App\Services\ForgotPassword\ForgotPasswordServiceContract;
use App\Services\Register\RegisterService;
use App\Services\Register\RegisterServiceContract;
use App\Services\Profile\ProfileService;
use App\Services\Profile\ProfileServiceContract;
use App\Services\News\NewsService;
use App\Services\News\NewsServiceContract;
use App\Services\Faq\FaqService;
use App\Services\Faq\FaqServiceContract;
use App\Services\Constraction\ConstractionService;
use App\Services\Constraction\ConstractionServiceContract;
use App\Services\Type\TypeService;
use App\Services\Type\TypeServiceContract;
use App\Services\Unit\UnitService;
use App\Services\Unit\UnitServiceContract;
use App\Services\Feeder\FeederService;
use App\Services\Feeder\FeederServiceContract;
use App\Services\Asset\AssetService;
use App\Services\Asset\AssetServiceContract;
use App\Services\AssetToAsset\AssetToAssetService;
use App\Services\AssetToAsset\AssetToAssetServiceContract;
use App\Services\Network\NetworkService;
use App\Services\Network\NetworkServiceContract;
use App\Services\Gallery\GalleryService;
use App\Services\Gallery\GalleryServiceContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            AboutUsServiceContract::class,
            AboutUsService::class
        );

        $this->app->bind(
            ContactUsServiceContract::class,
            ContactUsService::class
        );

        $this->app->bind(
            DisclaimerServiceContract::class,
            DisclaimerService::class
        );

        $this->app->bind(
            PrivacyPolicyServiceContract::class,
            PrivacyPolicyService::class
        );

        $this->app->bind(
            TermConditionServiceContract::class,
            TermConditionService::class
        );

        $this->app->bind(
            LogoutServiceContract::class,
            LogoutService::class
        );

        $this->app->bind(
            RegisterServiceContract::class,
            RegisterService::class
        );

        $this->app->bind(
            ForgotPasswordServiceContract::class,
            ForgotPasswordService::class
        );

        $this->app->bind(
            ProfileServiceContract::class,
            ProfileService::class
        );

        $this->app->bind(
            NewsServiceContract::class,
            NewsService::class
        );

        $this->app->bind(
            ConstractionServiceContract::class,
            ConstractionService::class
        );

        $this->app->bind(
            TypeServiceContract::class,
            TypeService::class
        );

        $this->app->bind(
            UnitServiceContract::class,
            UnitService::class
        );

        $this->app->bind(
            FeederServiceContract::class,
            FeederService::class
        );

        $this->app->bind(
            AssetServiceContract::class,
            AssetService::class
        );

        $this->app->bind(
            AssetToAssetServiceContract::class,
            AssetToAssetService::class
        );

        $this->app->bind(
            NetworkServiceContract::class,
            NetworkService::class
        );

        $this->app->bind(
            GalleryServiceContract::class,
            GalleryService::class
        );
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
