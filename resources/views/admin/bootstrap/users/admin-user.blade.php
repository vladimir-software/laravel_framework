@extends('admin.bootstrap.layouts.app')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4 class="card-title">Manage Admin Users</h4>
                <form class="form-inline ml-auto d-none d-md-block" action="javascript:void(0);">
                    <div class="input-group mb-3" style="border-bottom:1px solid #ff7c00;width: 249px;">
                        <input type="text"  class="form-control searchUserByEmail border-0" id="staticEmail2" placeholder="search...">
                        <div class="input-group-append ">
                            <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
                        </div>
                    </div>                  
                </form>
            </div>                         
            <div>              
                <form class="form-inline ml-auto d-md-none" action="javascript:void(0);">
                    <div class="input-group mb-3" style="border-bottom:1px solid #ccc;width: 100%;">
                        <input type="text"  class="form-control searchUserByEmail border-0" id="staticEmail2" placeholder="search..">
                        <div class="input-group-append ">
                            <span class="input-group-text border-0"><i class="fas fa-search"></i></span>
                        </div>
                    </div>                  
                </form>
            </div>                         
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Email Address</th>
                            <th>Contact #</th>
                            <th>Account Type</th>
                            <th>Image</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="appendSearchedUser">
                        @foreach($users as $key=> $user)
                        @php $count = App\Models\UserSurvey::where('user_id',$user['id'])->count();  @endphp
                        <tr>
                            <td>{{$user['id']}}</td>
                            <td>{{isset($user['fullname'])?$user['fullname']:''}}</td>
                            <td>{{$user['email']}}</td>
                            <td>{{isset($user['mobile_number'])?$user['mobile_number']:''}}</td>
                            <td>@if($user['account_type_id'] == 2)  <span class="badge badge-success">Applicant</span> @endif</td>
                            <td>
                                <img src=" {{(($user['profile_pic'])?asset($user['profile_pic']):asset('asset/noimage_person.png'))}}" width="40px" height="auto">
                            </td>
                            <td>{{date('m-d-Y', strtotime($user['created_at']))}}</td>
                            <td class="actions" style="font-size: 11px;">
                                <a href="javascript:void(0);" user-id="{{$user['token']}}" class="removeUser">
                                    <i class="fa fa-times" aria-hidden="true"></i> remove
                                </a><br/><br/>
                                <a href="javascript:void(0);" user-id="{{$user['token']}}" class="changePassword">
                                    <i class="fa fa-key" aria-hidden="true"></i> password
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>               
            </div>
            <div class="mt-4 float-right hideForSearchedUser">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    ::placeholder, .fa-search{
        color:#333!important;   
        font-size:14px;
    }
    ::placeholder{
        font-size:14px;
    }   
    .badge,.badge-danger {
        border-radius: 0.25rem;
        font-size: 0.65rem;
        font-weight: initial;
        line-height: 1;
        padding: 0.2rem 0.3rem;
        font-family: "Poppins", sans-serif;
        font-weight: 600;      
    }
    badge{
        background: #ff7c00!important;
        border: 1px solid #ff7c00;
    }
    .badge-approve{
        background: #03a9f3!important;
        border: 1px solid #03a9f3;
        color: white;
    }
    .badge-danger{
        background:red!important;
        border: 1px solid red;
        color: white;
    }
    .actions {
        font-size: 10px;
    }

</style>

<script>
    $(document).on('keyup paste', '.searchUserByEmail', function (e) {
        var search = $(this).val();
        if (e.keyCode == 8) {
            if (search == '') {
                $('.hideForSearchedUser').show();
            }
        }
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/searchAdminUserByName",
            data: {search: search},
            dataType: 'html',
            context: this,
            success: function (data)
            {
                $('.appendSearchedUser').html('');
                $('.appendSearchedUser').html(data);
                if (search != '') {
                    $('.hideForSearchedUser').hide();
                }
            }
        });
    });

    /////////////////// update password
    $(document).on("click", ".changePassword", function () {
        Swal.mixin({
          input: 'password',
          confirmButtonText: 'Update',
          showCancelButton: true,
        }).queue([
          {
            title: 'Update Password',
            text: 'Enter new password for admin user'
          }
        ]).then((result) => {
          if (result.value) {
            var userId = $(this).attr('user-id');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                url: "/admin/update-password",
                data: {user_token: userId, password: result.value[0]},
                dataType: 'json',
                context: this,
                success: function (data) {
                    if (data.status == 'success') {
                        const answers = JSON.stringify(result.value)
                        Swal.fire({
                          title: 'Password updated for user',
                          confirmButtonText: 'OK'
                        })
                    }
                }
            });
          }
        })
        return false;
    });

    /////////////////// delete user
    $(document).on("click", ".removeUser", function () {
        var userId = $(this).attr('user-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "/admin/delete-user",
                    data: {user_token: userId},
                    dataType: 'json',
                    context: this,
                    success: function (data) {
                        if (data.status == 'success') {
                            $(this).parents('tr').remove();
                            Swal.fire(
                                'Password Updated',
                                'Admin User now has a new password.',
                                'success'
                            )
                        }
                    }
                });

            }
        })
        return false;
    });
</script>
@endpush
