@extends('layouts.elements.app')
@section('content')

<section class="faq-section">
    <div class="container">
        <div class="row ">
            <!-- ***** FAQ Start ***** -->
            <div class="col-md-6 offset-md-3">
                <div class="faq-title text-center">
                    <h2>Video Library</h2>
                </div>
            </div>
            @if(Auth::user()->id==1)
            <button type="button" class="btn btn-dark" style="height: 50px;
            width: 125px;" data-toggle="modal" data-target="#exampleModal">Add</button>
              <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Upload Video data</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('addvideo')}}" id="basic-form" name="basic-form" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class="text-left mb-0" style="color:#000">Title</label>
                                <input type="text" class="form-control"  name="title" id="exampleFormControlInput1"  placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput3" class="text-left mb-0" style="color:#000">Video</label>
                                <input type="file" class="form-control"  name="video" id="exampleFormControlInput3" placeholder="">
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlInput2" class="text-left mb-0" style="color:#000">Description</label>
                                <textarea type="text" class="form-control"  name="description" id="exampleFormControlInput2"  placeholder=""></textarea>
                            </div>
                            <button type="submit" id="mysubmit" class="btn-sm btn btn-success my-3 py-1 w-100">Add</button>
                        </form>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              @endif
            <div class="col-md-9 mx-auto">
                <div class="faq" id="accordion" style="padding: 10px;">
                    <div class="card m-0 w-100">
                        <div class="card-header" >

                            {{-- <i class="fas fa-play"></i> --}}
                            @if(count($videodata)>=1)

                            @foreach($videodata as $data)
                            <div class="row">
                             <div class="col-2"></div>
                            <div class="col-6">
                                <video controlsList="nodownload" style="width: 374px;
                                height: 220px;" controls="controls" class="video-stream" x-webkit-airplay="allow" data-youtube-id="N9oxmRT2YWw" src="{{ asset('asset/user_profile').'/'.$data->video }}"></video>
                            </div>

                            <div class="col-4">
                                &nbsp; <h6 style="color: #ff7c00;font-family: sans-serif;">{{$data->title}}</h6>
                                {{$data->description}}
                                <br/><br>
                                @if(Auth::user()->id==1)
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$data->id}}">Edit
                                </button>&nbsp;
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#removeModal{{$data->id}}">Remove</button><br/>

                                <div class="modal" id="removeModal{{$data->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Video data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>

                                          <form action="{{route('removevideo')}}" id="basic-formnew" name="basic-formnew" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$data->id}}">
                                            <input type="hidden" name="filename" value="{{$data->video}}">
                                          <div class="modal-body">
                                              <h2><center>Are you sure you want to remove this video?</center></h2>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Remove</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          </div>
                                          </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal" id="myModal{{$data->id}}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Video data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                              <form action="{{route('updatevideo')}}" id="basic-formnew" name="basic-formnew" method="post" enctype="multipart/form-data">
                                                  @csrf

                                                  <input type="hidden" name="id" value="{{$data->id}}">
                                                  <div class="form-group">
                                                      <label for="exampleFormControlInput1" class="text-left mb-0" style="color:#000">Title</label>
                                                      <input type="text" class="form-control"  name="title" id="exampleFormControlInput1" value="{{$data->title}}"  placeholder="">
                                                  </div>

                                                  <div class="form-group">
                                                      <label for="exampleFormControlInput3" class="text-left mb-0" style="color:#000">Video</label>
                                                      <input type="file" class="form-control"  name="video" id="exampleFormControlInput3" placeholder="">
                                                  </div>
                                                  <input type="hidden" name="filename" value="{{$data->video}}">
                                                  <div class="form-group">
                                                      <label for="exampleFormControlInput2" class="text-left mb-0" style="color:#000">Description</label>
                                                      <textarea type="text" class="form-control"  name="description" id="exampleFormControlInput2"  placeholder="">{{$data->description}}</textarea>
                                                  </div>
                                                  <button type="submit" id="mysubmit" class="btn-sm btn btn-success my-3 py-1 w-100">Update</button>
                                              </form>

                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                  </div>

                                </div>

                                @endif
                            </div>

                        </div>
                        <br>
                                {!! $videodata->links() !!}
                            @endforeach
                            @else
                            No data found
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery/jquery-1.4.4.min.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.0/additional-methods.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than 30mb');
        $('form[id="basic-form"]').validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
        rules: {
          title: {
            required: true,
            minlength: 3,
          },
          video: {
            required: true,
            extension: 'ogg|ogv|avi|mov|wmv|flv|mp4',
            filesize: 30000000,
          },
          description: {
            required: true,
            minlength: 3,
          }
        },
        messages: {
            title: {
                required: 'Please enter title',
                minlength:'Minimum 3 length title is required'
          },
          video:{
              required: 'Upload video here',
              extension: 'Only ogg,ogv,aavi,mov,wmv,flv,mp4 formate allow'
          },
          description: {
                required: 'Please enter description',
                minlength:'Minimum 3 length description is required'
          }
        },
        submitHandler: function(form) {
            $("#mysubmit").prop("disabled", true);
          form.submit();
        }
});
    });






    $(document).ready(function() {
        $.validator.addMethod('filesize', function (value, element, param) {
    return this.optional(element) || (element.files[0].size <= param)
}, 'File size must be less than 30mb');
        $('form[id="basic-formnew"]').validate({
            errorClass: "my-error-class",
            validClass: "my-valid-class",
        rules: {
          title: {
            required: true,
            minlength: 3,
          },
          video: {
            extension: 'ogg|ogv|avi|mov|wmv|flv|mp4',
            filesize: 30000000,
          },
          description: {
            required: true,
            minlength: 3,
          }
        },
        messages: {
            title: {
                required: 'Please enter title',
                minlength:'Minimum 3 length title is required'
          },
          video:{
              extension: 'Only ogg,ogv,aavi,mov,wmv,flv,mp4 formate allow'
          },
          description: {
                required: 'Please enter description',
                minlength:'Minimum 3 length description is required'
          }
        },
        submitHandler: function(form) {
            $("#mysubmit").prop("disabled", true);
          form.submit();
        }
});
    });

</script>
@endpush

@push('styles')
<style>
    .my-error-class {
    color:#FF0000;  /* red */
}
.my-valid-class {
    color:#00CC00; /* green */
}
    .faq-section {
        background: #fdfdfd;
        min-height: 100vh;
        padding: 5vh 0 0;
    }
    .faq-title h2 {
        position: relative;
        margin-bottom: 45px;
        display: inline-block;
        font-weight: 600;
        line-height: 1;
    }
    .faq-title h2::before {
        content: "";
        position: absolute;
        width: 100%;
        height: 2px;
        background: #ff7c00;
        bottom: -25px;
        left: 0;
    }
    .faq-title p {
        padding: 0 190px;
        margin-bottom: 10px;
    }

    .faq {
        background: #FFFFFF;
        box-shadow: 0 2px 48px 0 rgba(0, 0, 0, 0.06);
        border-radius: 4px;
    }

    .faq .card {
        border: none;
        background: none;
        border-bottom: 1px dashed #CEE1F8;
        box-shadow: none!important;
    }

    .faq .card .card-header {
        padding: 0px;
        border: none;
        background: none;
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
    }

    .faq .card .card-header:hover {
        /*        background: rgba(233, 30, 99, 0.1);
                padding-left: 10px;*/
    }
    .faq .card .card-header .faq-title {
        width: 100%;
        text-align: left;

        padding: 0px;
        padding-left: 30px;
        padding-right: 30px;
        font-weight: 700;
        font-size: 15px;
        letter-spacing: 1px;
        color: #000000;
        text-decoration: none !important;
        -webkit-transition: all 0.3s ease 0s;
        -moz-transition: all 0.3s ease 0s;
        -o-transition: all 0.3s ease 0s;
        transition: all 0.3s ease 0s;
        cursor: pointer;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .faq .card .card-header .faq-title .badge {
        display: inline-block;
        width: 20px;
        height: 20px;
        line-height: 14px;
        float: left;
        -webkit-border-radius: 100px;
        -moz-border-radius: 100px;
        border-radius: 100px;
        text-align: center;
        background: #ff7c00;
        color: #fff;
        font-size: 12px;
        margin-right: 20px;
    }

    .faq .card .card-body {
        padding: 30px;
        padding-left: 35px;
        padding-bottom: 16px;
        font-weight: 400;
        font-size: 16px;
        color: #000000;
        line-height: 28px;
        letter-spacing: 1px;
        border-top: 1px solid #F3F8FF;
    }

    .faq .card .card-body p {
        margin-bottom: 14px;
    }

    @media (max-width: 991px) {
        .faq {
            margin-bottom: 30px;
        }
        .faq .card .card-header .faq-title {
            line-height: 26px;
            margin-top: 10px;
        }
    }
</style>
@endpush
