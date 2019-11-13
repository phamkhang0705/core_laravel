<?php
namespace App\Common; 

use App\Common\AjaxResponse;


class CoreApi
{
    // goi api anh thắng
    public static function postApi($api_url, $params)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array( 
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
       // CURLOPT_HEADER=>true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_HTTPHEADER => array(
            "accept-encoding: gzip",
            "content-type: application/json",            
            "x-device: Web_CMS",
            "x-version: Web-2.0.0"
        ),
        ));
        try{ 

            $response = curl_exec($curl);

            $err = curl_error($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
			
            $log = new \App\Common\Adapter\Log('core'); 
            $log->addInfo($api_url);
            $log->addInfo('',['params'=>$params]);
            $log->addInfo('',['httpcode'=>$httpcode]);
            $log->addInfo('',['err'=>$err]); 
            $log->addInfo('',['response'=>$response]);
            $log->addInfo('---------------------------------------'); 

            curl_close($curl);

            if ($err) {                 
                return [
                    'error' => 1,
                    'message' => $err,
                    'httpcode'=>$httpcode,
                ];
            } 

            return [
                'error' => 0,           
                'message' => "call api oke",
                'httpcode' => $httpcode,
                'data' => $response
            ];
                
        } catch (\Exception $e) {

            return [
                'error' => 1,           
                'message' => "Timeout",
                'data' => ''
            ];
        }
    }

    // cash out
    public static function cashoutApprove($id, $confirmed_by)
    {       
        $api_url = env('API_V2_URL') . '/v2/user/approve-cashout';
      
        $params = json_encode([
            'cashout_id' => $id, 
            'confirmed_by'=> $confirmed_by,
            'note'=>''
        ]);

        return CoreApi::postApi($api_url, $params);
         
    }

    // respon ajax client
    // api a thắng return
    public static function ajaxRespon($data, $responSuccess)
    {             
         
        if($data['error'] == 1){    
            if($data['httpcode'] != 200)
                return AjaxResponse::responseError('Có lỗi: '.$data['httpcode']);             
            else
                return AjaxResponse::responseError('Có lỗi: '.$data['code'].' - '. $data['message']); 
        }
        else if($data['error'] == 0){            
            $res = json_decode($data['data'], true);
            if(isset($res['code']))
                return AjaxResponse::responseError('Có lỗi: '.$res['code'].' - '.$res['msg']);  
            else
                return AjaxResponse::responseSuccess($responSuccess);                     
        }
        return AjaxResponse::responseError('Có lỗi: gọi clingme core lỗi'); 
    }


}