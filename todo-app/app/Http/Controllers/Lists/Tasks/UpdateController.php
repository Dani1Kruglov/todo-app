<?php

namespace app\Http\Controllers\Lists\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\UpdateRequest;
use App\Models\Lists;
use App\Models\Tags;
use App\Models\Tasks;

class UpdateController extends Controller
{
    public function edit($task){
        $requiredList = Tasks::where('user_id', auth()->user()->id)->where('id', $task)->first();
        if ($requiredList===null)
        {
            return redirect()->route('tasks.index');
        }

        $taskId= $requiredList->id;
        $lists = Lists::where('user_id', auth()->user()->id)->get();
        $tags = Tags::where('user_id', auth()->user()->id)->whereHas('tasks', function ($query) use ($taskId) {
            $query->where('tasks_id', $taskId);
        })->get();
        $userId=auth()->user()->id;
        $availableLists = Lists::whereHas('users', function ($query) use ($userId){
            $query->where('user_id', $userId);
        })->get();
        return view('lists.tasks.edit_list', compact('requiredList', 'lists', 'tags', 'availableLists'));
    }


    public function update($task, UpdateRequest $request){
        $data = $request->validated();
        if (isset($data['imageDelete']))
        {
            $path = 'null';
        }
        elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }
        else{
            $oldPath = Tasks::where('user_id', auth()->user()->id)->where('id', $task)->first();
            $path = $oldPath->image;
        }
        Tasks::where('id', $task)->update([
            'body'=> $data['body'],
            'image'=> $path,
        ]);
        return redirect()->route('tasks.index');
    }
}
