<?php

namespace app\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Models\Lists;
use App\Models\Tags;
use App\Models\Tasks;
use App\Models\User;

class ListShowController extends Controller
{
    public function __invoke($userId,$list)
    {

        /*$allowedUser = User::whereHas('lists', function ($query) use ($list){
            $query->where('lists_id', $list);
        })->first();*/
        if (auth()->user()->id===(int)$userId){
            $roleUser='admin';

        }else{
            $roleUser='reader';
        }
        $userAdmin = User::where('id', $userId)->first();
        $lists = Lists::where('user_id', $userId)->get();
        $tasks = Tasks::where('user_id', $userId)->where('list_id', $list)->latest()->get();
        $list_name = Lists::where('user_id', $userId)->where('id', $list)->first();
        $description = "Задачи из списка:";
        $availableUserId=auth()->user()->id;
        $availableLists = Lists::whereHas('users', function ($query) use ($availableUserId){
            $query->where('user_id', $availableUserId);
        })->get();
        return view('lists.tasks.index', compact('lists', 'tasks', 'description', 'list_name', 'availableLists','roleUser','userAdmin'));
    }
}
