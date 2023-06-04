@extends('layouts.app')

@section('content')
    <div style="margin-top: 10px; margin-left: 25%">
        @foreach($tags as $tag)
            #{{$tag->title}}
        @endforeach
    </div>
    <form class="row g-3 needs-validation" action="{{route('task.update', $requiredList->id)}}" enctype="multipart/form-data" novalidate method="post" style="margin-left: 25%" >
        @csrf
        @method('patch')
        <div class="col-md-4" style="width: 800px; margin-top: 50px" >
            <label for="body" class="form-label">Введите todo</label>
            <input type="text"  value="{{$requiredList->body}}" name="body"  class="form-control" id="body" >
            @error('body')
            <p class="text-danger">Заполните поле</p>
            @enderror
        </div>
        @if($requiredList->image !== 'null')
            <a href="{{route('task.show.image', $requiredList->id)}}">
                <div style="overflow: hidden; width: 150px; height: 150px;">
                    <img class="img-fluid" src="{{asset('/storage/' . $requiredList->image)}}" style="object-fit: cover; width: 150px; height: 150px;" alt="">
                </div>
            </a>
        @endif
        <div class="input-group" style="margin-top: 50px; width: 800px">
            <input type="file" name="image" class="form-control" id="image" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
        </div>
        <div style="margin-right: 10px ">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="imageDelete" id="option1" value="{{1}}" >
                <label class="form-check-label" for="option1">
                    Удалить фото
                </label>
            </div>
        </div>
        <div class="col-12" style="margin-top: 50px">
            <button  class="btn btn-success" type="submit">Update</button>
        </div>

    </form>
@endsection
