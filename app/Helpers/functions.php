<?php

use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
// 自定义全局自定义函数

// 是否显示的label标签
if (!function_exists('isShowLabel')) {
    function isShowLabel($status = 0)
    {
        $status_class = ($status == 1)? 'Hui-iconfont-xuanze' : 'Hui-iconfont-close';

        $label = <<<i
<i class="Hui-iconfont  {$status_class} ">
</i>
i;
        return $label;
    }
}

if (!function_exists('datetime'))
{

    /**
     * 将时间戳转换为日期时间
     * @param int $time 时间戳
     * @param string $format 日期时间格式
     * @return string
     */
    function datetime($time, $format = 'Y-m-d H:i:s')
    {
        if ($time) {
            $time = is_numeric($time) ? $time : strtotime($time);
            return date($format, $time);
        }
        return '';
    }
}

/**
 * 使用一个表中的数据制作下拉框
 *
 * @param string $tableName 取数据的数据表表名
 * @param string $selectName 下拉框的name属性值
 * @param string $valueFieldName option value值字段名称
 * @param string $textFieldName option 显示的名称
 * @param string $selectedValue 被选中的选项
 * @param string $selectedId 下拉框的id值
 *
 * @return string
 *
 */
if (!function_exists('buildSelect')) {
    function buildSelect($tableName, $selectName, $valueFieldName, $textFieldName, $selectId, $selectedValue = '')
    {
        // 获取数据
        $data = DB::table($tableName)->select("$valueFieldName", "$textFieldName")->get();
        $select = "<select name='$selectName' class='select' id='$selectId'><option value=''>请选择...</option>";
        foreach ($data as $k => $v)
        {
            $value = $v->$valueFieldName;
            $text = $v->$textFieldName;
            if($selectedValue && $selectedValue == $value)
                $selected = 'selected="selected"';
            else
                $selected = '';
            $select .= '<option '.$selected.' value="'.$value.'">'.$text.'</option>';
        }
        $select .= '</select>';

        return $select;
    }
}

/**
 * 为图片生成缩略图
 * @param string $picPath 生成缩略图的原图路径
 * @param array $size 需要生成的规格
 *
 * @return array
 */
if (!function_exists('uploadSizeImage')) {
    function uploadSizeImage($picPath = '', $size = [])
    {
        if (file_exists(config('image.upload.disks') . '/' . $picPath)) {
            $fileName = pathinfo($picPath)['basename'];
            $imgSizes = $size ?: config('image.size');

            foreach ($imgSizes as $k => $v) {
                // 先判断文件夹是否存在，不存在需要创建
                $savePath = config('image.upload.thumbs') . '/' . "$v[0]x$v[1]";
                $checkPath = config('image.upload.disks') . '/' . $savePath;
                if (!file_exists($checkPath) ) {
                    mkdir($checkPath, 0777, true);
                }
                Image::make(config('image.upload.disks') . '/' . $picPath)->resize($v[0], $v[1])->save($checkPath . '/' . $fileName);
                $ret['images'][$k] = $savePath . '/' . $fileName;
            }

            return $ret ?? [];
        }
    }
}

/**
 * 为图片生成缩略图
 * @param array|string $images 需要删除的图片的路径
 *
 * @return void
 */
if (!function_exists('deleteImage')) {
    function deleteImage($links)
    {
        if (is_array($links)) {
            array_walk_recursive($links, 'deleteImage');
        } else {
            // delete file
            Storage::drive(config('image.upload.disks'))->delete($links);
        }
    }
}

if (!function_exists('showImage')) {
    function showImage($url, $width = '', $height = '')
    {
        $disk = config('image.upload.disks');
        if($width)
            $width = "width='$width'";
        if($height)
            $height = "height='$height'";

        $path = $disk . '/' . $url;
        echo "<img $width $height src='{$path}' />";
    }
}
