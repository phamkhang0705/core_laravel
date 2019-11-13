<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23/04/2018
 * Time: 14:22 PM
 */

namespace App\Common;


use App\Common\Adapter\Log;

class Service
{
    public static function checkTransaction($request_id)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_V2_URL') . "/v2/mobile/check-request-result?requestId=" . $request_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 600,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "X-DEVICE: Web_CMS",
                "X-SECRET-PUSH: fqA0hdOtjt1y0wxuErkImDTIhOm^w?P0X`PS?hg@Dr<IT^8t0UsSH;2>UJx1NbRp",
                "X-VERSION: 2.0.0",
                "Content-Type: application/json",
                "X-CATE-RESOURCE-VERSION: 17",
                "X-DATA-VERSION: 1",
               
                "X-LANGUAGE: vi",
                "X-LOCATION: 21.05,105.80",
                "X-SCREEN-SIZE: 480x816",
                "X-SECRET-PUSH: fqA0hdOtjt1y0wxuErkImDTIhOm^w?P0X`PS?hg@Dr<IT^8t0UsSH;2>UJx1NbRp",
                "X-SESSION: 54539c61-df3f-4ea8-8162-a4716fc09b24",
                "X-TIMESTAMP: 1461293186",
                "X-UNIQUE-DEVICE: 68a57a7748de72d51ecf33fyu3456",
   
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        /*$response = '
            {
                "updated": {
                    "data": {
                        "userRequestCashbackGame": {
                            "requestId": 7940,
                            "userId": 2012971,
                            "phone": "01659116869",
                            "moneyAmount": 10000,
                            "payType": 1,
                            "serviceName": "ZO_POST",
                            "insertTime": 1526281667,
                            "updateTime": 1526281667,
                            "status": 8,
                            "processStatus": 0,
                            "quantity": 1,
                            "clingmeStatus": 0,
                            "message": "Tài khoản đối tác bị hoặc không tồn tại",
                            "rawResponse": "{\"ResponseCode\":\"08\",\"ResponseMessage\":\"Tài khoản đối tác bị hoặc không tồn tại\",\"TransRef\":\"TEST_Clingme_7940\"}",
                            "trackingStatus": "FAIL"
                        },
                        "topupResult": {
                            "ResponseCode": "08",
                            "ResponseMessage": "Tài khoản đối tác bị hoặc không tồn tại",
                            "TransRef": "TEST_Clingme_7940"
                        },
                        "sucess": false
                    },
                    "global": {
                        "serverTime": 1526632421,
                        "masterDataVersion": 1,
                        "mapResourceVersion": 2,
                        "cateResourceVersion": 26,
                        "dealCateResourceVersion": 20,
                        "keywordResourceVersion": 2,
                        "streetResourceVersion": 1,
                        "symbolFontVersion": 4,
                        "androidAppId": "com.gigatum",
                        "walletUpdated": false,
                        "search_place_mode": 0,
                        "languageResourceVersion": 1,
                        "updateUrl": null
                    }
                }
            }        
        ';*/

        /*
         * clingmeStatus: 0 thất bại, 1 thành công, -1 là chưa rõ kết quả
         * trackingStatus:
         * - INIT: khởi tạo,
         * - PROCESSING: đang xử lý,
         * - SUCCESS: thành công,
         * - FAIL: thất bại,
         * - UNKNOWN: chưa rõ kết quả,
         * - SYSTEM_ERROR: hệ thống lỗi
         * */

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            $data = json_decode($response);

            return !empty($data->updated->data) ? $data->updated->data : false;
        }
    }

    public static function getBalance()
    {
	    //$log = new Log('error',['file_name'=>'get_balance']);

        $curl = curl_init();
	    $header = array(
            "X-DEVICE: Web_CMS",
            "X-SECRET-PUSH: fqA0hdOtjt1y0wxuErkImDTIhOm^w?P0X`PS?hg@Dr<IT^8t0UsSH;2>UJx1NbRp",
            "X-VERSION: 2.0.0",
            
            "Content-Type: application/json",
		    "X-CATE-RESOURCE-VERSION: 17",
		    "X-DATA-VERSION: 1",		   
		    "X-LANGUAGE: vi",
		    "X-LOCATION: 21.05,105.80",
		    "X-SCREEN-SIZE: 480x816",
		    "X-SECRET-PUSH: fqA0hdOtjt1y0wxuErkImDTIhOm^w?P0X`PS?hg@Dr<IT^8t0UsSH;2>UJx1NbRp",
		    "X-SESSION: 54539c61-df3f-4ea8-8162-a4716fc09b24",
		    "X-TIMESTAMP: 1461293186",
		    "X-UNIQUE-DEVICE: 68a57a7748de72d51ecf33fyu3456",
	    );
	    //$log->addInfo('---start call ---- ',['url'=>env('API_V2_URL') . "/v2/mobile/service-balance",'header'=>$header]);


        curl_setopt_array($curl, array(
            CURLOPT_URL => env('API_V2_URL') . "/v2/mobile/service-balance",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => $header,
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return null;
        } else {
            $log = new Log('get_balance');
            $log->addInfo('---------------------------------------');
            $log->addInfo('Data: ', ['data' => $response]);
            $log->addInfo('---------------------------------------');

            $data = json_decode($response);

            return [
                'epay' => !empty($data->updated->data->epayInfo->balance_money) ? $data->updated->data->epayInfo->balance_money : 0,
                'zopost' => !empty($data->updated->data->zopostInfo->ExtraInfo) ? $data->updated->data->zopostInfo->ExtraInfo : 0,
                'whypay' => !empty($data->updated->data->whypayInfo) ? $data->updated->data->whypayInfo : 0
            ];
        }
    }
}