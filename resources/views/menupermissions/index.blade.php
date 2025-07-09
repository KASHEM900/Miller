@extends('configuration.layout')

@section('contentbody')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-2xl">ইউজারের ধরন অনুযায়ী পারমিশন</div>
                <div class="p-3 flex justify-between">

                    <form action="{{ route('menupermissions.index') }}" >
                        @csrf
                        <div>

                            <table cellpadding="2px" style="border:none!important">
                                <tbody>
                                    <tr style="border:none!important">
                                        <td style="border:none!important">ইউজারের ধরন</td>
                                        <td style="border:none!important">:</td>
                                        <td style="border:none!important">
                                            <select name="usertype_id" id="usertype_id" class="form-control" size="1" title="অনুগ্রহ করে ইউজারের ধরন বাছাই করুন" required="">
                                                    <option value=""> ইউজারের ধরন</option>
                                                    @forelse($userTypes as $userType)
                                                    <option value="{{ $userType->id}}" {{ ( $userType->id == $usertype_id) ? 'selected' : '' }}>{{ $userType->name}}</option>
                                                    @endforeach
                                            </select>
                                        </td>

                                        <td style="padding-left:10px;border:none!important"><input type="submit" name="filter" id="listOfckol" class="btn btn-primary" value="ফলাফল"></td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>

                    <span style="color:red"> ইউজারের ধরন বাছাই করতে হবে</span>

                </div>

                <div class="pl-4">
                <form action="{{ route('menupermissionsupdate') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <ul id="treeList" style="border: 1px solid lightgray; padding:10px; float: left;">
                        <li>
                        <?php $cur_pos = 0; ?>
                        @forelse($menuPermissions as $menuPermission)
                        @if(($cur_pos > 0 && !$menuPermission->menu->is_sub_menu && !$menuPermission->menu->is_sub_sub_menu)||($cur_pos == 2 && $menuPermission->menu->is_sub_menu))
                                </li>
                            </ul>
                            <?php $cur_pos--; ?>
                            @if($cur_pos > 0 && !$menuPermission->menu->is_sub_menu && !$menuPermission->menu->is_sub_sub_menu)
                                </li>
                            </ul>
                            <?php $cur_pos--; ?>
                            @endif
                        @elseif(($cur_pos == 0 && $menuPermission->menu->is_sub_menu)||($cur_pos == 1 && $menuPermission->menu->is_sub_sub_menu))
                            <ul>
                            <?php $cur_pos++; ?>
                        @else
                            </li>
                        @endif

                        <li>
                        <input type="hidden" id="id" name="id[]" value="{{$menuPermission->id}}"/>
                        <input type="checkbox" id="is_allow" name="is_allow[]" {{ $menuPermission ->is_allow ? 'checked' : '' }} value="{{$menuPermission ->id}}">
                        {{ $menuPermission->menu->name}}

                        @endforeach
                    </ul>

                    <div class="py-2">
                        @if($menuPermissions->count()>0)
                        <button  type="submit" class="btn btn-primary">জমা দিন</button>
                        @endif
                    </div>
                </form>
                </div>
            </div>


        </div>
    </div>
</div>

<style>
    ul {
        padding-left:20px;
    }
 </style>
 <script>
$('#treeList :checkbox').change(function (){
 $(this).siblings('ul').find(':checkbox').prop('checked', this.checked);
 if (this.checked) {
 $(this).parentsUntil('#treeList', 'ul').siblings(':checkbox').prop('checked', true);
    } else {
        $(this).parentsUntil('#treeList', 'ul').each(function(){
            var $this = $(this);
            var childSelected = $this.find(':checkbox:checked').length;
            if (!childSelected) {
                $this.prev(':checkbox').prop('checked', false);
            }
        });
    }
});

 </script>

@endsection
