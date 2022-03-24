@extends('layouts.elements.app')
@section('content')

<section class="faq-section">
    <div class="container">
        <div class="row ">
            <!-- ***** Pending Start ***** -->
            <div class="col-md-6 offset-md-3">
                <div class="faq-title text-center">
                    <h2>Your account is pending</h2>
                </div>
            </div>
            <div class="col-md-9 mx-auto">
                <div class="faq" id="accordion">

                    <div class="card m-0 w-100">
                        <div class="card-header" id="faqHeading">
                            <div class="mb-0">
                                <h5 class="faq-title" data-toggle="collapse"  data-aria-expanded="true" data-aria-controls="faqCollapse-1">
                                    Your application has been successfully submitted and you'll hear back from us soon.
                                </h5>
                            </div>
                        </div>
                        <div id="faqCollapse">
                            <div class="card-body">
                                <button type="submit" style="float:right;margin:20px;" class="btn surveyNextButton text-white completeSurveyForm " onclick="location.href='/FAQ';">View FAQs</button>
                            </div>
                        </div>
                    </div> 

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('styles')
<style>

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
