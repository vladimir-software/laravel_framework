<script>
    $(document).ready(function () {
    <?php
        $userId = Auth::id();
        if (isset($userId) && $userId != '') {}
    ?>
    
        function scrollToBottom() {
            someElement.scrollTop = someElement.scrollHeight;
        }
    
        // Get a reference to the div you want to auto-scroll.
        var someElement = document.querySelector('.messages-chat');
        
        // Create an observer and pass it a callback.
        var observer = new MutationObserver(scrollToBottom);
        
        // Tell it to look for new children that will change the height.
        var config = {childList: true};
        observer.observe(someElement, config);
    });
    
    ////////////////////////// chat
    $(document).ready(function () {

        /////////////////////////// On load
        var receiverId = <?php echo (isset($inbox[0]['sender_id']) ? $inbox[0]['sender_id'] : '') ?>;
        var name = '<?php echo (isset($inbox[0]['name']) ? $inbox[0]['name'] : '') ?>';
        if (name == "admin") {
            var name = "support Team";
        }
        
        $(".messages-chat").html("");
        $(".chat-name").text(name);
        $(".footer-chat").show();
        $("#senderId").val('');
        $("#senderId").val(receiverId);
        $('.discussion').removeClass('message-active');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/chatHistory',
            type: "POST",
            data: {receiver_id: receiverId},
            dataType: 'json',
            context: this,
            success: function (data) {
                if (data.status == 'success') {
                    $.each(data.data, function (index, value) {
                        var isAlreadyShown = $('#message_id-'+value.message_id);                        
                        if (!isAlreadyShown.length) {
                            if (value.sender_id == <?php echo Auth::id(); ?>) {

                                var msg = '<div id="message_id-'+value.message_id+'" class="message">' +
                                        '                        <div class="response">' +
                                        '                            <p class="text"> ' + value.message + ' <span class="time"> ' + value.timing + ' </span></p>' +
                                        '                            ' +
                                        '                        </div>' +
                                        '                    </div>';
                                $(".messages-chat").append(msg);

                            } else {

                                var msg = '<div id="message_id-'+value.message_id+'" class="message">' +
                                        '                        <p class="text"> ' + value.message + '  <span class="time"> ' + value.timing + '</span></p>' +
                                        '                         ' +
                                        '                    </div>';
                                $(".messages-chat").append(msg);
                            }
                        }
                    });
                }
            }
        });

        function pollMessages() {
            console.log( $("#senderId").val());
            var receiverId = $("#senderId").val();
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/chatHistory',
                type: "POST",
                data: {receiver_id: receiverId},
                dataType: 'json',
                context: this,
                success: function (data) {
                    if (data.status == 'success') {
                        $.each(data.data, function (index, value) {
                            var isAlreadyShown = $('#message_id-'+value.message_id);                        
                            if (!isAlreadyShown.length) {
                                if (value.sender_id == <?php echo Auth::id(); ?>) {
                                    var msg = '<div id="message_id-'+value.message_id+'" class="message">' +
                                            '                        <div class="response">' +
                                            '                            <p class="text"> ' + value.message + ' <span class="time"> ' + value.timing + ' </span></p>' +
                                            '                            ' +
                                            '                        </div>' +
                                            '                    </div>';
                                    $(".messages-chat").append(msg);
                                } else {

                                    var msg = '<div id="message_id-'+value.message_id+'" class="message">' +
                                            '                        <p class="text"> ' + value.message + '  <span class="time"> ' + value.timing + '</span></p>' +
                                            '                         ' +
                                            '                    </div>';
                                    $(".messages-chat").append(msg);
                                }
                            }

                        });
                    }
                }
            });
            setTimeout(function(){ pollMessages(); }, 1000);
        }
        pollMessages();
            
        //////////////////////////////////
        $('.getChat').on('click', function () {
            var receiverId = $(this).attr('sender-id');
            var name = $(this).attr('sender-name');
            $(".messages-chat").html("");
            $(".chat-name").text(name);
            $(".footer-chat").show();
            $("#senderId").val('');
            $("#senderId").val(receiverId);
            $('.discussion').removeClass('message-active');
            $(this).addClass('message-active');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/chatHistory',
                type: "POST",
                data: {receiver_id: receiverId},
                dataType: 'json',
                context: this,
                success: function (data)
                {
                    if (data.status == 'success') {
                        $.each(data.data, function (index, value) {
                            var isAlreadyShown = $('#message_id-'+value.message_id);                        
                            if (!isAlreadyShown.length) {
                                if (value.sender_id == <?php echo Auth::id(); ?>) {
                                    var msg = '<div id="message_id-'+value.message_id+'" class="message">' +
                                            '                        <div class="response">' +
                                            '                            <p class="text"> ' + value.message + ' <span class="time"> ' + value.timing + ' </span></p>' +
                                            '                            ' +
                                            '                        </div>' +
                                            '                    </div>';
                                    $(".messages-chat").append(msg);
                                } else {

                                    var msg = '<div id="message_id-'+value.message_id+'" class="message">' +
                                            '                        <p class="text"> ' + value.message + '  <span class="time"> ' + value.timing + '</span></p>' +
                                            '                         ' +
                                            '                    </div>';
                                    $(".messages-chat").append(msg);
                                }
                            }
                        });
                  }
                }
            });
        });
    });

    ///////// chat 
    $(document).on("keypress", "input", function (event) {
        if (event.which == 13) {
            foospace.yourfunction();
        }
    });
    
    $(document).on("click", ".send", function (event) {
        foospace.yourfunction();
    });

    var foospace = {};
    foospace.yourfunction = function () {
        var chatData = $(".write-message").val();
        var receiverId = $("#senderId").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/sendMessage',
            type: "POST",
            data: {message: chatData, receiver_id: receiverId},
            dataType: 'json',
            context: this,
            success: function (data)
            {
                if (data.status == 'success') {
                    $(".write-message").val("");
                }
            }
        });
    }
</script>
