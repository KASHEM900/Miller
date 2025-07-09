@extends('miller.layout')
@section('title', 'Activity Log')

@section('contentbody')
<div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl"> একটিভিটি লগ </div>
                <div class="p-3 flex justify-between justify-middle">
                    <form action="{{ route('activity.index') }}">
                        @csrf
                        <div>
                            <table cellpadding="3px">
                                <tbody>
                                    <tr>
                                    <td class="pl-2">হতে</td>
                                    <td><input type="text" name="date_from" id="date_from" class="form-control date" value="{{$date_from}}" placeholder="একটি তারিখ বাছাই করুন"></td>
                                    <td class="pl-2">পর্যন্ত</td>
                                    <td><input type="text" name="date_to" id="date_to" class="form-control date" value="{{$date_to}}" placeholder="একটি তারিখ বাছাই করুন"></td>
                                    <td>অ্যাকশন টাইপ:</td>
                                    <td>
                                        <select name="action_type" id="action_type" class="form-control" size="1"
                                            title="অনুগ্রহ করে অ্যাকশন টাইপ বাছাই করুন">
                                            <option value="">অ্যাকশন টাইপ</option>
                                            <option value="created" {{ ( $action_type == "created") ? 'selected' : '' }}> Create</option>
                                            <option value="updated" {{ ( $action_type == "updated") ? 'selected' : '' }}> Update</option>
                                            <option value="deleted" {{ ( $action_type == "deleted") ? 'selected' : '' }}> Delete</option>
                                        </select>
                                    </td>
                                    <td style="padding-left:10px"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary"  value="ফলাফল"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <span style="color:red"> অবশ্যই তারিখ বাছাই করতে হবে</span>
                </div>


                <div class="card-body mb-2">
                    <table id="table_id" class="table-bordered" cellpadding="5px" width="100%">

                        <thead>
                        <tr>
                            <th>ইভেন্ট</th>
                            <th>সাবজেক্ট</th>
                            <th>প্রোপারটিস</th>
                            @if($action_type != "created")
                              @if($action_type != "deleted")
                              <th>পূর্বের প্রোপারটিস</th>
                              @endif
                            @endif
                            <th>ইউজার</th>
                            <th>তৈরির সময়</th>
                            <th>আপডেটের সময়</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php $count = 1; ?>
                            @foreach($activitys as $activity)
                            <tr>
                                <td><span>{{$activity->description}}</span></td>
                                <td><span>{{$activity->subject_type}}</span></td>
                                <td><span>
                                @foreach(json_decode($activity->properties, true) as $key => $value)
                                   @if($key != "old")
                                        @foreach($value as $key2 => $value2)
                                                    <b>{{ $key2 }}</b> : {{ $value2 }} <br />
                                        @endforeach
                                    @endif
                                @endforeach                             
                                </span></td>

                                @if($action_type != "created")
                                 @if($action_type != "deleted")
                                <td><span>
                                @if($activity->description =="updated") 
                                    @foreach(json_decode($activity->properties, true) as $key => $value)
                                        @if($key == "old")
                                                @foreach($value as $key2 => $value2)
                                                            <b>{{ $key2 }}</b> : {{ $value2 }} <br />
                                                @endforeach
                                        @endif
                                     @endforeach                      
                                @endif
                                </span></td>
                                 @endif
                                @endif

                                <td><span>@if($activity->user) {{$activity->user->name}} @else anonymous @endif</span></td>
                                <td><span>{{$activity->created_at}}</span></td>
                                <td><span>{{$activity->updated_at}}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(count($activitys) > 0)
                    <div class="print_hide pt-3">
                        {!! $activitys->appends(\Request::except('page'))->render() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
