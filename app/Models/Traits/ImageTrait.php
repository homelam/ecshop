<?php

namespace App\Models\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    use ApiTrait;

    /**
     * 验证上传的文件
     */
    protected function validateFile($request, $fieldName)
    {
        if (! $request->hasFile($fieldName)) {
            return $this->setMsg('没有选择文件')->toJson();
        }

        if (! $request->file($fieldName)->isValid()) {
            return $this->setMsg('文件无效')->toJson();
        }

        return true;
    }

    /**
     * 图片上传
     *
     * @param Request $request
     * @param string $type 上传图片的类型 属于:商品| 品牌| 分类| ..
     * @param string $path 上传的路径配置
     * @param boolean $isSize 是否生成多尺寸的图片
     * @return array|bool
     */
    public function upload(Request $request, $fieldName = "product_image", $type = 'products')
    {
        $pathConfig = config('image.upload.'.$type);
        if (true !== ($response = $this->validateFile($request, $fieldName))) {
            return $response;
        }

        // move file to public
        if ($link = $request->file($fieldName)->store($pathConfig, config('image.upload.disks'))) {
            // 上传成功后返回对应的图片路径
            return $this->setMsg($pathConfig)->setCode(0)->setData(['src' => $link])->toJson();
        }

        return $this->setMsg('服务器出错，请稍后再试')->setCode(301)->toJson();
    }

    /**
     * 删除图片
     */
    public function deleteImage($links)
    {
        if (is_array($links)) {
            array_walk_recursive($links);
        } else {
            // delete file
            Storage::drive(config('image.upload.disks'))->delete($links);
        }

        return true;
    }
}
