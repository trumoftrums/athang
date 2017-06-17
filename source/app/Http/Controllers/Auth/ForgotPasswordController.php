<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\SMS;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Request;
use Validator;
use Mews\Captcha\Facades\Captcha;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $result = array(
            'result' => false,
            'mess' => ''
        );
        $formData = Request::all();
        $rules = ['code' => 'required|captcha'];
        $validator = Validator::make($formData, $rules);
//        var_dump($validator->fails());exit();
        if (!$validator->fails()) {
            if(strlen($formData['phone'])>=10 && strlen($formData['phone'])<=11 ){
                $ck = Users::getUserbyPhone($formData['phone']);

                if (!empty($ck)) {
                    $result = $this->forgotPass($formData['phone']);
                } else {
                    $result['mess'] = "Phone number was not match!";
                }
            }else{
                $result['mess'] = "Phone number was not match!";
            }

        }else{
            $err = $validator->errors()->all();
//            var_dump($err);exit();
            $result['mess'] = "Vui lòng nhập đầy đủ số điện thoại và mã xác nhận!";
        }
        return response($result)
            ->withHeaders([
                'Content-Type' => 'application/json'
            ]);
    }

    private function forgotPass($YourPhone)
    {
        $result = array(
            'result' => false,
            'mess' => ''
        );

        if (!empty($YourPhone)) {
            $APIKey = "0FE1E740765DF16DDA1E12ED32DF30";
            $SecretKey = "A5401639F98069E770E21491407FE8";
//        $YourPhone="0934078616";
            $newPass = substr(md5($YourPhone.time()),0,10);
            $Content='VietnamOTO.net '.PHP_EOL.'Mat khau moi cua ban la: '.$newPass;

            $SendContent = urlencode($Content);
            $data = "http://rest.esms.vn/MainService.svc/json/SendMultipleMessage_V4_get?Phone=$YourPhone&ApiKey=$APIKey&SecretKey=$SecretKey&Content=$SendContent&SmsType=3";

            $curl = curl_init($data);
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            DB::beginTransaction();
            $sms = new SMS;
            $sms->receivers = json_encode(array($YourPhone));
            $sms->content = $Content;
            $sms->type = 'PASSWORD';
            $sms->status = 'DONE';
            $sms->rslcode = '100';
            $r1 = $sms->save();
            if($r1){
                $ifresult = curl_exec($curl);
                $obj = json_decode($ifresult, true);
                $r2 =true;
                if ($obj['CodeResult'] == 100) {
                    $r2 = Users::setPassword($YourPhone,bcrypt($newPass));


                } else {
                    $update = array(
                        'status' =>'FAILED',
                        'rslcode' => $obj['CodeResult'],
                        'mess' =>$obj['ErrorMessage']
                    );

                    $r2 = SMS::where("id",$sms->id)->update($update);

                }
                if($r2){
                    DB::commit();
                    $result['result'] = true;
                }else{
                    DB::rollback();
                    $result['mess'] = "Hệ thống đang quá tải, vui lòng thử lại sau!";
                }
            }else{
                $result['mess'] = "Hệ thống đang quá tải, vui lòng thử lại sau!";
            }

        }else{
            $result['mess'] = "Không tìm thấy số điện thoại!";
        }
        return $result;

    }
}
