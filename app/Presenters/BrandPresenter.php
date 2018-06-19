<?php

namespace App\Presenters;

class BrandPresenter
{
    public function getBrandLogoLink($link = '')
    {
        if ($link) {
            return starts_with($link, 'http') ? $link : "/uploads/{$link}";
        }
        return '';
    }
}
