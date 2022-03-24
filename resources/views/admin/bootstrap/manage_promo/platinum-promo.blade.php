@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="d-flex">
                <h4 class="card-title">Manage Promo</h4>              
            </div>                        
            <div class="table-responsive">
                <table class="table table-striped" style="table-layout: fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Url</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($promo))
                        @foreach($promo as $p)
                        <tr>
                            <td>{{$p->id}}</td>
                            <td>
                              <img style="border-radius: 0;" src="/{{$p->image}}"/>
                            </td>
                            <td><a href="{{$p->url}}" target="_blank"><u>{{$p->url}}</u></a></td>                           
                            <td class="actions">
                                @if($p->status == 1    || $p->status == 0)
                                <a href="{{route('promoApproval',$p->id)}}" class="btn btn-primary">Approve</a>                                   
                                <a href="javascript:void(0);" rel="{{$p->id}}" class="btn btn-success rejectPromo">Reject</a>
                                @elseif($p->status == 2)
                                <a href="javascript:void(0)" class="text-primary mr-2">Approved</a>                                   
                                <a href="javascript:void(0);" rel="{{$p->id}}" class="btn btn-success rejectPromo">Reject</a>
                                @elseif($p->status == 3)
                                <a href="{{route('promoApproval',$p->id)}}" class="btn btn-primary">Approve</a>
                                <a href="javascript:void(0)" class="text-danger ml-2">Rejected</a>
                                @endif
                                <div style="padding: 10px;">
                                    <a href="javascript:void(0)" class="btn btn-danger" style="font-size:10px; float:right;" onclick="deletePromo('{{$p->id}}')">Delete</a>
                                </div>
                            </td>
                        </tr>  
                        @endforeach
                        @endif
                    </tbody>
                </table>
                
                <form action="{{route('admin.bootstrap.manage_promo.platinum-promo')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <br/><br/>
                    <h5>Add New Platinum Promo</h5>
                    <hr/>
                    Destination <input type="text" name="url" placeholder="https://www.google.com" required="true"><br/>
                    <input type="file" name="image" required="true">
                    
                    <button type="submit" class="btn btn-success removeBorder py-2">Add New</button>
                </form>                               
            </div>          
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container-fluid clearfix">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019. All rights reserved.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i class="mdi mdi-heart text-danger"></i></span>
    </div>
</footer>
<div class="modal fade" id="rejectPromoModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered" role="document">
        <div class="modal-content">           
            <div class="modal-header" style=" border-bottom: 1px solid #ccc;">
                <div class="ml-auto border-bottom">
                    <img src="/asset/connect_eo.png"  style="width: 100px;">
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body pt-4">     
                <form action="{{route('commentForRejectPromo')}}" method="post" class="">
                    @csrf
                    <input type="hidden" name="promo_id" id="promoId">
                    <div class="form-group focused">
                        <label class="form-control-label text-dark mb-1" for="input-username">Comment</label>
                        <textarea type="text" class="form-control form-control-alternative border" rows="10" id="input-username" name="comment" style=" border: 1px solid #333!important;" required=""></textarea>
                    </div>    
                    <div class="text-center">
                        <button type="submit" class="btn btn-success w-50 removeBorder py-2">Submit</button>
                    </div>   
                </form>  
            </div>         
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>

    function deletePromo(id) {
        var r = confirm("Delete Platinum Promo?");
        if (r == true) {
             $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "/admin/promo",
                data: {method: 'delete', id: id},
                dataType: 'json',
                context: this,
                success: function (data) {
                    if (data.status == 'success') {
                        location.reload();
                    }
                }
            });
        }
    }

    $(document).on('click', '.rejectPromo', function () {
        var id = $(this).attr('rel');
        $('#promoId').val(id);
        $('#rejectPromoModal').modal('show');
    });
</script>
@endpush
