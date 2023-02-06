<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Logout\LogoutService;
use App\Services\Logout\LogoutServiceContract;
use App\Services\Register\RegisterService;
use App\Services\Register\RegisterServiceContract;
use App\Services\Profile\ProfileService;
use App\Services\Profile\ProfileServiceContract;
use App\Services\ForgotPassword\ForgotPasswordService;
use App\Services\ForgotPassword\ForgotPasswordServiceContract;
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
use App\Services\News\NewsService;
use App\Services\News\NewsServiceContract;
use App\Services\Faq\FaqService;
use App\Services\Faq\FaqServiceContract;
use App\Services\Media\MediaService;
use App\Services\Media\MediaServiceContract;


use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

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
            LogoutServiceContract::class,
            LogoutService::class
        );

        $this->app->bind(
            RegisterServiceContract::class,
            RegisterService::class
        );

        $this->app->bind(
            ProfileServiceContract::class,
            ProfileService::class
        );

        $this->app->bind(
            ForgotPasswordServiceContract::class,
            ForgotPasswordService::class
        );

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
            DisclaimerServiceContract::class,
            DisclaimerService::class
        );

        $this->app->bind(
            NewsServiceContract::class,
            NewsService::class
        );

        $this->app->bind(
            FaqServiceContract::class,
            FaqService::class
        );

        $this->app->bind(
            MediaServiceContract::class,
            MediaService::class
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
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
