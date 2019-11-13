<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25/03/2018
 * Time: 20:49
 */

namespace App\Common;


class Html
{
    public static function getCategoryHtmlOptions($data, $key, $parent_name = '')
    {
        $html = "";

        foreach ($data as $item) {
            if (is_array($key)) {
                $selected = in_array($item->id, $key) ? 'selected' : '';
            } else {
                $selected = $key == $item->id ? 'selected' : '';
            }

            $name = !empty($parent_name) ? $parent_name . '/' . $item->title : $item->title;
            $html .= "<option value='{$item->id}' {$selected}>{$name}</option>";

            if (!empty($item->childrens)) {
                $html .= self::getCategoryHtmlOptions($item->childrens, $key, $name);
            }
        }

        return $html;
    }

    public static function getCategoryTreeHtml($data, $key, $level = 0)
    {
        $html = "";

        foreach ($data as $item) {
            if (is_array($key)) {
                $selected = in_array($item->id, $key) ? 'selected' : '';
            } else {
                $selected = $key == $item->id ? 'selected' : '';
            }

            $prefix = $level > 0 ? str_repeat('-----', $level) : '';
            $name = $prefix . $item->title;
            $html .= "<option value='{$item->id}' {$selected}>{$name}</option>";

            if (!empty($item->childrens)) {
                $html .= self::getCategoryTreeHtml($item->childrens, $key, $level + 1);
            }
        }

        return $html;
    }

    public static function getCategoryTreeSpaceHtml($data, $key, $level = 0, $extra = [])
    {
        $html = "";

        foreach ($data as $item) {
            if (is_array($key)) {
                $selected = in_array($item->id, $key) ? 'selected' : '';
            } else {
                $selected = $key == $item->id ? 'selected' : '';
            }

            $padding_left = $level * 25 + 25;

            $_extra_parents = !empty($extra['parents']) ? $extra['parents'] : [];

            $html .= "<option value='{$item->id}' {$selected} style='padding-left: {$padding_left}px' data-parents = " . json_encode($_extra_parents) . ">{$item->title}</option>";

            if (!empty($item->childrens)) {
                $_extra_parents[] = $item->id;

                $html .= self::getCategoryTreeSpaceHtml($item->childrens, $key, $level + 1, [
                    'parents' => $_extra_parents
                ]);
            }
        }

        return $html;
    }

    public static function getCategoryTreeSpaceHtml2($data, $key, $level = 0, $extra = [])
    {
        $html = "";

        foreach ($data as $item) {
            if (is_array($key)) {
                $selected = in_array($item->id, $key) ? 'selected' : '';
            } else {
                $selected = $key == $item->id ? 'selected' : '';
            }

            $padding_left = $level * 25 + 25;

            $html .= "<option value='{$item->id}' {$selected} style='padding-left: {$padding_left}px'>{$item->name}</option>";

            if (!empty($item->childrens)) {
                $html .= self::getCategoryTreeSpaceHtml2($item->childrens, $key, $level + 1);
            }
        }

        return $html;
    }

    public static function getTreeHtml($data, $id, $title, $val, $prefix_df = '-----', $level = 0)
    {
        $html = "";

        foreach ($data as $item) {
            if (is_array($val)) {
                $selected = in_array($item[$id], $val) ? 'selected' : '';
            } else {
                $selected = $val == $item[$id] ? 'selected' : '';
            }

            $prefix = $level > 0 ? str_repeat($prefix_df, $level) : '';
            $name = $prefix . $item[$title];
            $html .= "<option value='{$item[$id]}' {$selected}>{$name}</option>";

            if (!empty($item->childrens)) {
                $html .= self::getTreeHtml($item->childrens, $id, $title, $val, $prefix_df, $level + 1);
            }
        }

        return $html;
    }

    public static function render_td($data, $field)
    {
        if(!isset($field) || empty( $field))
        return '<td></td>';
        $v = '';
        if(is_object($data)){
            $v = $data->{$field} ;
        }
        else if(is_array($data)){
            $v = $data[$field];
        }
        return '<td>'.$v.'</td>';
    }

}