<?php

namespace app\Http\Controllers\Lists\Tasks;

use App\Http\Controllers\Controller;
use App\Models\Lists;
use App\Models\Tasks;

class TaskController extends Controller
{

    public function index(){
        $roleUser='admin';
        $tasks = Tasks::where('user_id', auth()->user()->id)->latest()->get();
        $lists = Lists::where('user_id', auth()->user()->id)->get();
        $description = 'Задачи из всех списков';
        $userId=auth()->user()->id;
        $availableLists = Lists::whereHas('users', function ($query) use ($userId){
            $query->where('user_id', $userId);
        })->get();
        return view('lists.tasks.index', compact('lists', 'tasks', 'description', 'availableLists','roleUser'));
    }

    public function showImage($taskId){
        $task = Tasks::where('user_id', auth()->user()->id)->where('id', $taskId)->latest()->first();
        $lists = Lists::where('user_id', auth()->user()->id)->get();
        $userId=auth()->user()->id;
        $availableLists = Lists::whereHas('users', function ($query) use ($userId){
            $query->where('user_id', $userId);
        })->get();
        return view('lists.tasks.task_image', compact('task', 'lists', 'availableLists'));
    }
}
