<table id="table_id" class="ml-4" cellspacing="0" width="100%">

<tbody>

    @foreach($userEvents as $userEvent)

    <tr>          
         <td>ইউজার এর নাম</td>
         <td>:</td>
         <td><span>{{$userEvent->name}}</span></td>

         <td width="10%"></td>
         <td>ইউজার এর স্বাক্ষর</td>
        <td><strong>:</strong> </td>
        <td><input class="upload" type="file" name="signature_file" id="signature_file" accept="image/jpeg, image/jpg, image/png, image/gif, image/svg">              
        </td>
    </tr>
    <tr>
        <td>ইউজার টাইপ </td>
         <td>:</td>
         <td><span>{{$userEvent->user_type}}</span></td>
         <td colspan="3"></td>
         <td rowspan="2">
            @if($userEvent->signature_file)
            <img src="{{ asset('images/user_signature_file/thumb/'.$userEvent->signature_file) }}" alt="Signature image" title="Signature image" height="30px" width="30px">
            @endif
        </td>       
    </tr>
    <tr>
         <td>একটিভ</td>
         <td>:</td>
         <td><input type="checkbox" id="active_status" name="active_status"
             {{ $userEvent->active_status ? 'checked' : '' }} value="{{$userEvent->active_status}}">
        </td>

        <td colspan="4"></td>
    </tr>  
    @if($isSailoEdit) 
    <tr>
         <td valign="top">অনুমোদিত বিভাগ নির্বাচন করুন</td>
         <td>:</td>
         <td>
            <select id="AllowedDivisionList" name="AllowedDivisionList[]" required multiple class="form-control" size="8">
                    @foreach($divisions as $division)
                        <option value="{{ $division->divid}}" {{ (in_array($division->divid, $AllowedDivisionList)) ? 'selected' : '' }}>{{ $division->divname}}</option>
                    @endforeach
            </select>
        </td>

        <td colspan="4"></td>
    </tr>   
    @endif 
    </form>
    @break
    @endforeach
</tbody>
</table>


</div>

<div class="card-body">
<table id="table_id" class="table table-bordered" cellspacing="0" width="100%">

<thead>
    <tr>

         <th>ইভেন্ট</th>
         <th>ভিউ</th>
         <th>অ্যাড </th>
         <th>ডিলিট</th>
         <th>এডিট</th>
         <th>এপ্র্যুভ</th>
    </tr>
</thead>

<tbody>

    @foreach($userEvents as $userEvent)

    <tr>

      <input type="hidden" name="id[]" value="{{$userEvent->id}}"/>

        <td><span>{{$userEvent->event_name}}</span></td>
        <td><input type="checkbox" id="view_per" name="view_per[]"
        {{ $userEvent->view_per ? 'checked' : '' }}  value="{{$userEvent->id}}"></td>
        <td><input type="checkbox" id="add_per" name="add_per[]"
        {{ $userEvent->add_per ? 'checked' : '' }} value="{{$userEvent->id}}"></td>
        <td><input type="checkbox" id="delete_per" name="delete_per[]"
         {{ $userEvent->delete_per ? 'checked' : '' }} value="{{$userEvent->id}}"></td>
        <td><input type="checkbox" id="edit_per" name="edit_per[]"
        {{ $userEvent->edit_per ? 'checked' : '' }} value="{{$userEvent->id}}"></td>
        <td><input type="checkbox" id="apr_per" name="apr_per[]"
        {{ $userEvent->apr_per ? 'checked' : '' }} value="{{$userEvent->id}}"></td>
    </form>
    </tr>
    @endforeach
</tbody>
</table>
