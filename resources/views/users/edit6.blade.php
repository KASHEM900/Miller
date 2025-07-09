@extends('users.layout')

@section('contentbody')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl">সাইলো ইউজারের তথ্য হালনাগাদ</div>
                <div class="p-3 flex justify-between">

                    <form action="{{ route('editsailolist') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <table>
                                <tbody>
                                    <tr>
                                                                               

                                        <td> ইউজার</td><td>:</td>
                                        <td><select name="user_id" id="user_id" class="form-control" 
                                        size="1" title="অনুগ্রহ করে ইউজার বাছাই করুন" required="">

                                            <option value="">ইউজার</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id}}"
                                                {{ ( $user->id == $user_id) ? 'selected' : '' }}>
                                                {{ $user->name}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td style="padding-left:10px"><input type="submit" class="btn btn-primary"  name="edituserlist" id="edituserlist" value="ফলাফল"></td>
                                    
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                    
                    <span style="color:red"> ইউজার বাছাই করতে হবে</span> 
                    
                </div>  
                
                @if(!empty($user_id))
                <form method="post" action="{{route('users.update6',$user_id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('patch') 

                @endif

                <div>
                     @livewire('userdivisionedit',['userEvents' => $userEvents, 'divisions'=>$divisions, 'allowedDivisionList'=>$allowedDivisionList, 'isSailoEdit'=>TRUE])
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
