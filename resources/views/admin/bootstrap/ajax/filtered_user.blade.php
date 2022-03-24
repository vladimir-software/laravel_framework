@if($users->isEmpty())
<tr class='text-center' style='margin-top: 1rem'>
    <td colspan='8' style='font-size:20px;color:#ff7c00'>No result found.</td>
</tr>
@endif

@if(isset($users) && $users != '')
@foreach($users as $key=> $user)
@php $count = App\Models\UserSurvey::where('user_id',$user['id'])->orWhere('skip', 1)->whereNotIn('answer', ['welcome', 'complete survey'])->count();  @endphp
<tr>
    <td>{{$user['id']}}</td>
    <td>{{isset($user['fullname'])?$user['fullname']:''}}</td>
    <td>{{$user['email']}}</td>
    <td>{{isset($user['mobile_number'])?$user['mobile_number']:''}}</td>
    <td>@if($user['account_type_id'] == 2)  <span class="badge badge-success">Applicant</span> @endif</td>
    <td></td>
    <td><a href="{{route('admin.bootstrap.users.user_survey',$user['token'])}}" >view (<span class="text-primary">{{$count}}</span>)</a></td>
    <td class="actions">
        <a href="{{route('users.edit-user1',$user['id'])}}">edit</a> |                                  
        <a href="javascript:void(0);" user-id="{{$user['token']}}" class="removeUser">delete</a>
    </td>
</tr>
@endforeach
@endif
