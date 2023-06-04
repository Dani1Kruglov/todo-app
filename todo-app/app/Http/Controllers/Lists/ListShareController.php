<?php

namespace app\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lists\ListShareRequest;
use App\Models\Lists;
use App\Models\User;

class ListShareController extends Controller
{
    public function __invoke(ListShareRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['user_email'])->first();
        if ($user === null){
            return redirect()->route('tasks.index');
        }
        if((int)$data['list_id'][0] === -1){
            $lists = Lists::select('id')
                ->where('user_id', auth()->user()->id)
                ->get();

            $user->lists()->syncWithoutDetaching($lists->mapWithKeys(function ($list) {
                return [$list->id => ['main_user_id' => auth()->user()->id]];
            }));
            return redirect()->route('tasks.index');
        }
        $lists_id = $data['list_id'];
        $user->lists()->attach($lists_id, [
            'main_user_id' => auth()->user()->id,
        ]);
        return redirect()->route('tasks.index');
    }
}
