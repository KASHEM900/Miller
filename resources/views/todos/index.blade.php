@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header flex justify-between">
                    <span >All Your Todos</span>
                    <a href="{{route('todo.create')}}" class="text-blue-400 text-2xl cursor-pointer">
                        <span class="fas fa-plus-circle" />
                    </a>
                </div>

                <div class="card-body">
                    <ul >
                        <x-alert />
                        @forelse($todos as $todo)
                        <li class="flex justify-between p-2">
                            <div>
                                @include('todos.complete-button')
                            </div>
            
                            @if($todo->completed)
                            <p class="line-through">{{$todo->title}}</p>
                            @else
                            <a class="cursor-pointer" href="{{route('todo.show',$todo->id)}}">{{$todo->title}}</a>
                            @endif
            
                            <div>
                                <a href="{{route('todo.edit',$todo->id)}}" class="text-orange-400 cursor-pointer">
                            <span class="fas fa-pen px-2" /></a>
                                
                            <span class="fas fa-times text-red-500 px-2 cursor-pointer"  
                            onclick="event.preventDefault();
                                    if(confirm('Are you really want to delete?')){
                                        document.getElementById('form-delete-{{$todo->id}}')
                                        .submit()
                                    }"/>
                            <form style="display:none" id="{{'form-delete-'.$todo->id}}" method="post" action="{{route('todo.destroy',$todo->id)}}">
                                @csrf
                                @method('delete')
                            </form>
                            </div>
                        </li>
                        @empty
                                    <p>No task available, create one.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
        
@endsection

