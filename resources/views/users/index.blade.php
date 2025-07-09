@extends('users.layout')

@section('contentbody')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl">ইউজারের তথ্য </div>
                <div class="p-3 flex justify-between">

                    <form action="{{ route('users.index') }}">
                        @csrf
                        <div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>বিভাগ</td>

                                        <td>:</td>

                                        <td>
                                            <select name="division_id" id="division_id" class="form-control" size="1"
                                            title="অনুগ্রহ করে  বিভাগ বাছাই করুন" required="">
                                                    <option value="">বিভাগ</option>
                                                    @foreach($divisions as $division)
                                                    <option value="{{ $division->divid}}" {{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td> জেলা</td><td>:</td>

                                        <td><select name="district_id" id="district_id"
                                            class="form-control" size="1"
                                            title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                            <option value="">জেলা</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->distid}}"
                                                {{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                                                    @endforeach
                                        </select></td>

                                        <td>উপজেলা </td>
                                        <td>:</td>
                                        <td>
                                            <select name="upazila_id" id="mill_upazila_id" class="form-control"
                                            title="অনুগ্রহ করে  উপজেলা বাছাই করুন">
                                                <option value="">উপজেলা</option>
                                                @foreach($upazillas as $upazilla)
                                                    <option value="{{ $upazilla->upazillaid}}" {{ ( $upazilla->upazillaid == $upazila_id) ?
                                                    'selected' : '' }}>{{ $upazilla->upazillaname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td  style="padding-left:10px"><input type="submit" class="btn btn-primary" name="filter" id="listOfckol" value="ফলাফল"></td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                    <span style="color:red"> বিভাগ, জেলা ও উপজেলা বাছাই করতে হবে</span>

                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>বিভাগ @sortablelink('division.divname', '')</th>
                            <th>জেলা @sortablelink('district.distname', '')</th>
                            <th>উপজেলা @sortablelink('upazilla.upazillaname', '')</th>

                            <th>নাম</th>
                            <th>ইউজার টাইপ</th>
                            <th>ইমেইল</th>
                            <th>একটিভ</th>
                            <th>অ্যাকশন</th>
                        </tr>

                        @forelse($users as $user)
                        <tr>
                            @if(empty($user->division))
                                <td>নাই</td>
                            @else
                            <td>{{ $user->division->divname}}</td>
                            @endif

                            @if(empty($user->district ))
                                <td>নাই</td>
                            @else
                            <td>{{ $user->district->distname}}</td>
                            @endif

                            @if(empty($user->upazilla))
                                <td>নাই</td>
                            @else
                            <td>{{ $user->upazilla->upazillaname}}</td>
                            @endif

                            <td>{{ $user->name}}</td>
                            <td>{{ $user->usertype->name}}</td>

                            <td>{{ $user->email}}</td>

                            @if($user->active_status == 1)
                                <td><input type="checkbox" name="act4" disabled="" value="1" checked=""></td>
                            @else
                           <td><input type="checkbox" name="act4" disabled="" value="1"></td>
                            @endif
                            <td>
                            <a href="{{route('changeotherpassword', $user->id)}}" class="btn2 btn-primary">
                                পাসওয়ার্ড</a>
                            </td>

                        </tr>

                        @endforeach
                    </table>
                    <div class="print_hide pt-3">
                        {!! $users->appends(\Request::except('page'))->render() !!}
                    </div>

                    @if(empty($user))
                    <br><p style="color:red"> কিছুই পাওয়া যায়নি!</p> </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>


@endsection
