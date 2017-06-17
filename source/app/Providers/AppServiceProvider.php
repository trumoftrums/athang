<?php

namespace App\Providers;

use App\AccessaryCar;
use App\BaiXe;
use App\City;
use App\DesignCar;
use App\Http\Controllers\Admin\ThuexeController;
use App\Http\Controllers\Frontend\HomeController;
use App\LendCar;
use App\Models\Baiviet;
use App\Models\Hangxe;
use App\Models\Users;
use App\News;
use App\SupportCar;
use App\Video;
use App\VideoCat;
use App\VideoEmbed;
use App\VipSalon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use App\Models\Thongso;
use App\Models\ViewLog;
use Mockery\CountValidator\Exception;
use App\Models\Groups;
use App\Models\AdminPermission;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
