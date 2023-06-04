<?php

namespace app\Http\Controllers\Lists;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lists\ListStoreRequest;
use App\Models\Lists;
use App\Models\Tags;
use App\Models\Tasks;

class SearchTaskInListController extends Controller
{
    public function find($list, ListStoreRequest  $request){
        $data = $request->validated();
        $roleUser='admin';
        if (empty($data['search'])){
            $tasks = Tasks::where('user_id', auth()->user()->id)->where('list_id', $list)->latest()->get();
        }
        elseif ((int)$data['search'] === 1){
            $tags = explode("#", $data['name']);
            unset($tags[0]);
            $tasks = Tasks::join('tags_tasks', 'tasks.id', '=', 'tags_tasks.tasks_id')//поиск всех задач со всеми нужными тегами
                ->join('tags', 'tags_tasks.tags_id', '=', 'tags.id')
                ->whereIn('tags.title', $tags)
                ->groupBy('tasks.id')
                ->havingRaw('COUNT(DISTINCT tags.title) = ?', [count($tags)])
                ->select('tasks.*')
                ->latest()->get();

        }
        elseif ((int)$data['search'] === 2) {
            $tasks = Tasks::where('user_id', auth()->user()->id)->where('list_id', $list)->where('body', 'like', "%{$data['name']}%")->get();
        }
        $lists = Lists::where('user_id', auth()->user()->id)->get();
        $list_name = Lists::where('user_id', auth()->user()->id)->where('id', $list)->first();
        $description = 'Найденые задачи: ';
        return view('lists.tasks.index', compact('tasks', 'lists', 'description', 'list_name','roleUser'));

    }
}
