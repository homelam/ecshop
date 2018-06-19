<?php

namespace App\Http\Controllers\Repositories;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rule;
use App\Presenters\BrandPresenter;
use Validator;
use App\Http\Controllers\Traits\ImageTrait;
use App\Http\Controllers\Traits\ApiTrait;

class BrandRepository
{
    use ImageTrait;

    protected $brandModel;
    protected $brandPresenter;
    public function __construct(Brand $brandModel, BrandPresenter $brandPresenter)
    {
        $this->brandModel = $brandModel;
        $this->brandPresenter = $brandPresenter;
    }

    // 获取所有的品牌
    public function brands()
    {
        return $this->brandModel->getAllBrands();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $uploadResult = $this->upload($request, 'brand_logo', 'brand');
        if (isset($uploadResult['data']['src'])) {
            $data['brand_logo'] = $uploadResult['data']['src'];
        }

        $result = Brand::create($data);

        if ($result) {
            return ['status' => 1, 'msg' => '品牌添加成功!'];
        }

        return ['status' => 0, 'msg' => '品牌添加失败!'];
    }

    public function update(Request $request, Brand $brand)
    {
        $rules = [
            'brand_name'=> 'required|max:60',
            'brand_desc' => 'bail|required'
        ];
        $valid = Validator::make($request->all(), $rules);

        $data = $request->all();
        if ($valid->passes()) {
            $uploadResult = $this->upload($request, 'brand_logo', 'brand');
            if (isset($uploadResult['data']['src'])) {
                $data['brand_logo'] = $uploadResult['data']['src'];
                // 删除原来的图片
                $original_link = $brand->brand_logo;
                $this->deleteImage($original_link);
            }

            // 更新数据库
            $result = $brand->update($data);

            if ($result) {
                $data = ['status' => 1, 'msg' => '更新成功'];
            } else {
                $data = ['status' => 0, 'msg' => '品牌更新失败'];
            }
        }

        return $data ?? ['status' => 2, 'msg' => $valid];
    }

    public function delete(Brand $brand)
    {
        if ($brand) {
            DB::beginTransaction();
            try {
                $brand_logo = $brand->brand_logo;
                $result = $brand->delete();
                $data = ['status' => 1, 'msg' => '分类删除成功!'];
                $code = 200;
                // 同时删除图片
                $this->deleteImage($brand_logo);
                DB::commit();
            } catch (QueryException $e) {
                DB::rollBack();
                $data = ['status' => 0, 'msg' => "{$category->cat_name} 分类下有商品存在，不允许直接删除"];
                $code = 201;
            }
        }

        return $data ?? ['status' => 0, 'msg' => '分类不存在!'];
    }
}
