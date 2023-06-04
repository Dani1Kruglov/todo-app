<?php

namespace app\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lists\ListStoreRequest;
use App\Models\Lists;

class ListStoreController extends Controller
{
    public function store(ListStoreRequest  $request)
    {
        $data = $request->validated();
        Lists::create([
            'name'=>$data['name'],
            'user_id'=>auth()->user()->id,
        ]);
        $msg='complete';
        return response()->json(array('body'=>$msg));
    }
}
