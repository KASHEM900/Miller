@extends('users.layout')

@section('contentbody')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl flex justify-between">
                    <span>সাইলো ইউজার তৈরি তথ্য</span>
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

                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                      <p>{{ $message }}</p>
                                </div>
                            @endif
                            <div class="card-body">
                          @if ($message = Session::get('Warning'))
                              <div class="alert alert-danger">
                                    <p>{{ $message }}</p>
                              </div>
                          @endif

                        <fieldset>
                            {{-- <legend><b>সাইলো ইউজার তৈরি তথ্য   <span style="color: gray;"> </span></b></legend> --}}
                            <form class="userform" action="createuser6" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td width="50%">বিভাগ<span style="color: red;"> * </span></td>
                                                <td><strong>:</strong> </td>
                                                <td>
                                                    <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন" required="">
                                                            <option value="">বিভাগ</option>
                                                            @foreach($divisions as $division)
                                                            <option value="{{ $division->divid}}" {{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                            @endforeach
                                                    </select>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="50%">অফিস<span style="color: red;"> * </span></td>
                                                <td><strong>:</strong> </td>
                                                <td>
                                                    <select name="current_office_id" id="current_office_id" class="form-control"
                                                    size="1" title="অনুগ্রহ করে অফিস বাছাই করুন" required="">
                                                            <option value="">অফিস</option>
                                                            @foreach($offices as $office)
                                                            <option value="{{ $office->office_id}}">{{ $office->office_name}}</option>
                                                            @endforeach
                                                    </select>
                                                </td>
                                            </tr>


                                            @include('users.create-user-common')

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label>অনুমোদিত বিভাগ নির্বাচন করুন<span style="color: red;"> * </span></label>
                                        <select id="tAllowedDivisionList" name="AllowedDivisionList[]" required multiple class="form-control" size="8">
                                                @foreach($divisions as $division)
                                                    <option value="{{ $division->divid}}" {{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </fieldset>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

