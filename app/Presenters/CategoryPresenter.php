<?php

namespace App\Presenters;

class CategoryPresenter
{

    public function getShowInNavLabel($status)
    {
        $status_class = $this->isShow($status) ? 'Hui-iconfont-xuanze' : 'Hui-iconfont-close';

        $label = <<<i
<i class="Hui-iconfont  {$status_class} ">
</i>
i;

        return $label;
    }

    public function isShow($status)
    {
        return $status == 1;
    }

    public function getIsShowLabel($status)
    {
        $status_class = $this->isShow($status) ? 'Hui-iconfont-xuanze' : 'Hui-iconfont-close';

        $label = <<<i
<i class="Hui-iconfont  {$status_class} ">
</i>
i;

        return $label;
    }
}
