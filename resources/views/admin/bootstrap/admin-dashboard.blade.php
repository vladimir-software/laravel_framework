@extends('admin.bootstrap.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-md-center">
                    <i class="fa fa-envelope-open icon-lg text-success"></i>
                    <div class="ml-3">
                        <p class="mb-0">Total Messages</p>
                        <h6>{{$totalMessages}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-md-center">
                    <i class="fa fa-link icon-lg text-warning"></i>
                    <div class="ml-3">
                        <p class="mb-0">Total Connections</p>
                        <h6>{{$totalUserReviews}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-md-center">
                    <i class="fa fa-user icon-lg text-info"></i>
                    <div class="ml-3">
                        <p class="mb-0">Total Users</p>
                        <h6>{{$totalUsers}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="row">
    <div class="col-md-6 col-lg-6 grid-margin stretch-card">
        <div class="card pb-5 px-3">
            <div class="card-body">
                <div class="d-flex">
                    <h6 class="card-title cardTitleForChart">OVERVIEW {{date('Y')}}</h6>
                    <div class=" ml-auto ">
                        <input class="datepicker selectedYear"  value="{{date("Y")}}" style="border: none;border-bottom: 1px solid #000;width: 78px;text-align: center;">
                    </div>
                </div>
                <p>Subscription</p>
            </div>
            <div class="oldBarChartCanvas">
                <canvas id="bar-chart-comments" class="chart-canvas"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6 grid-margin stretch-card">
        <div class="card pb-5 px-3">
            <div class="card-body">
                <h6 class="card-title cardTitleForChart">OVERVIEW {{date('Y')}}</h6>
                <p>Users</p>          
            </div>
            <div class="chart oldLineCanvas">
                <canvas id="line-chart-comments" class="chart-canvas"></canvas> 
            </div> 
        </div>
    </div>
</div>
@endsection
@push('scripts')
<style> 
    .tab-solid-danger .nav-link.active{
        background: transparent!important;
        color: #000!important;
        border-bottom: 3px solid #03a9f3!important;
    }
</style>
<script>
    $(document).on('change', '.datepicker', function () {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/admin/dashboard",
            data: {value: $(this).val()},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $(".cardTitleForChart").html('OVERVIEW ' + data.year);
                    $("#line-chart-comments").remove();
                    $(".oldLineCanvas").html('<canvas id="line-chart-comments" class="chart-canvas"></canvas>');
                    var line = document.getElementById("line-chart-comments").getContext('2d');
                    var myBarChart = new Chart(line, {
                        type: 'line',
                        data: {
                            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                                    label: "Users",
                                    data: data.user_arr,
                                    prefix: "$",
                                    borderColor: '#ff7c00',
                                    backgroundColor: '#ff7c004f',
                                    borderWidth: 1,
                                    fill: true,
                                    hoverBackgroundColor: '#ff7c004f',
                                    hoverBorderColor: '#ff7c004f',
                                }]
                        }

                    });
                    $("#bar-chart-comments").remove();
                    $(".oldBarChartCanvas").html('<canvas id="bar-chart-comments" class="chart-canvas"></canvas>');
                    var bar = document.getElementById("bar-chart-comments").getContext('2d');
                    var myBarChart = new Chart(bar, {
                        type: 'bar',
                        prefix: "$",
                        data: {
                            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                            datasets: [{
                                    label: "Subscription",
                                    data: data.sum,
                                    borderColor: '#ff7c00',
                                    prefix: true,
                                    backgroundColor: '#ff7c004f',
                                    borderWidth: 1,
                                    fill: true,
                                    hoverBackgroundColor: '#ff7c004f',
                                    hoverBorderColor: '#ff7c004f'
                                }]
                        }
                    });
                }
            }
        });
    });
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        margin: 10,
        loop: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })


    var bar = document.getElementById("bar-chart-comments").getContext('2d');
    var myBarChart = new Chart(bar, {
        type: 'bar',
        prefix: "$",
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                    label: "Subscription",
                    data: [<?php echo $sum ?>],
                    borderColor: '#ff7c00',
                    prefix: true,
                    backgroundColor: '#ff7c004f',
                    borderWidth: 1,
                    fill: true,
                    hoverBackgroundColor: '#ff7c004f',
                    hoverBorderColor: '#ff7c004f'
                }]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            callback: function (e) {
                                return "$" + e
                            }
                        }
                    }]
            }
        },
        tooltips: {
            callbacks: {
                label: function (e, a) {
                    var t = a.datasets[e.datasetIndex].label || "",
                            o = e.yLabel,
                            n = "";
                    return 1 < a.datasets.length && (n += '<span class="popover-body-label mr-auto">' + t + "</span>"), n += '<span class="popover-body-value">$' + o + "k</span>"
                }
            }
        }
    });
    var line = document.getElementById("line-chart-comments").getContext('2d');
    var myBarChart = new Chart(line, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                    label: "Users",
                    data: [<?php echo $user_arr ?>],
                    prefix: "$",
                    borderColor: '#ff7c00',
                    backgroundColor: '#ff7c004f',
                    borderWidth: 1,
                    fill: true,
                    hoverBackgroundColor: '#ff7c004f',
                    hoverBorderColor: '#ff7c004f'
                }]
        }

    });

</script>
<style>

</style>
@endpush