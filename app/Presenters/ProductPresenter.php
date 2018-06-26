<?php

namespace App\Presenters;

class ProductPresenter
{
    public function getImageLink($link = '')
    {
        if ($link) {
            return starts_with($link, 'http') ? $link : '/' . config('image.upload.disks') . "/{$link}";
        }
        return '';
    }

    /**
     * 在库存量中哪个属性值被选中
     * @param string $data 属性id字符串
     * @param int $id 当前需要判断的属性id
     */
    public function getSelected(string $data, $id)
    {
        // 把对应的字符串转成数组形式
        $arr = explode(',', $data);
        if (in_array($id, $arr)) {
            return 'selected';
        }

        return '';
    }
}
