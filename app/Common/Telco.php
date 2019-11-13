<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04/04/2018
 * Time: 5:45 AM
 */

namespace App\Common;


use App\Common\Adapter\Log;
use App\Models\AdminActivity;
use App\Models\HlGlobal\PhoneCardResult;
use App\Models\HlGlobal\SaleProductOrder;
use App\Models\HlGlobal\UserRequestCashbackGame;
use Carbon\Carbon;

class Telco
{
    const WIFI = 'WIFI';
    const VIETTEL = 'VIETTEL';
    const MOBIFONE = 'MOBIFONE';
    const MOBIFONE_ANVIEN = 'ANVIEN';
    const VINAPHONE = 'VINAPHONE';
    const VIETNAMMOBILE = 'VIETNAMOBILE';

    static $_country_code = "84";

    public static function getList()
    {
        return [
            self::VIETTEL,
            self::MOBIFONE,
            self::MOBIFONE_ANVIEN,
            self::VINAPHONE,
            self::VIETNAMMOBILE
        ];
    }

    public static function formatPhone($phone)
    {
        if (strpos($phone, '00') === 0) {
            $phone = substr($phone, 2);
        } elseif (strpos($phone, '+') === 0) {
            $phone = substr($phone, 1);
        } elseif (strpos($phone, '0') === 0) {
            $phone = self::$_country_code . substr($phone, 1);
        }

        if (strpos($phone, self::$_country_code) !== 0) {
            $phone = self::$_country_code . $phone;
        }

        return trim($phone);
    }
    public static function format($phone, $country_code = null)
    {
        if(!isset($country_code)){
            $country_code = self::$_country_code;
        }
        
        if (!isset($phone) || $phone == ''){
            return '';
        }
        if (strpos($phone, '00') === 0) {
            $phone = substr($phone, 2);
        } elseif (strpos($phone, '+') === 0) {
            $phone = substr($phone, 1);
        } elseif (strpos($phone, '0') === 0) {
            $phone = country_code . substr($phone, 1);
        }

        if (strpos($phone, self::$_country_code) !== 0) {
            $phone = $country_code . $phone;
        }

        return trim($phone);
    }

    public static function removePrefixPhoneNumber($phone, $prefix = true)
    {
        $sufix = $prefix == true ? "0" : "";
        if (strpos($phone, self::$_country_code) === 0) {
            $phone = $sufix . substr($phone, strlen(self::$_country_code));
        } else if (strpos($phone, "0") !== 0) {
            $phone = $sufix . $phone;
        }
        return $phone;
    }

    public static function removePrefixPhoneNumberForSearch($phone)
    {
        $phone_number_prefixs = ['84', '+84', '084', '0'];
        foreach ($phone_number_prefixs as $phone_number_prefix) {
            if (strpos($phone, $phone_number_prefix) === 0) {
                $phone = substr($phone, strlen($phone_number_prefix));
                break;
            }
        }

        return $phone;
    }

    public static function isViettelNumber($phone)
    {
        $phone = self::formatPhone($phone);
        $phone = self::removePrefixPhoneNumber(trim($phone));
        $pattern = "/^(096|097|098|0162|0163|0164|0165|0166|0167|0168|0169|086)([x0-9]{7})$/";
        return preg_match($pattern, $phone);
    }

    public static function isVinaPhoneNumber($phone)
    {
        $phone = self::formatPhone($phone);
        $phone = self::removePrefixPhoneNumber(trim($phone));
        $pattern = "/^(091|094|0123|0125|0127|0129|0124|088)([x0-9]{7})$/";
        return preg_match($pattern, $phone);
    }

    public static function isMobifonePhoneNumber($phone)
    {
        $phone = self::formatPhone($phone);
        $phone = self::removePrefixPhoneNumber(trim($phone));
        $pattern = "/^(090|093|0122|0126|0128|0121|0120|089)([x0-9]{7})$/";
        return preg_match($pattern, $phone);
    }

    public static function isVietnammobileNumber($phone)
    {
        $phone = self::formatPhone($phone);
        $phone = self::removePrefixPhoneNumber(trim($phone));
        $pattern = "/^(092|0188|0186)([x0-9]{7})$/";
        return preg_match($pattern, $phone);
    }

    public static function isPhoneNumber($phoneNumber)
    {
        $phoneNumber = self::formatPhone($phoneNumber);
        $phoneNumber = self::removePrefixPhoneNumber($phoneNumber);
        $pattern = "/^(09|01)([0-9]{8,9})$/";
        /* $pattern = "/^(091|094|0123|0125|0127|0129|0124|0164)([0-9]{6,7})$/"; */
        return preg_match($pattern, $phoneNumber);
    }

    /* Input 84xxx */
    public static function getTelcoByPhone($phone)
    {
        $telco = self::WIFI;
        if (self::isMobifonePhoneNumber($phone)) {
            $telco = self::MOBIFONE;
        } elseif (self::isVinaPhoneNumber($phone)) {
            $telco = self::VINAPHONE;
        } elseif (self::isViettelNumber($phone)) {
            $telco = self::VIETTEL;
        } elseif (self::isVietnammobileNumber($phone)) {
            $telco = self::VIETNAMMOBILE;
        }
        return $telco;
    }

    public static function checkVietNamMobile()
    {
        if (isset($_GET['fck'])) {
            $msisdn = isset($_SERVER['HTTP_X_WAP_MSISDN']) ? $_SERVER['HTTP_X_WAP_MSISDN'] : '';
            var_dump($msisdn);
            $msisdn = isset($_SERVER['X_WAP_MSISDN']) ? $_SERVER['X_WAP_MSISDN'] : $msisdn;
            var_dump($msisdn);
            $msisdn = isset($_SERVER['MSISDN']) ? $_SERVER['MSISDN'] : $msisdn;
            var_dump($msisdn);
            $msisdn = isset($_SERVER['HTTP_MSISDN']) ? $_SERVER['HTTP_MSISDN'] : $msisdn;
            var_dump($msisdn);
            die;
        }

        $msisdn = isset($_SERVER['HTTP_X_WAP_MSISDN']) ? $_SERVER['HTTP_X_WAP_MSISDN'] : '';
        $msisdn = isset($_SERVER['X_WAP_MSISDN']) ? $_SERVER['X_WAP_MSISDN'] : $msisdn;
        $msisdn = isset($_SERVER['MSISDN']) ? $_SERVER['MSISDN'] : $msisdn;
        $msisdn = isset($_SERVER['HTTP_MSISDN']) ? $_SERVER['HTTP_MSISDN'] : $msisdn;

        return $msisdn;
    }

    public static function retryTopup($data, $note = '')
    {
        if (!$data instanceof SaleProductOrder) {
            return false;
        }

        $response = \App\Models\Helper\Order::reorder($data->order_id);

        if ($response['error'] == 1) {
            return false;
        }

        $response = !empty($response['data']) ? $response['data'] : '';

        if (empty($response)) {
            return false;
        }

        $response = json_decode($response);

        $user_request_cashback = !empty($response->updated->data->userRequestCashbackGame) ? $response->updated->data->userRequestCashbackGame : null;

        if (empty($user_request_cashback)) {
            return false;
        }

        $request_id = !empty($user_request_cashback->requestId) ? $user_request_cashback->requestId : null;

        if (empty($request_id)) {
            return false;
        }

        /*$log_cashback = UserRequestCashbackGame::query()->where('request_id', $request_id)->first();
        if(!$log_cashback instanceof UserRequestCashbackGame){
            return false;
        }

        $log_cashback->note = $note;

        $log_cashback->save();

        $phone_card_result = new PhoneCardResult();
        $phone_card_result->order_detail_id = $data->info->order_detail_id;
        $phone_card_result->request_id = $request_id;
        $phone_card_result->save();*/

        return true;
    }
}