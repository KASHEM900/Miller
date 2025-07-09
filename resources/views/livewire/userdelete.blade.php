<div>
    {{-- <button style="btn2 btn-primary" wire:click="deleteuser" onclick="return confirm('Are you sure?')">ডিলিট</button> --}}

    <table class="table table-bordered">
        <tr>
            <th>নাম</th>
            <th>ইউজার টাইপ</th>
            <th>ইমেইল</th>
            <th>বিভাগ</th>
            <th>জেলা</th>
            <th>উপজেলা</th>
            <th>একটিভ</th>
            <th>Operation</th>
        </tr>

        @forelse($users as $user)
        <tr>
            <td>{{ $user->name}}</td>
            <td>{{ $user->usertype->name}}</td>

            <td>{{ $user->email}}</td>
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

            @if($user->active_status == 1)
                <td><input type="checkbox" name="act4" disabled="" value="1" checked=""></td>
            @else
           <td><input type="checkbox" name="act4" disabled="" value="1"></td>
            @endif

            <td>
                {{-- <span class="fas fa-times text-red-400 p-2" wire:click="remove({{$loop->index}})" /> --}}
                
                @if($confirming===$user->id)
                    <button wire:click="remove({{$loop->index}})"
                        class="btn2 btn-danger">Sure?</button>
                @else  
                    <button wire:click="confirmDelete({{ $user->id }})" onclick="event.preventDefault();
                        alert('Are you really want to delete? If yes, close this and click on \'Sure?\' ')"
                        class="btn2 btn-primary">Delete</button>
                @endif
            </td>
        </tr>

        @endforeach                                 
    </table>

    @if(empty($user))
    <br><p style="color:red"> কিছুই পাওয়া যায়নি!</p> </div>
    @endif
</div>
