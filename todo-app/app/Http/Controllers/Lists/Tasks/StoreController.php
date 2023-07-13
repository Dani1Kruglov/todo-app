<?php

namespace App\Http\Controllers\Lists\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tasks\StoreRequest;
use App\Models\Lists;
use App\Models\Tags;
use App\Models\Tasks;
use Illuminate\Http\Request;


class StoreController extends Controller
{
    public function store(StoreRequest $request )
    {
        //работа с картинкой
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads', 'public');
        }
        else{
            $path = 'null';
        }

        //остальная работа
        $data = $request -> validated();
        $tags = explode("#", $data['tags']);
        unset($data['tags'], $tags[0]);
        $task = Tasks::create([
            'body'=>$data['body'],
            'image'=>$path,
            'user_id'=>auth()->user()->id,
            'list_id'=>$data['list_id'],
        ]);

        foreach ($tags as $tag){
            if(Tags::where('title', $tag)->where('user_id', auth()->user()->id)->first() === null) {
                Tags::create([
                    'title' => $tag,
                    'user_id' => auth()->user()->id,
                ]);
            }
            $id = Tags::where('title', $tag)->where('user_id', auth()->user()->id)->first();
            $tagsId[] = $id->id;
        }
        $task->tags()->attach($tagsId);
        $msg = 'complete';
        return response()->json(array('body'=>$msg));
    }

}
