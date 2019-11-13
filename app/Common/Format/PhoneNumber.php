<?php
namespace App\Common\Format;

class PhoneNumber {

    public static function formatPhone($phone) {
        if(strpos($phone,'00')===0){
            $phone=substr($phone,2);
        }elseif(strpos($phone,'+')===0){
            $phone=substr($phone,1);
        }elseif(strpos($phone,'0')===0){
            $phone='84'.substr($phone,1);
        }

        if(strpos($phone, '84') !== 0){
            $phone = '84'.$phone;
        }
        return trim($phone);
    }

    public static function removePrefixPhoneNumber($phone,$prefix = true)
    {
        $suffix = $prefix?"0":"";
        /*Remove Country PhoneCode */
        if(strpos($phone,'84')===0){
            $phone = $suffix.substr($phone,strlen('84'));
        }else if(strpos($phone,"0")!==0){
            $phone = $suffix.$phone;
        }
        return $phone;
    }

    public static function isViettelNumber($phone)
    {
        $phone = self::formatPhone($phone);
        $phone = self::removePrefixPhoneNumber(trim($phone));
        $pattern = "/^(096|097|098|0162|0163|0164|0165|0166|0167|0168|0169|086)([0-9]{7})$/";
        return preg_match($pattern, $phone);
    }

    public static function isVinaPhoneNumber($phone)
    {
        $phone = self::formatPhone($phone);
        $phone = self::removePrefixPhoneNumber(trim($phone));
        $pattern = "/^(091|094|0123|0125|0127|0129|0124|088)([0-9]{7})$/";
        return preg_match($pattern, $phone);
    }

	public static function isMobifonePhoneNumber($phone)
	{
		$phone = self::formatPhone($phone);
		$phone = self::removePrefixPhoneNumber(trim($phone));
		$pattern = "/^(090|093|0122|0126|0128|0121|0120|089)([0-9]{7})$/";
		return preg_match($pattern, $phone);
	}

	public static function isVnmPhoneNumber($phone)
	{
		$phone = self::formatPhone($phone);
		$phone = self::removePrefixPhoneNumber(trim($phone));
		$pattern = "/^(092)([0-9]{7})$/";
		return preg_match($pattern, $phone);
	}

    /* Input 84xxx*/
    public static function isPhoneNumber($phoneNumber) {
        $phoneNumber = self::removePrefixPhoneNumber($phoneNumber);
        $pattern = "/^(09|01|08)([0-9]{8,9})$/";
        return preg_match($pattern, $phoneNumber);
    }
}