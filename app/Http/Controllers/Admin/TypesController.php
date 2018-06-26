<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Repositories\TypeRepository;
use Validator;
use App\Models\Traits\ApiTrait;

class TypesController extends Controller
{
    use ApiTrait;

    protected $typeRepository;

    public function __construct(TypeRepository $typeRepository)
    {
        $this->typeRepository = $typeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = $this->typeRepository->getAllTypes();

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = $this->typeRepository->store($request);

        if ($result['status'] == 1) {
            return redirect('admin/types');
        } else  {
            return back()->with('status', $result['msg']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'type_name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $result = $this->typeRepository->updateType($request, $id);
        if ($result) {
            return redirect('admin/types');
        }

        return back()->with('status', 'error');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        if ($type->type_id > 0) {
            $result = $this->typeRepository->destroy($type);
            $code = $result['status'];
            $msg = $result['msg'];
        } else {
            $code = '0';
            $msg = '商品类型不存在';
        }
        return $this->setCode($code)->setMsg($msg)->toJson();
    }
}
