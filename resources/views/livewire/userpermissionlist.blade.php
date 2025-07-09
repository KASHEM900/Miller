
<tr>   
    
    <td><span>{{$name}}</span></td>
    <td><span>{{$upazillaname}}</span></td>
    <td><span>{{$user_type}}</span></td>
    <td><span>{{$event_name}}</span></td>
    <td><input type="checkbox" wire:model="view_per" id="view_per" name="view_per" {{ $view_per ? 'checked' : '' }} value="1"></td>
    <td><input type="checkbox" wire:model="add_per" id="add_per" name="add_per" {{ $add_per ? 'checked' : '' }} value="1"></td>
    <td><input type="checkbox" wire:model="delete_per" id="delete_per" name="delete_per" {{ $delete_per ? 'checked' : '' }} value="1"></td>
    <td><input type="checkbox" wire:model="edit_per" id="edit_per" name="edit_per" {{ $edit_per ? 'checked' : '' }} value="1"></td>
    <td><input type="checkbox" wire:model="apr_per" id="apr_per" name="apr_per" {{ $apr_per ? 'checked' : '' }} value="1"></td>
    <td><input type="checkbox" wire:model="active_status" id="active_status" name="active_status" {{ $active_status ? 'checked' : '' }} value="{{$active_status}}"></td>
    <td>
        <button  class="btn2 btn-primary" wire:click="updateUserPerm()" title="Add Todo" >GRANT</button>
        {{ $statusmessage }}
    </td>

</tr>