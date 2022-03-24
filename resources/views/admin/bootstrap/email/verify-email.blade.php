<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width" />

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

        <style> 
            .white-back{
                background-color: #ffffff;
                text-align: center;
                padding: 10px;
                width: 50%;
                margin: 0 auto;
            }
            @media (max-width: 950px){
                .white-back{
                    width: 90%!important;
                }
            }
        </style>
    </head>
    <body>
        <div style="padding:10px;background-color: #eee;">
            <div class="white-back">
                <div style="text-align: center;">
                    <img src="{{asset('asset/connect_eo.png')}}" style="width: 150px;">   
                        <h3 style="margin-top: 25px;">Welcome to ConnectEO Network</h3>
                </div>
                <div style="">
                    <!--<p>Thank you for applying for this job {{$name}}.<br> To create your password click below. </p>-->
                    <p>Congratulations! You’ve been admitted into the ConnectEO Network. Here we connect entrepreneurs to opportunities. We are pleased to have you and your business join this network of collaborative, inspiring and progressive entrepreneurs just like you! Please select your membership package, update your profile and start connecting!</p>
                </div>
                <div style="">
                    <br>
                        <a style="margin-top: 35px;
                           padding: 8px 27px;
                           background-color: #ff7c00;
                           color: #ffffff;
                           border-radius: 5px;
                           font-size: 14px;
                           text-decoration: none;" href="{{route('login')}}">Login</a>
                </div>
                <br>
            </div>
            <div style="text-align: center;">
                <br>
                    <p>Copyright 2019  ConnectEO Network, LLC. All Rights Reserved.</p>
            </div>
        </div>

    </body>
</html>
