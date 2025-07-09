@extends('users.layout')

@section('contentbody')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl">ইউজারের পারমিশন</div>
                <div class="p-3 flex justify-between">

                    <form action="{{ route('userpermissionlist') }}">
                        @csrf
                        <div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>বিভাগ</td>

                                        <td>:</td>

                                        <td>
                                            <select name="division_id" id="division_id" class="form-control" size="1" title="অনুগ্রহ করে  বিভাগ বাছাই করুন" required="">
                                                    <option value="">বিভাগ</option>
                                                    @foreach($divisions as $division)
                                                    <option value="{{ $division->divid}}" {{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td> জেলা</td><td>:</td>
{{-- 
                                        <td><select name="district_id" id="district_id" class="form-control" size="1" title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                            <option value="">জেলা</option>
                                        </select></td> --}}
                                        <td><select name="district_id" id="district_id"
                                            class="form-control" size="1"
                                            title="অনুগ্রহ করে  জেলা বাছাই করুন">
                                            <option value="">জেলা</option>
                                            @foreach($districts as $district)
                                                <option value="{{ $district->distid}}"
                                                {{ ( $district->distid == $district_id) ? 'selected' : '' }}>{{ $district->distname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td>ইভেন্ট </td>

                                        <td>:</td>

                                        <td>
                                            <select name="event_id" id="event_id" class="form-control" title="অনুগ্রহ করে ইভেন্ট বাছাই করুন" required="">
                                                <option value="">ইভেন্ট</option>
                                                @foreach($events as $event)
                                                    <option value="{{ $event->event_id}}" {{ ( $event->event_id == $event_id) ? 'selected' : '' }}>{{ $event->event_name}}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td style="padding-left:10px"><input type="submit" class="btn btn-primary"  name="userpermissionlist" id="userpermissionlist" value="ফলাফল"></td>
                                    
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                    
                    <span style="color:red"> বিভাগ, জেলা ও ইভেন্ট বাছাই করতে হবে</span> 
                    
                </div>   
                
                <div class="card-body">
                   <table id="table_id" class="table table-bordered" cellspacing="0" width="100%">
    
                        <thead>
                            <tr>
                                <th>ইউজার এর নাম</th>
                                <th>উপজেলা</th>
                                <th>ইউজার টাইপ </th>
                                <th>ইভেন্ট </th>
                                <th>ভিউ</th>
                                <th>অ্যাড </th>
                                <th>ডিলিট</th>
                                <th>এডিট</th>
                                <th>এপ্র্যুভ</th>
                                <th>একটিভ</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($userEvents as $userEvent)
                                @livewire('userpermissionlist', 
                                ['usereventid' => $userEvent->id,
                                'event_id' => $userEvent->event_id,
                                'name' => $userEvent->name,
                                'upazillaname' => $userEvent->upazillaname ,
                                'user_type' => $userEvent->user_type,
                                'event_name' => $userEvent->event_name,
                                'view_per' => $userEvent->view_per,
                                'add_per' => $userEvent->add_per,
                                'delete_per' => $userEvent->delete_per,
                                'edit_per' => $userEvent->edit_per,
                                'apr_per' => $userEvent->apr_per,
                                'active_status' => $userEvent->active_status
                                ])
                            @endforeach
                        </tbody>
                    </table>
                    <div class="print_hide pt-3">
                        {!! $userEvents->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>

            </div>               
                     
        </div>
    </div>
</div>

@endsection
