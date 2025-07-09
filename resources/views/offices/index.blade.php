@extends('configuration.layout')

@section('contentbody')
<div class="card">
    <div class="card-header flex justify-between">
        <span class="text-2xl">অফিস</span>
        <a href="{{route('offices.create')}}" class="btn btn-secondary">
            নতুন এন্ট্রি
        </a>
    </div>

    <form action="{{ route('filterOffices') }} " method="POST" >
     @csrf
     <div class="p-4">
         <table>
             <tbody>
                 <tr>
                    <td>অফিস টাইপ</td>
                    <td>:</td>
                    <td>
                    <select name="office_type_id" id="office_type_id" class="form-control" size="1"
                     title="অনুগ্রহ করে অফিস টাইপ বাছাই করুন">
                     <option value="">অফিস টাইপ</option>
                     @foreach($office_types as $office_type)
                      <option value="{{$office_type->office_type_id}}" 
                      {{ ( $office_type->office_type_id == $office_type_id) ? 'selected' : '' }}>
                      {{ $office_type->type_name}}</option>
                     @endforeach
                    </select>
   
                    </td>

                     <td>বিভাগ</td>
                     <td>:</td>
                     <td>
                         <select name="division_id" id="division_id" class="form-control" size="1"
                         title="অনুগ্রহ করে  বিভাগ বাছাই করুন">
                                 <option value="">বিভাগ</option>
                                 @foreach($divisions as $division)
                                 <option value="{{ $division->divid}}" 
                                 {{ ( $division->divid == $division_id) ? 'selected' : '' }}>
                                 {{ $division->divname}}</option>
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
                     <td  style="padding-left:10px"><input type="submit" class="btn btn-primary" name="filter" id="listOfoffice" value="ফলাফল"></td>
                 </tr>
             </tbody>
         </table>
     </div>
 </form>

    <div class="card-body">
        <table id="table_id" class="table table-bordered" cellspacing="0" cellpadding="5" width="100%">

            <thead>
                <tr>
                     <th width="200px">নাম @sortablelink('office_name', '')</th>
                     <th width="200px">ঠিকানা @sortablelink('office_address', '')</th>
                     <th>অফিস টাইপ @sortablelink('office_type.type_name', '')</th>
                     <th>উপজেলা @sortablelink('upazilla.upazillaname', '')</th>
                     <th>জেলা @sortablelink('district.distname', '')</th>
                     <th>বিভাগ @sortablelink('division.divname', '')</th>
                     <th>অ্যাকশন</th>
                </tr>
            </thead>

            <tbody>
                @foreach($offices as $office)
                <tr>
                    <td><span>{{$office->office_name}}</span></td>
                    <td><span>{{$office->office_address}}</span></td>
                    <td><span>{{ ($office->office_type_id>0)? $office->office_type->type_name : ''}}</span></td>
                    <td><span>{{ ($office->upazilla_id>0)? $office->upazilla->upazillaname : '' }}</span></td>
                    <td><span>{{ ($office->district_id>0)? $office->district->distname : ''}}</span></td>
                    <td><span>{{ ($office->division_id>0)? $office->division->divname : ''}}</span></td>
                    <td>   
                        <a href="{{route('offices.edit',$office->office_id)}}" class="btn2 btn-primary">
                        এডিট</a>
                                
                        <span class="btn2 btn-danger"  
                                onclick="event.preventDefault();
                                    if(confirm('Are you really want to delete?')){
                                        document.getElementById('form-delete-{{$office->office_id}}')
                                        .submit()
                                    }">ডিলিট</span>
                        <form style="display:none" id="{{'form-delete-'.$office->office_id}}" method="post" action="{{route('offices.destroy',$office->office_id)}}">
                            @csrf
                            @method('delete')
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
    </div>
</div>
@endsection

