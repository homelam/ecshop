<?php

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
