@extends('users.layout')

@section('contentbody')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl">CSD/LSD ইউজারের তথ্য হালনাগাদ</div>
                <div class="p-3 flex justify-between">

                    <form action="{{ route('editlsdlist') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <table>
                                <tbody>
                                    <tr>
                                        <td>বিভাগ</td>

                                        <td>:</td>

                                        <td>
                                            <select name="division_id" id="division_id5" class="form-control" size="1"
                                             title="অনুগ্রহ করে  বিভাগ বাছাই করুন" required="">
                                                    <option value="">বিভাগ</option>
                                                    @foreach($divisions as $division)
                                                    <option value="{{ $division->divid}}"
                                                     {{ ( $division->divid == $division_id) ? 'selected' : '' }}>{{ $division->divname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        
                                        <td> জেলা</td><td>:</td>
                                        <td><select name="district_id" id="district_id5"
                                            class="form-control" size="1"
                                            title="অনুগ্রহ করে জেলা বাছাই করুন" required="">
                                            <option value="">জেলা</option>
                                            @foreach($districts as $district)

                                                <option value="{{ $district->distid}}"

                                                {{ ( $district->distid == $district_id) ? 'selected' : '' }}>

                                                {{ $district->distname}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                     <td> উপজেলা</td><td>:</td>
                                      <td><select name="upazila_id" id="mill_upazila_id5"
                                          class="form-control" size="1"
                                          title="অনুগ্রহ করে উপজেলা বাছাই করুন" required="">
                                          <option value="">উপজেলা</option>
                                          @foreach($upazillas as $upazilla)
                                           <option value="{{$upazilla->upazillaid}}" 
                                           {{ ( $upazilla->upazillaid == $upazila_id) ? 'selected' : '' }}>
                                            {{$upazilla->upazillaname}}</option>
                                             @endforeach
                                          </select>
                                      </td>

                                        <td> ইউজার</td><td>:</td>
                                        <td><select name="user_id" id="user_id5" class="form-control" 
                                        size="1" title="অনুগ্রহ করে ইউজার বাছাই করুন" required="">

                                            <option value="">ইউজার</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id}}"
                                                {{ ( $user->id == $user_id) ? 'selected' : '' }}>
                                                {{ $user->name}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td style="padding-left:10px"><input type="submit" class="btn btn-primary"  name="editdisupzuserlist" id="edieditdisupzuserlisttuserlist" value="ফলাফল"></td>
                                    
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                    
                    <span style="color:red"> বিভাগ ও ইউজার বাছাই করতে হবে</span> 
                    
                </div>   

                @if(!empty($user_id))
                <form method="post" action="{{route('users.updatelsduser',$user_id)}}"  enctype="multipart/form-data">
                    @csrf
                    @method('patch') 

                @endif

                <div>
                     @livewire('userdivisionedit',['userEvents' => $userEvents])
                </div>

                <div class="pl-3 pb-3">
                    <input type="submit" value="আপডেট" class="btn btn-primary" />
                 </div>

                 </form>

            </div>                                   
        </div>
    </div>
</div>

@endsection
