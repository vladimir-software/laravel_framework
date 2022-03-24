<div class="container-swipe w-100">
    <div class="content w-100" style="border-radius: 15px;"> 
        <div id="upgrade-swipe" class="container" style="display:none;">
            <div class="row" style='position:absolute; top: 10px; left: 10px; z-index: 100; width: 100%;'>
                <div class="col-12 mx-auto">
                    <div class="card w-100 scale-up-center my-2"> 
                        <div class="card-body" style="color:#333;">                  
                            <div class="text-center">
                                <p>To connect with more matches, please upgrade to premium.</p>
                                <button type="button" class="btn surveyNextButton text-white completeSurveyForm" onclick="window.location.href='/subscription'">Go Premium</button>
                                <button type="button" class="btn text-white completeSurveyForm" onclick="document.getElementById('upgrade-swipe').style='display:none;'"><span style="color:black;">Close</span></button>
                            </div>                   
                        </div>
                    </div>
                </div>
            </div>
        </div>        
        <!--USERS FOR OBTAIN SERVICES START-->
        @if(count($usersForObtainServices) >= 1)
        <ul id="stack_iman" class="stack stack--iman mb-3">
            @php $i=1;@endphp
            @foreach($usersForObtainServices as $data)  
            <li class="stack__item userConnectionDataContainer">
                <div style="background: #ff7c01;padding:1rem 0;display: flex; justify-content: center; align-items: center; width: 100%; min-height: 100px;">
                    <img src="{{asset('asset/connectEO_puzzle_bg_new.png')}}" alt="no image" class="puzzleImage" style="width: 230px; height: 195px;"> 
                    <img src="{{$data['profile_pic']}}" alt="no image" class="userImage"> 
                </div>
                <div class="w-100" style="position:relative;top: 16px;">
                    <h5 class="m-0 text-capitalize text-dark" style="color:#000000!important;font-size:18px!important;font-weight:600!important">{{($data['company_name'] != '')?$data['company_name']:""}}</h5>
                    <div class="d-flex justify-content-center text-capitalize">
                       <a href="javascript:void(0);" rel="{{$data['token']}}" style="white-space: nowrap;" class="borderRadius small addDataToSession">view profile</a>
                        @if(isset($data['location_address']))
                            <span class="px-1" style="font-size: 13px;">|</span>
                            <p class="m-0 small" style="font-size: 13px; white-space: nowrap; max-width: 100px; overflow: hidden; text-overflow: ellipsis;">{{(isset($data['location_address']) ? $data['location_address'] : "")}}</p>
                        @endif
                    </div>
                    <input class="user_id" value="{{$data['id']}}" id="user_id" hidden="">
                    <input  value="{{$i}}" id="card-number" hidden="">
                    <div>                         
                        @foreach($data['relation'] as $key=>$c)                       
                            <div> 
                                <span style="color:#000">{{$key}}</span>                           
                                <div class="owl-carousel-swipe owl-carousel">                             
                                    @foreach($c as $k)
                                        <div class="item"><span class="badge badge-primary " style="padding:5px 12px;">{{$k}}</span></div>                                                                   
                                    @endforeach  
                                </div>                           
                            </div>   
                        @endforeach
                        @foreach($data['type'] as $key1=>$c1)
                        @php  $m=$c1.":".$data['category_id'][$key1].",".$data['sub_category_id'][$key1]; @endphp    
                            <input class="relation" value="{{$m}}" id="user_id" hidden="">
                        @endforeach
                    </div>
                </div>
            </li>
            @php $i++;@endphp
            @endforeach          
        </ul> 
        <div class="controls">
            <button class="swipe-button button--sonar button--reject" rel="ad" data-stack="stack_iman">
                <span class="small btn btn-sm btn-success w-100">Skip</span>
            </button>            
            @if(isset(auth()->user()->subscription_type) && auth()->user()->subscription_type == "" || isset(auth()->user()->subscription_type) && auth()->user()->subscription_type == 1)
                <button class="swipe-button button--sonar hideForAd" onclick="document.getElementById('upgrade-swipe').style='display:block;'">
                    <span class="small btn btn-sm btn-primary w-100 ConnectWithUser">Connect</span>
                </button>
            @else
                <button class="swipe-button button--sonar button--accept hideForAd" data-stack="stack_iman">
                    <span class="small btn btn-sm btn-primary w-100 ConnectWithUser">Connect</span>
                </button> 
            @endif
        </div>
        <!--USERS FOR OBTAIN SERVICES END-->   
        @else
        <div><img src="{{asset('asset/connect_eo_new.png')}}" class="mt-3 mb-2" width="100px;" height="auto"></div>
        <p class="text-success text-center p-3 small rounded noAvailableUsers">This is where you find your curated matches specifically for your business needs. 
            Please be sure to update your profile to ensure your matches are always relevant.</p>
        @endif
    </div>
</div><!-- /container -->
@push('scripts')
<style>
    #stack_iman {
        min-height: 460px;
        padding: 0;
        margin: 0;
    }

    .badge{
        border-radius: 1rem;
        font-weight: initial;
        line-height: 1;
        padding: 0.2rem 0.3rem;
        font-family: "Poppins", sans-serif;
        font-weight: 600;
        background: #ff7c00!important;
        color: #fff;
        font-size: 11px;
        max-width: 240px;
    }
    .badge-success, .preview-list .preview-item .preview-thumbnail .badge.badge-online {
        color: #fff;
        background-color: #ed1c24;
    }
    
    .controls {
        border-radius: 0px 0px 15px 15px;
        margin-top: -18px;
    }

    .stack__item{
        transform: none!important;
    }
    
    .userImage{
        position: absolute;
        width: 190px;
        height: 160px;
    }
</style>
<script src="{{asset('js/classie.js')}}"></script>
<script src="{{asset('js/dynamics.min.js')}}"></script>
<script src="{{asset('js/swipe-main.js?v=1')}}"></script>
<script>
    setTimeout(function () {
    
        function mobilecheck() {
            var check = false;
            (function (a) {
                if (/(android|ipad|playbook|silk|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
                    check = true
            })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
        }

        var clickeventtype = mobilecheck() ? 'touchstart' : 'click';
        (function () {
            var support = {animations: Modernizr.cssanimations},
                    animEndEventNames = {'WebkitAnimation': 'webkitAnimationEnd', 'OAnimation': 'oAnimationEnd', 'msAnimation': 'MSAnimationEnd', 'animation': 'animationend'},
                    animEndEventName = animEndEventNames[ Modernizr.prefixed('animation') ],
                    onEndAnimation = function (el, callback) {
                        var onEndCallbackFn = function (ev) {                    
                            if (support.animations) {
                                if (ev.target != this) return;
                                this.removeEventListener(animEndEventName, onEndCallbackFn);
                            }
                            if (callback && typeof callback === 'function') {
                                callback.call();
                            }
                        };
                        if (support.animations) {
                            el.addEventListener(animEndEventName, onEndCallbackFn);
                        } else {
                            onEndCallbackFn();
                        }
                    };
            [].slice.call(document.querySelectorAll('.button--sonar')).forEach(function (el) {
                el.addEventListener(clickeventtype, function (ev) {
                    if (el.getAttribute('data-state') !== 'locked') {
                        classie.add(el, 'button--active');
                        onEndAnimation(el, function () {
                            classie.remove(el, 'button--active');
                        });
                    }
                });
            });
        })();

        (function () {

            var support = {animations: Modernizr.cssanimations},
                animEndEventNames = {'WebkitAnimation': 'webkitAnimationEnd', 'OAnimation': 'oAnimationEnd', 'msAnimation': 'MSAnimationEnd', 'animation': 'animationend'},
                animEndEventName = animEndEventNames[ Modernizr.prefixed('animation') ],
                onEndAnimation = function (el, callback) {
                    var onEndCallbackFn = function (ev) {
                        if (support.animations) {
                            if (ev.target != this) return;
                            this.removeEventListener(animEndEventName, onEndCallbackFn);
                        }
                        if (callback && typeof callback === 'function') callback.call();
                    };
                    if (support.animations) {
                        el.addEventListener(animEndEventName, onEndCallbackFn);
                    } else {
                        onEndCallbackFn();
                    }
                };
                    
            function nextSibling(el) {
                var nextSibling = el.nextSibling;
                while (nextSibling && nextSibling.nodeType != 1) nextSibling = nextSibling.nextSibling
                return nextSibling;
            }

            var iman = new Stack(document.getElementById('stack_iman'), {
                stackItemsAnimation : {
				    duration: 1300,
				    type: dynamics.spring, 
				    friction: 420,
			    },
			    visible: 4,  
			    perspectiveOrigin : '50% 50%',
			    stackItemsPreAnimation : {
				    accept : {
					    elastic: true,
					    animationProperties: {translateX : 250},
					    animationSettings: {
						    duration: 400,
						    type: dynamics.easeIn
					    }
				    },
				    reject : {
					    elastic: true,
					    animationProperties: {translateX : -250},
					    animationSettings: {
						    duration: 400,
						    type: dynamics.easeIn
					    }
				    }
			    }
            });
            console.log(iman);
            
            // controls the click ring effect on the button
            var buttonClickCallback = function (bttn) {
                var bttn = bttn || this;
                bttn.setAttribute('data-state', 'unlocked');
            };
            
            document.querySelector('.button--accept[data-stack = stack_iman]').addEventListener(clickeventtype, function () {
                iman.accept(buttonClickCallback.bind(this));
            });
            
            document.querySelector('.button--reject[data-stack = stack_iman]').addEventListener(clickeventtype, function () {
                iman.reject(buttonClickCallback.bind(this));
            });
            
            [].slice.call(document.querySelectorAll('.button--sonar')).forEach(function (bttn) {
                bttn.addEventListener(clickeventtype, function () {
                    bttn.setAttribute('data-state', 'locked');
                });
            });
            
            [].slice.call(document.querySelectorAll('.button--material')).forEach(function (bttn) {
                var radialAction = nextSibling(bttn.parentNode);
                bttn.addEventListener(clickeventtype, function (ev) {
                    var boxOffset = radialAction.parentNode.getBoundingClientRect(),
                            offset = bttn.getBoundingClientRect();
                    radialAction.style.left = Number(offset.left - boxOffset.left) + 'px';
                    radialAction.style.top = Number(offset.top - boxOffset.top) + 'px';
                    classie.add(radialAction, classie.has(bttn, 'button--reject') ? 'material-circle--reject' : 'material-circle--accept');
                    classie.add(radialAction, 'material-circle--active');
                    onEndAnimation(radialAction, function () {
                        classie.remove(radialAction, classie.has(bttn, 'button--reject') ? 'material-circle--reject' : 'material-circle--accept');
                        classie.remove(radialAction, 'material-circle--active');
                    });
                });
            });
            
        })();

    }, 1000);

    var owlss = $('.owl-carousel-swipe');
    owlss.owlCarousel({
        autoplay: false,
        center: true,

        margin: 10,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            },
            1300: {
                items: 1
            }
        }
    });
</script>

@endpush
