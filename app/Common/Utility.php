<?php
/**
 * Created by PhpStorm.
 * User: TRUNGNT
 */

namespace App\Common;

/**
 * Class Utility
 * @package App\Common
 */
class Utility
{
    const LIMIT = 25;
    const DAYS = -30;

    /**
     * @todo phân chia phần số nguyên
     * @param $value
     * @param int $min_money
     * @param null $symbol
     * @return float|int|mixed|string
     */
    public static function numberFormat($value, $min_money = 1000, $symbol = null)
    {
        $value = intval($value);
        $value = $value < $min_money ?
            $value : ($value / $min_money) * $min_money;
        if (intval($value) >= $min_money) {
            if ($value != '' and is_numeric($value)) {
                $value = number_format($value, 2, ',', '.');
                $value = str_replace(',00', '', $value);
            }
        }
        if ($symbol) {
            $value .= '' . $symbol;
        }

        return $value;
    }

    /**
     * @todo Hiển thị thời gian hiện tại
     * @param $time
     * @param string $format
     * @return bool|string
     */
    public static function displayDatetime($time, $format = 'H:i d/m/Y')
    {
        if ($time == '00:00:00 0000:00:00'
            || $time == '0000:00:00 00:00:00'
            || $time == '0000-00-00 00:00:00'
            || $time == ''
            || $time == null
            || $time == 'null'
        ) {
            return '';
        }
        if (is_numeric($time)) {
            return date($format, intval($time));
        }
        return date($format, strtotime($time));
    }

    /**
     * @param $s
     * @return string
     */
    public static function secondToTime($s)
    {
        if ($s == 0) {
            return "00:00:00";
        }

        $hour = floor($s / 3600);
        $minute = floor(($s - $hour * 3600) / 60);
        $second = $s - $hour * 3600 - $minute * 60;

        if ($hour == 0) {
            $hour = '';
        } else if ($hour < 10) {
            $hour = '0' . $hour . ':';
        } else {
            $hour = $hour . ':';
        }

        if ($minute == 0) {
            $minute = '00:';
        } else if ($minute < 10) {
            $minute = '0' . $minute . ':';
        } else {
            $minute = $minute . ':';
        }

        if ($second == 0) {
            $second = '00';
        } else if ($second < 10) {
            $second = '0' . $second;
        }

        return $hour . $minute . $second;
    }

    /**
     * @param $time
     * @return string
     */
    public static function makeFriendlyTime($time)
    {
        $now = date("Y-m-d H:i:s");

        $secondsToNow = round(strtotime($now) - strtotime($time));

        if ($secondsToNow < 60) {
            return "$secondsToNow giây trước";
        } else if ($secondsToNow >= 60 && $secondsToNow < 3600) {
            $minutes = round($secondsToNow / 60);
            return "$minutes phút trước";
        } else if ($secondsToNow > 3600 && $secondsToNow < 86400) {
            $hours = round($secondsToNow / 3600);
            return "$hours giờ trước";
        } else if ($secondsToNow >= 86400 && $secondsToNow < 2592000) {
            $days = round($secondsToNow / 86400);
            return "$days ngày trước";
        } else if ($secondsToNow >= 2592000 && $secondsToNow < 31104000) {
            $months = round($secondsToNow / 2592000);
            return "$months tháng trước";
        } else {
            $years = round($secondsToNow / 31104000);
            return "$years năm trước";
        }
    }

    public static function getDateNameFromTime($time, $format = 'Y-m-d H:i:s')
    {
        $data = \DateTime::createFromFormat($format, $time);

        $names = [
            'Mon' => 'Thứ 2&nbsp;',
            'Tue' => 'Thứ 3&nbsp;',
            'Wed' => 'Thứ 4&nbsp;',
            'Thu' => 'Thứ 5&nbsp;',
            'Fri' => 'Thứ 6&nbsp;',
            'Sat' => 'Thứ 7&nbsp;',
            'Sun' => 'Chủ nhật&nbsp;',
        ];
        $en_name = $data->format('D');

        return $names[$en_name];
    }

    public static function getClientIp()
    {
        if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }

//        else if (getenv('REMOTE_ADDR'))
        //            $ipaddress = getenv('REMOTE_ADDR');
        else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    public static function httpGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    public static function httpPost($url, $params, $header = [])
    {
        $postData = '';

        if (is_array($params)) {
            foreach ($params as $k => $v) {
                $postData .= $k . '=' . $v . '&';
            }
            $postData = rtrim($postData, '&');
        } else {
            $postData = $params;
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }

    /**
     * @todo hàm bỏ dấu
     * @param $string
     * @return mixed
     */

    public static function stripText($string)
    {
        $from = array("à", "ả", "ã", "á", "ạ", "ă", "ằ", "ẳ", "ẵ", "ắ", "ặ", "â", "ầ", "ẩ", "ẫ", "ấ", "ậ", "đ", "è", "ẻ", "ẽ", "é", "ẹ", "ê", "ề", "ể", "ễ", "ế", "ệ", "ì", "ỉ", "ĩ", "í", "ị", "ẻ", "ò", "ỏ", "õ", "ó", "ọ", "ô", "ồ", "ổ", "ỗ", "ố", "ộ", "ơ", "ờ", "ở", "ỡ", "ớ", "ợ", "ò", "ù", "ủ", "ũ", "ú", "ụ", "ư", "ừ", "ử", "ữ", "ứ", "ự", "ỳ", "ỷ", "ỹ", "ý", "ỵ", "À", "Ả", "Ã", "Á", "Ạ", "Ă", "Ằ", "Ẳ", "Ẵ", "Ắ", "Ặ", "Â", "Ầ", "Ẩ", "Ẫ", "Ấ", "Ậ", "Đ", "È", "Ẻ", "Ẽ", "É", "Ẹ", "Ê", "Ề", "Ể", "Ễ", "Ế", "Ệ", "Ì", "Ỉ", "Ĩ", "Í", "Ị", "Ò", "Ỏ", "Õ", "Ó", "Ọ", "Ô", "Ồ", "Ổ", "Ỗ", "Ố", "Ộ", "Ơ", "Ờ", "Ở", "Ỡ", "Ớ", "Ợ", "Ù", "Ủ", "Ũ", "Ú", "Ụ", "Ư", "Ừ", "Ử", "Ữ", "Ứ", "Ự", "Ỳ", "Ỷ", "Ỹ", "Ý", "Ỵ", "ũ", "á", "è", "ý", "ã", "ọ", "ạ", "ụ", "ọ");
        $to = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "d", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "e", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "D", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "u", "a", "e", "y", "a", "o", "a", "u" . "o");
        return str_replace($from, $to, $string);
    }

    /**
     * @todo xóa ký tự đặc biệt
     * @param $string
     * @return string
     */
    public static function cleanUpSpecialChars($string)
    {
        $string = preg_replace(array("`\W`i", "`[-]+`"), "-", $string);
        return trim($string, '-');
    }

    /**
     * @todo tạo slug
     * @param $string
     * @return string
     */
    public static function makeSlug($string)
    {
        return strtolower(self::cleanUpSpecialChars(self::stripText($string)));
    }

    public static function convertUrl($url)
    {
        if (!isset($url)) {
            return '';
        }

        // remove ' '
        $url = trim($url, ' ');
        if ($url == '') {
            return '';
        }

        $url = trim($url, '/');

        return '/' . $url;
    }

    public static function getImageDefaultUrl()
    {
        return env('APP_URL') . '/img/image.png';
    }

    public static function getHours()
    {
        return ['00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24'];
    }

    public static function getMinutes()
    {
        return [0 => '00', 5 => '05', 10 => '10', 15 => '15', 20 => '20', 25 => '25', 30 => '30', 35 => '35', 40 => '40', 45 => '45', 50 => '50', 55 => '55'];
    }

    public static function getStoragePath($objId, $isDir = false)
    {
        $step = 15; // So bit de ma hoa ten thu muc tren 1 cap
        $layer = 3; // So cap thu muc
        $max_bits = PHP_INT_SIZE * 8;
        $result = "";

        for ($i = $layer; $i > 0; $i--) {
            $shift = $step * $i;
            $layer_name = $shift <= $max_bits ? $objId >> $shift : 0;

            $result .= $isDir ? DIRECTORY_SEPARATOR . $layer_name : "/" . $layer_name;
        }

        return $result;
    }

    public static function makeDirectory($dir, $mode = 0777, $recursive = true)
    {
        if (!file_exists($dir)) {
            $old_umask = umask(0);
            mkdir($dir, $mode, $recursive);
            umask($old_umask);
        }
    }

    public static function replaceWithStar($string)
    {
        $prefix = substr($string, 0, 3);
        $suffix = substr($string, -3, 3);

        return "{$prefix}* *** *** **{$suffix}";
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 || (substr($haystack, -$length) === $needle);
    }

    public static function getDatesFromRange($start, $end, $format = 'Y-m-d')
    {
        $array = array();
        $interval = new \DateInterval('P1D');

        $realEnd = new \DateTime($end);
        $realEnd->add($interval);

        $period = new \DatePeriod(new \DateTime($start), $interval, $realEnd);

        foreach ($period as $date) {
            $array[] = $date->format($format);
        }

        return $array;
    }

    public static function pageTopPagination($datas)
    {
        $str = '';
        if ($datas == [] || $datas->total() == 0) {
            $str = '<div class="col-md-6">' .
                '   <p>Hiển thị từ 1 đến ' . Utility::LIMIT . ' trong tổng số 0 kết quả</p>' .
                '</div>' .
                '<div class="col-md-6 text-right">' .
                '    ' .
                '</div>';
            return $str;
        }
        $f = ($datas->currentPage() - 1) * $datas->perPage() + 1;
        $t = ($datas->currentPage()) * $datas->perPage();
        if ($t > $datas->total()) {
            $t = $datas->total();
        }

        $str = '<div class="col-md-12">' .
            '   <p>Hiển thị từ ' . Utility::numberFormat($f, 1000, "") . ' đến ' . Utility::numberFormat($t, 1000, "") . ' trong tổng số ' . Utility::numberFormat($datas->total(), 1000, "") . ' kết quả</p>' .
            '</div>';
        return $str;
    }

    public static function pagePagination($datas)
    {
        $str = '';
        if ($datas == [] || $datas->total() == 0) {
            $str = '<div class="col-md-6">' .
                '   <p>Hiển thị từ 1 đến ' . Utility::LIMIT . ' trong tổng số 0 kết quả</p>' .
                '</div>' .
                '<div class="col-md-6 text-right">' .
                '    ' .
                '</div>';
            return $str;
        }
        $f = ($datas->currentPage() - 1) * $datas->perPage() + 1;
        $t = ($datas->currentPage()) * $datas->perPage();
        if ($t > $datas->total()) {
            $t = $datas->total();
        }

        $str = '<div class="col-md-6">' .
            '   <p>Hiển thị từ ' . Utility::numberFormat($f, 1000, "") . ' đến ' . Utility::numberFormat($t, 1000, "") . ' trong tổng số ' . Utility::numberFormat($datas->total(), 1000, "") . ' kết quả</p>' .
            '</div>' .
            '<div class="col-md-6 text-right">' .
            '    ' . $datas->appends(request()->all())->render() .
            '</div>';
        return $str;
    }

    public static function pageRowIndex($datas, $i)
    {
        return ($datas->currentPage() - 1) * $datas->perPage() + $i;
    }

    public static function satusHtml()
    {
        return [
            '0' => 'font-bold col-red',
            '1' => 'font-bold col-teal',
        ];
    }

    public static function satusHtmlClass($status)
    {
        $s = Utility::satusHtml();
        return isset($s[$status]) ? $s[$status] : '';
    }

    public static function statusHtml($status)
    {
        $str = '';
        if ($status == 1) {
            $str = '<span class="' . Utility::satusHtmlClass(1) . '">' . 'Hoạt động' . '</span>';
        } else {
            $str = '<span class="' . Utility::satusHtmlClass(0) . '">' . 'Không hoạt động' . '</span>';
        }

        return $str;
    }

    public static function getDateRangeFromString($date)
    {
        $from_time = $to_time = '';

        if (empty($date)) {
            return [
                'from_time' => $from_time,
                'to_time' => $to_time,
            ];
        }

        @list($from_time, $to_time) = explode('-', $date);

        if (!empty($from_time)) {
            $from_time = trim($from_time);

            $date_time = \DateTime::createFromFormat('d/m/Y', $from_time);
            if (!isset($date_time) || !$date_time instanceof \DateTime) {
                return false;
            }
            $from_time = $date_time->format('Y-m-d');
        }
        if (!empty($to_time)) {
            $to_time = trim($to_time);

            $date_time = \DateTime::createFromFormat('d/m/Y', $to_time);
            if (!isset($date_time) || !$date_time instanceof \DateTime) {
                return false;
            }
            $to_time = $date_time->format('Y-m-d');
        }

        return [
            'from_time' => $from_time,
            'to_time' => $to_time,
        ];
    }

    public static function getDateFromString($date)
    {
        if (empty($date)) {
            return '';
        }

        @list($day, $month, $year) = explode('/', $date);

        return "{$year}-{$month}-{$day}";
    }

    public static function convertDateStringToInt($date, $format = 'Y-m-d H:i:s')
    {
        $date_time = \DateTime::createFromFormat($format, $date);

        if ($date_time == false) {
            return '';
        }

        return $date_time->getTimestamp();
    }

    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public static function isUrl($uri)
    {
        if (preg_match('/^(http|https):\\/\\/[a-z0-9_]+([\\-\\.]{1}[a-z_0-9]+)*\\.[_a-z]{2,5}' . '((:[0-9]{1,5})?\\/.*)?$/i', $uri)) {
            return $uri;
        }

        return false;
    }

    public static function deleteFiles($target)
    {
        if (is_dir($target)) {
            $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

            foreach ($files as $file) {
                self::deleteFiles($file);
            }

            rmdir($target);
        } elseif (is_file($target)) {
            unlink($target);
        }
    }

    public static function convertRequestDate($date, $format = 'd/m/Y H:i:s')
    {
        if (empty($date)) {
            $date = date($format);
        }

        if (!strpos(':')) {
            $date = $date . ' 00:00:00';
        }

        return \DateTime::createFromFormat($format, $date);
    }

    public static function reportDate()
    {

        $request = request();
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        if (empty($from_date)) {
            $from_date = date("d/m/Y", strtotime('now ' . self::DAYS . ' days'));
        }
        if (empty($to_date)) {
            $to_date = date('d/m/Y');
        }

        $from = \DateTime::createFromFormat('d/m/Y H:i:s', $from_date . ' 00:00:00');
        $to = \DateTime::createFromFormat('d/m/Y H:i:s', $to_date . ' 23:59:59');
        $request->merge(['from_date' => $from_date]);
        $request->merge(['to_date' => $to_date]);

        return [
            'from_date' => $from,
            'to_date' => $to,
        ];

    }

    public static function reportDateMonth()
    {

        $request = request();
        $from_date = $request->get('from_date', '');
        $to_date = $request->get('to_date', '');
        if (empty($from_date)) {
            $from_date = date("d/m/Y", strtotime('now -' . (date('d') - 1) . ' days'));
        }
        if (empty($to_date)) {
            $to_date = date('d/m/Y');
        }

        $from = \DateTime::createFromFormat('d/m/Y H:i:s', $from_date . ' 00:00:00');
        $to = \DateTime::createFromFormat('d/m/Y H:i:s', $to_date . ' 23:59:59');
        $request->merge(['from_date' => $from_date]);
        $request->merge(['to_date' => $to_date]);

        return [
            'from_date' => $from,
            'to_date' => $to,
        ];

    }

    // khoảng cách giữa 2 location (chim bay)
    public static function geoDistance($lat1, $lon1, $lat2, $lon2, $R = 6371000)
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = atan2(sqrt($a), sqrt(1 - $a)) * 2;
        return $R * $c;
    }


    public static function dayInWeekLists()
    {
        return [
            'monday' => 'Thứ 2',
            'tuesday' => 'Thứ 3',
            'wednesday' => 'Thứ 4',
            'thursday' => 'Thứ 5',
            'friday' => 'Thứ 6',
            'saturday' => 'Thứ 7',
            'sunday' => 'Chủ nhật',
        ];
    }


    public static function compound2Unicode1($str)
    {
        $decimalValues = array();
        for ($i = 0; $i < strlen($str); $i++) {
            $decimalValues[] = ord($str[$i]);
        }
        var_dump($decimalValues[1]);

        $str = str_replace("\u0065\u0309", "\u1EBB", $str); //ẻ
        $str = str_replace("\u0065\u0301", "\u00E9", $str); //é
        $str = str_replace("\u0065\u0300", "\u00E8", $str); //è
        $str = str_replace("\u0065\u0323", "\u1EB9", $str); //ẹ
        $str = str_replace("\u0065\u0303", "\u1EBD", $str); //ẽ
        $str = str_replace("\u00EA\u0309", "\u1EC3", $str); //ể
        $str = str_replace("\u00EA\u0301", "\u1EBF", $str); //ế
        $str = str_replace("\u00EA\u0300", "\u1EC1", $str); //ề
        $str = str_replace("\u00EA\u0323", "\u1EC7", $str); //ệ
        $str = str_replace("\u00EA\u0303", "\u1EC5", $str); //ễ
        $str = str_replace("\u0079\u0309", "\u1EF7", $str); //ỷ
        $str = str_replace("\u0079\u0301", "\u00FD", $str); //ý
        $str = str_replace("\u0079\u0300", "\u1EF3", $str); //ỳ
        $str = str_replace("\u0079\u0323", "\u1EF5", $str); //ỵ
        $str = str_replace("\u0079\u0303", "\u1EF9", $str); //ỹ
        $str = str_replace("\u0075\u0309", "\u1EE7", $str); //ủ
        $str = str_replace("\u0075\u0301", "\u00FA", $str); //ú
        $str = str_replace("\u0075\u0300", "\u00F9", $str); //ù
        $str = str_replace("\u0075\u0323", "\u1EE5", $str); //ụ
        $str = str_replace("\u0075\u0303", "\u0169", $str); //ũ
        $str = str_replace("\u01B0\u0309", "\u1EED", $str); //ử
        $str = str_replace("\u01B0\u0301", "\u1EE9", $str); //ứ
        $str = str_replace("\u01B0\u0300", "\u1EEB", $str); //ừ
        $str = str_replace("\u01B0\u0323", "\u1EF1", $str); //ự
        $str = str_replace("\u01B0\u0303", "\u1EEF", $str); //ữ
        $str = str_replace("\u0069\u0309", "\u1EC9", $str); //ỉ
        $str = str_replace("\u0069\u0301", "\u00ED", $str); //í
        $str = str_replace("\u0069\u0300", "\u00EC", $str); //ì
        $str = str_replace("\u0069\u0323", "\u1ECB", $str); //ị
        $str = str_replace("\u0069\u0303", "\u0129", $str); //ĩ
        $str = str_replace("\u006F\u0309", "\u1ECF", $str); //ỏ
        $str = str_replace("\u006F\u0301", "\u00F3", $str); //ó
        $str = str_replace("\u006F\u0300", "\u00F2", $str); //ò
        $str = str_replace("\u006F\u0323", "\u1ECD", $str); //ọ
        $str = str_replace("\u006F\u0303", "\u00F5", $str); //õ
        $str = str_replace("\u01A1\u0309", "\u1EDF", $str); //ở
        $str = str_replace("\u01A1\u0301", "\u1EDB", $str); //ớ
        $str = str_replace("\u01A1\u0300", "\u1EDD", $str); //ờ
        $str = str_replace("\u01A1\u0323", "\u1EE3", $str); //ợ
        $str = str_replace("\u01A1\u0303", "\u1EE1", $str); //ỡ
        $str = str_replace("\u00F4\u0309", "\u1ED5", $str); //ổ
        $str = str_replace("\u00F4\u0301", "\u1ED1", $str); //ố
        $str = str_replace("\u00F4\u0300", "\u1ED3", $str); //ồ
        $str = str_replace("\u00F4\u0323", "\u1ED9", $str); //ộ
        $str = str_replace("\u00F4\u0303", "\u1ED7", $str); //ỗ
        $str = str_replace("\u0061\u0309", "\u1EA3", $str); //ả
        $str = str_replace("\u0061\u0301", "\u00E1", $str); //á
        $str = str_replace("\u0061\u0300", "\u00E0", $str); //à
        $str = str_replace("\u0061\u0323", "\u1EA1", $str); //ạ
        $str = str_replace("\u0061\u0303", "\u00E3", $str); //ã
        $str = str_replace("\u0103\u0309", "\u1EB3", $str); //ẳ
        $str = str_replace("\u0103\u0301", "\u1EAF", $str); //ắ
        $str = str_replace("\u0103\u0300", "\u1EB1", $str); //ằ
        $str = str_replace("\u0103\u0323", "\u1EB7", $str); //ặ
        $str = str_replace("\u0103\u0303", "\u1EB5", $str); //ẵ
        $str = str_replace("\u00E2\u0309", "\u1EA9", $str); //ẩ
        $str = str_replace("\u00E2\u0301", "\u1EA5", $str); //ấ
        $str = str_replace("\u00E2\u0300", "\u1EA7", $str); //ầ
        $str = str_replace("\u00E2\u0323", "\u1EAD", $str); //ậ
        $str = str_replace("\u00E2\u0303", "\u1EAB", $str); //ẫ
        $str = str_replace("\u0045\u0309", "\u1EBA", $str); //Ẻ
        $str = str_replace("\u0045\u0301", "\u00C9", $str); //É
        $str = str_replace("\u0045\u0300", "\u00C8", $str); //È
        $str = str_replace("\u0045\u0323", "\u1EB8", $str); //Ẹ
        $str = str_replace("\u0045\u0303", "\u1EBC", $str); //Ẽ
        $str = str_replace("\u00CA\u0309", "\u1EC2", $str); //Ể
        $str = str_replace("\u00CA\u0301", "\u1EBE", $str); //Ế
        $str = str_replace("\u00CA\u0300", "\u1EC0", $str); //Ề
        $str = str_replace("\u00CA\u0323", "\u1EC6", $str); //Ệ
        $str = str_replace("\u00CA\u0303", "\u1EC4", $str); //Ễ
        $str = str_replace("\u0059\u0309", "\u1EF6", $str); //Ỷ
        $str = str_replace("\u0059\u0301", "\u00DD", $str); //Ý
        $str = str_replace("\u0059\u0300", "\u1EF2", $str); //Ỳ
        $str = str_replace("\u0059\u0323", "\u1EF4", $str); //Ỵ
        $str = str_replace("\u0059\u0303", "\u1EF8", $str); //Ỹ
        $str = str_replace("\u0055\u0309", "\u1EE6", $str); //Ủ
        $str = str_replace("\u0055\u0301", "\u00DA", $str); //Ú
        $str = str_replace("\u0055\u0300", "\u00D9", $str); //Ù
        $str = str_replace("\u0055\u0323", "\u1EE4", $str); //Ụ
        $str = str_replace("\u0055\u0303", "\u0168", $str); //Ũ
        $str = str_replace("\u01AF\u0309", "\u1EEC", $str); //Ử
        $str = str_replace("\u01AF\u0301", "\u1EE8", $str); //Ứ
        $str = str_replace("\u01AF\u0300", "\u1EEA", $str); //Ừ
        $str = str_replace("\u01AF\u0323", "\u1EF0", $str); //Ự
        $str = str_replace("\u01AF\u0303", "\u1EEE", $str); //Ữ
        $str = str_replace("\u0049\u0309", "\u1EC8", $str); //Ỉ
        $str = str_replace("\u0049\u0301", "\u00CD", $str); //Í
        $str = str_replace("\u0049\u0300", "\u00CC", $str); //Ì
        $str = str_replace("\u0049\u0323", "\u1ECA", $str); //Ị
        $str = str_replace("\u0049\u0303", "\u0128", $str); //Ĩ
        $str = str_replace("\u004F\u0309", "\u1ECE", $str); //Ỏ
        $str = str_replace("\u004F\u0301", "\u00D3", $str); //Ó
        $str = str_replace("\u004F\u0300", "\u00D2", $str); //Ò
        $str = str_replace("\u004F\u0323", "\u1ECC", $str); //Ọ
        $str = str_replace("\u004F\u0303", "\u00D5", $str); //Õ
        $str = str_replace("\u01A0\u0309", "\u1EDE", $str); //Ở
        $str = str_replace("\u01A0\u0301", "\u1EDA", $str); //Ớ
        $str = str_replace("\u01A0\u0300", "\u1EDC", $str); //Ờ
        $str = str_replace("\u01A0\u0323", "\u1EE2", $str); //Ợ
        $str = str_replace("\u01A0\u0303", "\u1EE0", $str); //Ỡ
        $str = str_replace("\u00D4\u0309", "\u1ED4", $str); //Ổ
        $str = str_replace("\u00D4\u0301", "\u1ED0", $str); //Ố
        $str = str_replace("\u00D4\u0300", "\u1ED2", $str); //Ồ
        $str = str_replace("\u00D4\u0323", "\u1ED8", $str); //Ộ
        $str = str_replace("\u00D4\u0303", "\u1ED6", $str); //Ỗ
        $str = str_replace("\u0041\u0309", "\u1EA2", $str); //Ả
        $str = str_replace("\u0041\u0301", "\u00C1", $str); //Á
        $str = str_replace("\u0041\u0300", "\u00C0", $str); //À
        $str = str_replace("\u0041\u0323", "\u1EA0", $str); //Ạ
        $str = str_replace("\u0041\u0303", "\u00C3", $str); //Ã
        $str = str_replace("\u0102\u0309", "\u1EB2", $str); //Ẳ
        $str = str_replace("\u0102\u0301", "\u1EAE", $str); //Ắ
        $str = str_replace("\u0102\u0300", "\u1EB0", $str); //Ằ
        $str = str_replace("\u0102\u0323", "\u1EB6", $str); //Ặ
        $str = str_replace("\u0102\u0303", "\u1EB4", $str); //Ẵ
        $str = str_replace("\u00C2\u0309", "\u1EA8", $str); //Ẩ
        $str = str_replace("\u00C2\u0301", "\u1EA4", $str); //Ấ
        $str = str_replace("\u00C2\u0300", "\u1EA6", $str); //Ầ
        $str = str_replace("\u00C2\u0323", "\u1EAC", $str); //Ậ
        $str = str_replace("\u00C2\u0303", "\u1EAA", $str); //Ẫ
        return $str;
    }

    public static function compound2Unicode($str)
    {

        $str = preg_replace("\u0065\u0309", "\u1EBB", $str); //ẻ
        $str = preg_replace("\u0065\u0301", "\u00E9", $str); //é
        $str = preg_replace("\u0065\u0300", "\u00E8", $str); //è
        $str = preg_replace("\u0065\u0323", "\u1EB9", $str); //ẹ
        $str = preg_replace("\u0065\u0303", "\u1EBD", $str); //ẽ
        $str = preg_replace("\u00EA\u0309", "\u1EC3", $str); //ể
        $str = preg_replace("\u00EA\u0301", "\u1EBF", $str); //ế
        $str = preg_replace("\u00EA\u0300", "\u1EC1", $str); //ề
        $str = preg_replace("\u00EA\u0323", "\u1EC7", $str); //ệ
        $str = preg_replace("\u00EA\u0303", "\u1EC5", $str); //ễ
        $str = preg_replace("\u0079\u0309", "\u1EF7", $str); //ỷ
        $str = preg_replace("\u0079\u0301", "\u00FD", $str); //ý
        $str = preg_replace("\u0079\u0300", "\u1EF3", $str); //ỳ
        $str = preg_replace("\u0079\u0323", "\u1EF5", $str); //ỵ
        $str = preg_replace("\u0079\u0303", "\u1EF9", $str); //ỹ
        $str = preg_replace("\u0075\u0309", "\u1EE7", $str); //ủ
        $str = preg_replace("\u0075\u0301", "\u00FA", $str); //ú
        $str = preg_replace("\u0075\u0300", "\u00F9", $str); //ù
        $str = preg_replace("\u0075\u0323", "\u1EE5", $str); //ụ
        $str = preg_replace("\u0075\u0303", "\u0169", $str); //ũ
        $str = preg_replace("\u01B0\u0309", "\u1EED", $str); //ử
        $str = preg_replace("\u01B0\u0301", "\u1EE9", $str); //ứ
        $str = preg_replace("\u01B0\u0300", "\u1EEB", $str); //ừ
        $str = preg_replace("\u01B0\u0323", "\u1EF1", $str); //ự
        $str = preg_replace("\u01B0\u0303", "\u1EEF", $str); //ữ
        $str = preg_replace("\u0069\u0309", "\u1EC9", $str); //ỉ
        $str = preg_replace("\u0069\u0301", "\u00ED", $str); //í
        $str = preg_replace("\u0069\u0300", "\u00EC", $str); //ì
        $str = preg_replace("\u0069\u0323", "\u1ECB", $str); //ị
        $str = preg_replace("\u0069\u0303", "\u0129", $str); //ĩ
        $str = preg_replace("\u006F\u0309", "\u1ECF", $str); //ỏ
        $str = preg_replace("\u006F\u0301", "\u00F3", $str); //ó
        $str = preg_replace("\u006F\u0300", "\u00F2", $str); //ò
        $str = preg_replace("\u006F\u0323", "\u1ECD", $str); //ọ
        $str = preg_replace("\u006F\u0303", "\u00F5", $str); //õ
        $str = preg_replace("\u01A1\u0309", "\u1EDF", $str); //ở
        $str = preg_replace("\u01A1\u0301", "\u1EDB", $str); //ớ
        $str = preg_replace("\u01A1\u0300", "\u1EDD", $str); //ờ
        $str = preg_replace("\u01A1\u0323", "\u1EE3", $str); //ợ
        $str = preg_replace("\u01A1\u0303", "\u1EE1", $str); //ỡ
        $str = preg_replace("\u00F4\u0309", "\u1ED5", $str); //ổ
        $str = preg_replace("\u00F4\u0301", "\u1ED1", $str); //ố
        $str = preg_replace("\u00F4\u0300", "\u1ED3", $str); //ồ
        $str = preg_replace("\u00F4\u0323", "\u1ED9", $str); //ộ
        $str = preg_replace("\u00F4\u0303", "\u1ED7", $str); //ỗ
        $str = preg_replace("\u0061\u0309", "\u1EA3", $str); //ả
        $str = preg_replace("\u0061\u0301", "\u00E1", $str); //á
        $str = preg_replace("\u0061\u0300", "\u00E0", $str); //à
        $str = preg_replace("\u0061\u0323", "\u1EA1", $str); //ạ
        $str = preg_replace("\u0061\u0303", "\u00E3", $str); //ã
        $str = preg_replace("\u0103\u0309", "\u1EB3", $str); //ẳ
        $str = preg_replace("\u0103\u0301", "\u1EAF", $str); //ắ
        $str = preg_replace("\u0103\u0300", "\u1EB1", $str); //ằ
        $str = preg_replace("\u0103\u0323", "\u1EB7", $str); //ặ
        $str = preg_replace("\u0103\u0303", "\u1EB5", $str); //ẵ
        $str = preg_replace("\u00E2\u0309", "\u1EA9", $str); //ẩ
        $str = preg_replace("\u00E2\u0301", "\u1EA5", $str); //ấ
        $str = preg_replace("\u00E2\u0300", "\u1EA7", $str); //ầ
        $str = preg_replace("\u00E2\u0323", "\u1EAD", $str); //ậ
        $str = preg_replace("\u00E2\u0303", "\u1EAB", $str); //ẫ
        $str = preg_replace("\u0045\u0309", "\u1EBA", $str); //Ẻ
        $str = preg_replace("\u0045\u0301", "\u00C9", $str); //É
        $str = preg_replace("\u0045\u0300", "\u00C8", $str); //È
        $str = preg_replace("\u0045\u0323", "\u1EB8", $str); //Ẹ
        $str = preg_replace("\u0045\u0303", "\u1EBC", $str); //Ẽ
        $str = preg_replace("\u00CA\u0309", "\u1EC2", $str); //Ể
        $str = preg_replace("\u00CA\u0301", "\u1EBE", $str); //Ế
        $str = preg_replace("\u00CA\u0300", "\u1EC0", $str); //Ề
        $str = preg_replace("\u00CA\u0323", "\u1EC6", $str); //Ệ
        $str = preg_replace("\u00CA\u0303", "\u1EC4", $str); //Ễ
        $str = preg_replace("\u0059\u0309", "\u1EF6", $str); //Ỷ
        $str = preg_replace("\u0059\u0301", "\u00DD", $str); //Ý
        $str = preg_replace("\u0059\u0300", "\u1EF2", $str); //Ỳ
        $str = preg_replace("\u0059\u0323", "\u1EF4", $str); //Ỵ
        $str = preg_replace("\u0059\u0303", "\u1EF8", $str); //Ỹ
        $str = preg_replace("\u0055\u0309", "\u1EE6", $str); //Ủ
        $str = preg_replace("\u0055\u0301", "\u00DA", $str); //Ú
        $str = preg_replace("\u0055\u0300", "\u00D9", $str); //Ù
        $str = preg_replace("\u0055\u0323", "\u1EE4", $str); //Ụ
        $str = preg_replace("\u0055\u0303", "\u0168", $str); //Ũ
        $str = preg_replace("\u01AF\u0309", "\u1EEC", $str); //Ử
        $str = preg_replace("\u01AF\u0301", "\u1EE8", $str); //Ứ
        $str = preg_replace("\u01AF\u0300", "\u1EEA", $str); //Ừ
        $str = preg_replace("\u01AF\u0323", "\u1EF0", $str); //Ự
        $str = preg_replace("\u01AF\u0303", "\u1EEE", $str); //Ữ
        $str = preg_replace("\u0049\u0309", "\u1EC8", $str); //Ỉ
        $str = preg_replace("\u0049\u0301", "\u00CD", $str); //Í
        $str = preg_replace("\u0049\u0300", "\u00CC", $str); //Ì
        $str = preg_replace("\u0049\u0323", "\u1ECA", $str); //Ị
        $str = preg_replace("\u0049\u0303", "\u0128", $str); //Ĩ
        $str = preg_replace("\u004F\u0309", "\u1ECE", $str); //Ỏ
        $str = preg_replace("\u004F\u0301", "\u00D3", $str); //Ó
        $str = preg_replace("\u004F\u0300", "\u00D2", $str); //Ò
        $str = preg_replace("\u004F\u0323", "\u1ECC", $str); //Ọ
        $str = preg_replace("\u004F\u0303", "\u00D5", $str); //Õ
        $str = preg_replace("\u01A0\u0309", "\u1EDE", $str); //Ở
        $str = preg_replace("\u01A0\u0301", "\u1EDA", $str); //Ớ
        $str = preg_replace("\u01A0\u0300", "\u1EDC", $str); //Ờ
        $str = preg_replace("\u01A0\u0323", "\u1EE2", $str); //Ợ
        $str = preg_replace("\u01A0\u0303", "\u1EE0", $str); //Ỡ
        $str = preg_replace("\u00D4\u0309", "\u1ED4", $str); //Ổ
        $str = preg_replace("\u00D4\u0301", "\u1ED0", $str); //Ố
        $str = preg_replace("\u00D4\u0300", "\u1ED2", $str); //Ồ
        $str = preg_replace("\u00D4\u0323", "\u1ED8", $str); //Ộ
        $str = preg_replace("\u00D4\u0303", "\u1ED6", $str); //Ỗ
        $str = preg_replace("\u0041\u0309", "\u1EA2", $str); //Ả
        $str = preg_replace("\u0041\u0301", "\u00C1", $str); //Á
        $str = preg_replace("\u0041\u0300", "\u00C0", $str); //À
        $str = preg_replace("\u0041\u0323", "\u1EA0", $str); //Ạ
        $str = preg_replace("\u0041\u0303", "\u00C3", $str); //Ã
        $str = preg_replace("\u0102\u0309", "\u1EB2", $str); //Ẳ
        $str = preg_replace("\u0102\u0301", "\u1EAE", $str); //Ắ
        $str = preg_replace("\u0102\u0300", "\u1EB0", $str); //Ằ
        $str = preg_replace("\u0102\u0323", "\u1EB6", $str); //Ặ
        $str = preg_replace("\u0102\u0303", "\u1EB4", $str); //Ẵ
        $str = preg_replace("\u00C2\u0309", "\u1EA8", $str); //Ẩ
        $str = preg_replace("\u00C2\u0301", "\u1EA4", $str); //Ấ
        $str = preg_replace("\u00C2\u0300", "\u1EA6", $str); //Ầ
        $str = preg_replace("\u00C2\u0323", "\u1EAC", $str); //Ậ
        $str = preg_replace("\u00C2\u0303", "\u1EAA", $str); //Ẫ
        return $str;
    }
    
    public static function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}