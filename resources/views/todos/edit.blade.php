@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header flex justify-between">
                    <span >What next you need To-DO</span>
                    <a href="{{route('todo.index')}}" class="text-gray-800 text-2xl cursor-pointer">
                        <span class="fas fa-arrow-left" />
                    </a>
                </div>

                <div class="card-body">                
                    <x-alert />
                    <form method="post" action="{{route('todo.update',$todo->id)}}" class="py-5">
                        @csrf
                        @method('patch')
                        <div class="py-1">
                            <input type="text" name="title" value="{{$todo->title}}" class="py-2 px-2 border rounded" placeholder="Title" />
                        </div>
                        <div class="py-1">
                            <textarea name="description" class="p-2 rounded border" placeholder="Description">{{$todo->description}}</textarea>
                        </div>
                        <div class="py-2">
                            @livewire('edit-step',['steps' => $todo->steps])
                        </div>
                        <div class="py-1">
                            <input type="submit" value="Update" class="p-2 border rounded" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection