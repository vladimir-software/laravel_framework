@if($users->isEmpty())
<tr class='text-center' style='margin-top: 1rem'>
    <td colspan='8' style='font-size:20px;color:#ff7c00'>No result found.</td>
</tr>
@endif

@if(isset($users) && $users != '')
@foreach($users as $key=> $user)
@php $count = App\Models\UserSurvey::where('user_id',$user['id'])->count();  @endphp
<tr>
    <td>{{$user['id']}}</td>
    <td>{{isset($user['fullname'])?$user['fullname']:''}}</td>
    <td>{{$user['email']}}</td>
    <td>{{isset($user['mobile_number'])?$user['mobile_number']:''}}</td>
    <td>
        @if($user['account_type_id'] == 1)  <span class="badge badge-success">Admin</span> @endif
        @if($user['account_type_id'] == 3)  <span class="badge badge-success">Super Admin</span> @endif
    </td>
    <td>
        <img src=" {{(($user['profile_pic'])?asset($user['profile_pic']):asset('asset/noimage_person.png'))}}" width="40px" height="auto">
    </td>
    <td>{{date('m-d-Y', strtotime($user['created_at']))}}</td>
    <td class="actions">
        <a href="javascript:void(0);" user-id="{{$user['token']}}" class="removeUser">remove</a>
    </td>
</tr>
@endforeach
@endif
