@extends('layouts.app')

@section('content')
        <img class="img-fluid" src="{{asset('/storage/' . $task->image)}}"  alt="">
@endsection
