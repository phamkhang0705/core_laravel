<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 10/03/2018
 * Time: 08:38
 */

namespace App\Common;


/**
 * Class Content
 * @package App\Common
 */
class Content
{


    const TYPE_TAG = 'TAG';
    const TYPE_ADMIN = 'ADMIN';
    const TYPE_ROLE = 'ROLE';
    const TYPE_MENU = 'MENU';
    const TYPE_CATEGORY = 'CATEGORY';
    const TYPE_MERCHANT_AVATAR = 'MERCHANT_AVATAR';
    const TYPE_MERCHANT = 'MERCHANT';
    const TYPE_MERCHANT_LOGO = 'MERCHANT_LOGO';
    const TYPE_DEAL = 'DEAL';
    const TYPE_EVOUCHER = 'EVOUCHER';
    const TYPE_EVENT = 'EVENT';
    const TYPE_PRODUCT = 'PRODUCT';
    const TYPE_BANNER = 'BANNER';
    const TYPE_AD = 'Ad';
    const TYPE_SHOWCASE = 'SHOWCASE';
    const TYPE_NEWS = 'NEWS';
    const TYPE_SPONSOR = 'SPONSOR';
    const TYPE_BANNER_AD = 'BANNER_AD';
    
    public static function getContent()
    {
        return [
            self::TYPE_TAG => 'TAG',
            self::TYPE_MENU => 'MENU',
            self::TYPE_ROLE => 'ROLE',
            self::TYPE_ADMIN => 'Quản trị viên',
            self::TYPE_CATEGORY => 'Danh mục khuyến mại',
            self::TYPE_MERCHANT => 'Công ty',
            self::TYPE_MERCHANT_AVATAR => 'Công ty',
            self::TYPE_MERCHANT_LOGO => 'Logo công ty',
            self::TYPE_DEAL => 'Khuyến mại',
            self::TYPE_EVOUCHER => 'Evoucher',
            self::TYPE_EVENT => 'Sự kiện',
            self::TYPE_PRODUCT => 'Sản phẩm',
            self::TYPE_BANNER => 'Banner',
            self::TYPE_AD => 'Sự kiện nổi bật',
            self::TYPE_SHOWCASE => 'Showcase',
            self::TYPE_NEWS => 'Tin tức',
            self::TYPE_BANNER_AD => 'Quảng cáo trang chủ',
        ];
    }

    public static function getContentName($type)
    {
        $s = self::getContent();
        return isset($s[$type]) ? $s[$type] : '';
    }

}
