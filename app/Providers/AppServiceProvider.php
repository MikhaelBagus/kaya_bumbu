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
use App\Services\Bank\BankService;
use App\Services\Bank\BankServiceContract;
use App\Services\Province\ProvinceService;
use App\Services\Province\ProvinceServiceContract;
use App\Services\City\CityService;
use App\Services\City\CityServiceContract;
use App\Services\Source\SourceService;
use App\Services\Source\SourceServiceContract;
use App\Services\Customer\CustomerService;
use App\Services\Customer\CustomerServiceContract;
use App\Services\Driver\DriverService;
use App\Services\Driver\DriverServiceContract;
use App\Services\Product\ProductService;
use App\Services\Product\ProductServiceContract;
use App\Services\Transaction\TransactionService;
use App\Services\Transaction\TransactionServiceContract;
use App\Services\Log\LogService;
use App\Services\Log\LogServiceContract;

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
            BankServiceContract::class,
            BankService::class
        );

        $this->app->bind(
            ProvinceServiceContract::class,
            ProvinceService::class
        );

        $this->app->bind(
            CityServiceContract::class,
            CityService::class
        );

        $this->app->bind(
            SourceServiceContract::class,
            SourceService::class
        );

        $this->app->bind(
            CustomerServiceContract::class,
            CustomerService::class
        );

        $this->app->bind(
            DriverServiceContract::class,
            DriverService::class
        );

        $this->app->bind(
            ProductServiceContract::class,
            ProductService::class
        );

        $this->app->bind(
            TransactionServiceContract::class,
            TransactionService::class
        );

        $this->app->bind(
            LogServiceContract::class,
            LogService::class
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
