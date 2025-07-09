@extends('users.layout')

@section('contentbody')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  text-2xl flex justify-between">
                    <span>এডমিন ইউজার তৈরি তথ্য</span>
                </div>

                <div class="card-body">
                    <div id="user_div">
                        <p align="right"> <span style="color: red;"> (*) </span> চিহ্নিত ঘর গুলো অবশ্যই পূরণ করতে হবে </p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                            <strong>দুঃখিত!</strong> আপনার এন্ট্রি করতে কোনো সমস্যা হয়েছে|<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <fieldset>
                            {{-- <legend><b>এডমিন ইউজার তৈরি তথ্য   <span style="color: gray;"> </span></b></legend> --}}
                            <form class="userform" action="createuser" method="POST" enctype="multipart/form-data">
                                @csrf
                            <table>
                                <tbody>

                                @include('users.create-user-common')

                                </tbody>
                            </table>
                            </form>
                        </fieldset>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

