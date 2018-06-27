<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Traits\ImageTrait;

class CommonController extends Controller
{
    use ImageTrait;

    //图片上传操作
    public function uploadImage(Request $request)
    {
        $result = $this->upload($request, 'Filedata', 'products');
        return $result;
    }
}
