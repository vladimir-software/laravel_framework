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
                    <p class="emailMessage" style="text-align:left">Hi,<br>
                            We received a request to reset the password associated with this
                            email address. If you made this request, please follow the
                            instructions below. If you did not make this request, please
                            disregard this email.
                            Click the link below or copy & paste it into your browser to
                            reset your password using our secure server: </p>
                    <a href="{{route('password.create-new-password',$token)}}">{{route('password.create-new-password',$token)}}</a>
                </div>
                <div style="">
                    <br><br>
                            <a style="margin-top: 35px;
                               padding: 10px 47px;
                               background-color: #ff7c00!important;
                               color: #ffffff;
                               border-radius: 5px;
                               font-size: 13px;
                               text-decoration: none;
                               letter-spacing: .5px;" href="{{route('password.create-new-password',$token)}}">Change Password</a>
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
