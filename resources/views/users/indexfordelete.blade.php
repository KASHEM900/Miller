@extends('users.layout')

@section('contentbody')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl">ডিলিট ইউজার</div>
                <div class="p-3 flex justify-between">

                    <form action="{{ route('filterdeleteindex') }}" method="POST" enctype="multipart/form-data">
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

                                        <td> জেলা</td>
                                        <td>:</td>
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
                    @livewire('userdelete',['users' => $users])
    
                   
                </div>

            </div>
                     
        </div>
    </div>
</div>


@endsection
