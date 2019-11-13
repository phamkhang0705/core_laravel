<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 23/04/2018
 * Time: 8:53 AM
 */

namespace App\Common\Epay;


class Epay
{

    private $url = '';
    private $partner_code = '';

    /**
     * WhyPay constructor.
     */
    public function __construct($data = [])
    {
        $this->url = !empty($data['url']) ? $data['url'] : env('API_EPAY_SERVICE_URL');
        $this->partner_code = !empty($data['partner_code']) ? $data['partner_code'] : env('API_EPAY_PARTNER_CODE');
    }

    public static function getStatus()
    {
        return [
            -1 => 'Không rõ kết quả',
            0 => 'Thành công',
            23 => 'Tài khoản đang được nạp tiền',
            99 => 'Chờ kiềm tra',
            10 => 'Tài khoản đang bị khóa',
            11 => 'Tên parner không đúng',
            12 => 'Địa chỉ IP không cho phép',
            13 => 'Mã đơn hàng bị lỗi',
            14 => 'Mã đơn hàng đã tồn tại',
            17 => 'Sai tổng tiền',
            21 => 'Sai chữ ký',
            22 => 'Dữ liệu rỗng hoặc gửi lên ký tự đặc biệt',
            30 => 'Số dư khả dụng không đủ',
            31 => 'Chiết khấu chưa được cập nhật cho partner',
            32 => 'Parner chưa được cập nhật public key',
            33 => 'Parner chưa được set ip',
            35 => 'Hệ thống đang bận',
            52 => 'Loại hình thanh toán không được hỗ trợ',
            101 => 'Mã giao dịch truyền lên sai định dạng',
            102 => 'Mã giao dịch đã tồn tại',
            103 => 'Tài khoản nạp tiền bị sai',
            104 => 'Sai mã nhà cung cấp hoặc nhà cung cấp không hỗ trợ',
            105 => 'Mệnh giá nạp tiền không hỗ trợ',
            106 => 'Mệnh giá thẻ không tồn tại',
            107 => 'Thẻ trong kho không đủ cho giao dịch',
            108 => 'Số lượng thẻ mua vượt quá giới hạn cho phép',
            109 => 'Kênh nạp tiền đang bảo trì',
            110 => 'Giao dịch thất bại',
            111 => 'Mã giao dịch không tồn tại',
            112 => 'Tài khoản chưa có key mã hóa softpin',
            113 => 'Tài khoản nhận tiền không đúng'
        ];
    }

    public function getBalance()
    {
        $client = new \SoapClient($this->url);

        $data = [
            'partnerName' => $this->partner_code,
            'sign' => $this->sign($this->partner_code)
        ];

        try {
            $result = $client->__soapCall("queryBalance", $data);

            return !empty($result->balance_money) ? $result->balance_money : 0;
        } catch (Exception $ex) {
            return false;
        }
    }

    private function sign($data)
    {
        $private_key = file_get_contents(app_path() . "/Common/Epay/key/private_key.pem");

        //Sign
        openssl_sign($data, $binary_signature, $private_key, OPENSSL_ALGO_SHA1);
        $signature = base64_encode($binary_signature);

        return $signature;

    }

    private function verify_sign($data, $sign)
    {
        $public_key = file_get_contents(app_path() . "/Common/Epay/key/public_key.pem");
        $verify = openssl_verify($data, base64_decode($sign), $public_key, OPENSSL_ALGO_SHA1);
        if ($verify == 1) {
            return true;
        } else {
            return false;
        }
    }

    private function httpGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

}