@if(!$users->isEmpty())
    @foreach($users as $key=>$value)
        <tr>
            <td>
                <h2 class="table-avatar">
                    <span class="avatar"><img src="{{$value->imagefilepath}}" alt=""></span>
                    <a>{{$value->fullname}}</a>
                </h2>
            </td>
            <td>
                {{$value->email}}
            </td>
            <td>
                {{$value->designationname}}
            </td>
            <td>
                {!!$value->statustext!!}
            </td>
            <td class="text-right">
                <div class="dropdown dropdown-action">
                    <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ url_admin('users/edit/'.$value->user_id) }}"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                        <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="deleteEntity({{ $value->user_id }});"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="5" class="text-center">
            <h4 class="m-0">No users found!</h4>
        </td>
    </tr>
@endif
<tr id="ajaxpagingdata">
    <td>
        {!! $users->render() !!}
    </td>
</tr>