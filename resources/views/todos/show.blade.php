@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header flex justify-between">
                    <span >{{$todo->title}}</span>
                    <a href="{{route('todo.index')}}" class="text-gray-800 text-2xl cursor-pointer">
                        <span class="fas fa-arrow-left" />
                    </a>
                </div>

                <div class="card-body">
                    <div>
                        <h3 class="text-lg">Description</h3>
                            <p>{{$todo->description}}</p>
                        </div>
                
                        @if($todo->steps->count() > 0)
                        <div class="py-4">
                            <h3 class="text-lg">Step for this task</h3>
                            @foreach($todo->steps as $step)
                                <p>{{$step->name}}</p>
                            @endforeach
                        </div>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection