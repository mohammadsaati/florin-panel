<?php

namespace App\Providers;

use App\Commons\Menu\MenuRegistry;
use App\Commons\Menu\Menus\AdminMenu;
use App\Services\city\CityService;
use App\Services\Contracts\CityServiceInterface;
use App\Services\Contracts\QuestionServiceInterface;
use App\Services\Contracts\SurveyServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\survey\SurveyService;
use App\Services\user\QuestionService;
use App\Services\user\UserService;
use Carbon\Carbon;
use Exception;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->registerServices();
    }

    public function boot(): void
    {
        Request::macro(
            name: 'jDate',
            /**
             * @param string $key
             * @param string|null $format
             * @param string|null $tz
             * @return Verta|null
             *
             * @throw InvalidDatetimeException
             */
            macro: function (string $key, string|null $format = null, string|null $tz = null): Verta|null {
                if (! $tz) {
                    $tz = config('app.timezone');
                }

                if ($this->isNotFilled($key)) {
                    return null;
                }

                if (is_null($format)) {
                    return Verta::parse($this->input($key), $tz);
                }

                return Verta::parseFormat($format, $this->input($key), $tz);
            }
        );

        Request::macro(
            name: 'jDateToCarbon',
            /**
             * @param string $key
             * @param string|null $format
             * @param string|null $tz
             * @return Verta|null
             *
             * @throw InvalidDatetimeException
             *
             * @throws Exception
             */
            macro: function (string $key, string|null $format = null, string|null $tz = null): Carbon|null {
                if ($this->isNotFilled($key)) {
                    return null;
                }

                if (is_null($format)) {
                    return Verta::parse($this->input($key), $tz)->toCarbon();
                }

                return Verta::parseFormat($format, $this->input($key), $tz)->toCarbon();
            }
        );


        MenuRegistry::register('admin', new AdminMenu());

        Paginator::useTailwind();
    }

    private function registerServices(): void
    {
        $this->app->singleton(UserServiceInterface::class, UserService::class);
        $this->app->singleton(CityServiceInterface::class, CityService::class);
        $this->app->singleton(QuestionServiceInterface::class, QuestionService::class);
        $this->app->singleton(SurveyServiceInterface::class, SurveyService::class);
    }
}
