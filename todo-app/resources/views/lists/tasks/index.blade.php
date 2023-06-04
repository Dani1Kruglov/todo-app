@extends('layouts.app')

@section('content')
    <div class="container panel panel-default ">
        @if($roleUser === 'admin')
        <h2 class="panel-heading">Add</h2>
            <form id="create_task" enctype="multipart/form-data">
                <div class="col-md-4" style="width: 800px; margin-top: 50px" >
                    <label for="body" class="form-label">Введите todo</label>
                    <input type="text"  value="{{old('body')}}" name="body"  class="form-control" id="body" >
                    @error('body')
                    <p class="text-danger">Заполните поле</p>
                    @enderror
                </div>
                <div class="input-group" style="margin-top: 50px">
                    <input type="file" name="image" class="form-control" id="image" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                </div>
                <div class="col-md-4" style="width: 800px; margin-top: 50px" >
                    <label for="tags" class="form-label">Введите тэги (#название1#название2)</label>
                    <input type="text"  value="{{old('tags')}}" name="tags"  class="form-control" id="tags" >
                    @error('tags')
                    <p class="text-danger">Заполните поле</p>
                    @enderror
                </div>
                <label>
                    <select class="form-select" style="margin-top: 50px" name="list_id" id="list_id">
                        @if(isset($list_name))
                            <option  value="{{$list_name->id}}">{{$list_name->name}}</option>
                        @else
                            <option selected>Выберите список</option>
                            @foreach($lists as $list)
                                <option  value="{{$list->id}}">{{$list->name}}</option>
                            @endforeach
                        @endif
                    </select>

                </label>
                <div class="col-12" style="margin-top: 50px">
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>
            </form>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

    <script>

        $('#create_task').on('submit',function(event){
            event.preventDefault();

            let image = document.getElementById('image').files[0];
            let formData = new FormData();
            let body = $('#body').val();
            let tags = $('#tags').val();
            let list_id = $('#list_id').val();
            formData.append('image', image);
            formData.append('body', body);
            formData.append('tags', tags);
            formData.append('list_id', list_id);

            $.ajax({
                url: "{{route('task.store')}}",
                type:"POST",
                data:formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: false,
                processData: false,
                success:function(response){
                    console.log('complete');
                },
            });
        });
    </script>



    <h3 style="margin-left: 80px; margin-top: 30px"><div>{{$description}}
        @if(isset($list_name))
            {{$list_name->name}}
        @endif
        </div>
        <div>
            @if($roleUser==='reader')
                От пользователя:  {{$userAdmin->name}}
            @endif
        </div>
    </h3>
    @foreach($tasks as $task)
        <div class="form-check" style="margin-left: 100px; margin-top: 30px">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
                {{$task->body}}
                @if($roleUser === 'admin')
                    <a href="{{route('task.edit', $task->id)}}" class="text-decoration-none tex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                        </svg>
                    </a>
                @endif
                <div style="margin-top: 10px">
                    @if($task->image !== 'null')
                        @if($roleUser === 'admin')
                        <a href="{{route('task.show.image', $task->id)}}">
                            @endif
                            <div style="overflow: hidden; width: 150px; height: 150px;">
                                <img class="img-fluid" src="{{asset('/storage/' . $task->image)}}" style="object-fit: cover; width: 150px; height: 150px;" alt="">
                            </div>
                        </a>
                    @endif
                </div>
            </label>
        </div>
    @endforeach
@endsection
