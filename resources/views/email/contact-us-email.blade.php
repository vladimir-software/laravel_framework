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
                box-sizing: content-box;
                padding-top: 1rem;
                margin-top: 1rem;
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
                    <p>You have a new contact form submission.  Please check the admin panel for details.</p>
                </div>
                <div style="">
                    <br>
                        <a style="margin-top: 35px;
                           padding: 8px 27px;
                           background-color: #ff7c00;
                           color: #ffffff;
                           border-radius: 5px;
                           font-size: 14px;
                           text-decoration: none;" href="{{route('admin.login')}}">Login</a>
                </div>
                <br>
            </div>
            <div style="text-align: center;">
                <br>
                    <p>Copyright <?php echo date('Y'); ?> ConnectEO Network, LLC. All Rights Reserved.</p>
            </div>
        </div>

    </body>
</html>
