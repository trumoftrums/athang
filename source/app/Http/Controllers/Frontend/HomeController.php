<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\News;
use App\Products;
use App\Video;
use App\VideoCat;
use App\Videos;
use App\VipSalon;
use App\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Mews\Captcha\Facades\Captcha;
use Symfony\Component\Console\Input\InputInterface;
use Validator;
class HomeController extends Controller {

    public function __construct()
    {
    }
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */

    public function index()
    {
        $listNNHome = Products::where('status', Products::STATUS_ACTIVE)->where('type_id', 1)->limit(3)->get();
        $listCNHome = Products::where('status', Products::STATUS_ACTIVE)->where('type_id', 2)->limit(3)->get();
        return View('Home.index', [
            'listNNHome' => $listNNHome,
            'listCNHome' => $listCNHome
        ]);
    }

    public function Nongnghiep()
    {
        $listNNHome = Products::where('status', Products::STATUS_ACTIVE)->where('type_id', 1)->get();
        return View('Nongnghiep.index', [
            'listNNHome' => $listNNHome,
        ]);
    }

    public function Channuoi()
    {
        $listCNHome = Products::where('status', Products::STATUS_ACTIVE)->where('type_id', 2)->get();
        return View('Channuoi.index', [
            'listCNHome' => $listCNHome
        ]);
    }

    public function Nongnghiepdetail($id)
    {
        $spDetail = Products::where('id', $id)->first();
        $spDetail->images = json_decode($spDetail->images, true);
        $listVideos = Videos::where('id_product', $spDetail->id)
            ->where('status', Videos::STATUS_ACTIVE)
            ->OrderBy('created_at', 'desc')
            ->get();
        return View('Nongnghiep.detail', [
            'spDetail' => $spDetail,
            'listVideos' => $listVideos
        ]);
    }

    public function Channuoidetail($id)
    {
        $spDetail = Products::where('id', $id)->first();
        $spDetail->images = json_decode($spDetail->images, true);
        $listVideos = Videos::where('id_product', $spDetail->id)
            ->where('status', Videos::STATUS_ACTIVE)
            ->OrderBy('created_at', 'desc')
            ->get();
        return View('Channuoi.detail', [
            'spDetail' => $spDetail,
            'listVideos' => $listVideos
        ]);
    }

    public function Lienhe()
    {
        return View('Lienhe.index', []);
    }
}