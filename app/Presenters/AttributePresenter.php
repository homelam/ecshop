<?php

namespace App\Presenters;

class AttributePresenter
{
    const ATTR_INPUT_TYPE_TEXT = '手工录入';
    const ATTR_INPUT_TYPE_SELECT = '从列表中选择';
    const ATTR_INPUT_TYPE_TEXTAREA = '多行文本框';

    public function translateInputType(int $attr_input_type)
    {
        switch($attr_input_type) {
            case 0:
                return self::ATTR_INPUT_TYPE_TEXT;
                break;
            case 1:
                return self::ATTR_INPUT_TYPE_SELECT;
                break;
            case 2:
                return self::ATTR_INPUT_TYPE_TEXTAREA;
                break;
            default:
                return '';
        }
    }
}
