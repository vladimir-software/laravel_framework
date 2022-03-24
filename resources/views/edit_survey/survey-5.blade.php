@extends('layouts.elements.app')
@section('content')
<section class="sign-up-bg">
    <div id="map" class="mapForSurvey"></div>
    <div class="container">
        <!--WELCOME-->
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-10 col-12 mx-auto">
                <div class="card surveyBoxSize scale-up-center mt-2"> 
                    <div class="card-header text-center bg-white">
                        <img src="{{asset('asset/connect_eo.png')}}" style="width: 100px;">
                    </div>
                    <div>
                        <div class = "uk-margin">
                            @if ($message = Session::get('error'))
                            <div class="alert alert-danger text-center" role="alert">
                                {{$message}}
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-body" style="color:#333" id="page_6">
                        <form method="post" action="{{route('submitEditedSurvey5')}}" class="surveyForms">
                            @csrf
                            <input name="page_name" hidden="" value="page_6">
                            <p style="font-weight:600" class="surveyHeading">Where is your business located?</p>     
                            <div class="form-check mb-2 pl-0" style="display: flex;flex-direction: row;">
                                <div class="input-group flex-nowrap">
                                    <input id="pac-input" name="answer" type="text" value="{{$val['answer']}}" class="form-control border-right-0 searchLocation" placeholder="Search location here..." >
                                    <input type="hidden" value="{{$val['answer']}}" id="getLatLng" name="lat_lng">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-left-0" id="addon-wrapping"><i class="fas fa-search" style="font-size:16px!important"></i></span>
                                    </div>
                                </div>
                            </div>  

                            <div class=" mt-5 mb-3 text-center ">                                          
                                <button type="submit" class="btn btn-success text-white w-50" rel="">Submit</button>
                            </div>
                            <!--                            <div class="nextSurvey">
                                                            <a href="{{route('skipEditSurveyQuestion','page_6')}}" class="skipSurveyQuestion btn btn-sm btn-default" style='color:#666!important'>skip</a>
                                                            <input name="page_name" hidden="" value="page_6">
                                                            <button type="submit" class="btn surveyNextButton text-white float-right submitSurvey" rel="">Next</button>
                                                            <a href="javascript:history.back()" class="btn surveyBackButton text-white float-right submitSurvey mr-2" rel="">Back</a>
                                                        </div>  -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')

<style>
    html, body {
        height: 100%;
    }
    body {
        /* Location of the image */
        background-image: url('asset/sign-up.jpeg');

        /* Background image is centered vertically and horizontally at all times */
        background-position: center center;

        /* Background image doesn't tile */
        background-repeat: no-repeat;

        /* Background image is fixed in the viewport so that it doesn't move when 
           the content's height is greater than the image's height */
        background-attachment: fixed;

        /* This is what makes the background image rescale based
           on the container's size */
        background-size: cover;

        /* Set a background color that will be displayed
           while the background image is loading */
        background-color: #464646;      
    }  
    .card{
        top: 0%!important;
    }
    .surveyBoxSize::-webkit-scrollbar { 
        display: none; 
    }

    @media screen and (min-width:720px){
        .sign-up-bg{         
            min-height: 86vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }

</style>

<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 37.773972, lng: -122.431297},
            zoom: 13
        });
        //var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        //map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
                ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        //var infowindowContent = document.getElementById('infowindow-content');
        //infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });
        autocomplete.addListener('place_changed', function () {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                // User entered the name of a Place that was not suggested and
                // pressed the Enter key, or the Place Details request failed.
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            //alert(place.geometry.location);
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            $("#getLatLng").val(place.geometry.location);
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }

            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{$pageData->content}}&libraries=places&callback=initMap"
async defer></script>
@endpush