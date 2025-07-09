@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header flex justify-between">
                    <span>What next you need To-DO</span>
                    <a href="{{route('todo.index')}}" class="text-gray-800 text-2xl cursor-pointer">
                        <span class="fas fa-arrow-left" />
                    </a>
                </div>

                <div class="card-body">               
                <x-alert />
                <form method="post" action="{{route('todo.store')}}" class="py-5">
                    @csrf
                    <div class="py-1">
                        <input type="text" name="title" class="py-2 px-2 border rounded" placeholder="Title" />
                    </div>
                    <div class="py-1">
                        <textarea name="description" class="p-2 rounded border" placeholder="Description"></textarea>
                    </div>

                    <div class="py-2">
                        @livewire('step')
                    </div>
                    <div class="py-1">
                        <input type="submit" value="Create" class="p-2 border rounded" />
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection