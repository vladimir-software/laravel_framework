@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4 class="card-title">Subscriptions</h4>

            </div>                         
            <div class="">              
                <form class="form-inline ml-auto d-md-none" action="javascript:void(0);">
                    <div class="input-group mb-3" style="border-bottom:1px solid #ccc;width: 100%;">
                        <input type="text" class="form-control searchUserByEmail border-0" id="staticEmail2" placeholder="search..">
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
                            <th>Full Name</th>
                            <th>Amount</th>
                            <th>Subscription type</th>
                            <th>Purchased at</th>                            
                        </tr>
                    </thead>
                    <tbody class="">
                        @if(!empty($userSubscription))
                        @foreach($userSubscription as $subs)
                        <tr> 
                            <td>{{isset($subs->fullname)?$subs->fullname:'Unknown'}}</td>
                            <td>{{isset($subs->userPayments->amount)?'$'.($subs->userPayments->amount/100):'---'}}</td>
                            <td>
                                @if(isset($subs->subscription_type) && $subs->subscription_type ==1)
                                BASIC/FREE
                                @elseif(isset($subs->subscription_type) && $subs->subscription_type ==2)
                                PREMIUM
                                @else
                                PLATINUM
                                @endif
                            </td>
                            <td>
                                {{isset($subs->userPayments->created_at)?date('d-m-Y', strtotime($subs->userPayments->created_at)):''}}
                            </td>                         
                        </tr>  
                        @endforeach
                        @endif
                    </tbody>
                </table>               
            </div>
            <div class="mt-4 float-right hideForSearchedUser">
                {{$userSubscription->links()}}
            </div>
        </div>
    </div>
</div>
@endsection