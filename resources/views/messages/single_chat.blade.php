<script>
    $(document).ready(function () {
<?php
$userId = Auth::id();
if (isset($userId) && $userId != '') {
    ?>
<?php } ?>
    });
</script>

<script>
////////////////////////// chat 
    $(document).ready(function () {
        ///////////////////////////On load
        var receiverId = <?php echo $user['id']; ?>;
        var name = '<?php echo $user['fullname']; ?>';
        $(".messages-chat").html("");

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
            success: function (data)//randJobData
            {
                if (data.status == 'success') {
                    $.each(data.data, function (index, value) {
                        if (value.sender_id == <?php echo Auth::id(); ?>) {

                            var msg = '<div class="message">' +
                                    '                        <div class="response">' +
                                    '                            <p class="text"> ' + value.message + ' <span class="time"> ' + value.timing + ' </span></p>' +
                                    '                            ' +
                                    '                        </div>' +
                                    '                    </div>';
                            $(".messages-chat").append(msg);
                        } else {

                            var msg = '<div class="message ">' +
                                    '                        <p class="text"> ' + value.message + '  <span class="time"> ' + value.timing + '</span></p>' +
                                    '                         ' +
                                    '                    </div>';


                            $(".messages-chat").append(msg);
                        }

                    });
                    $(".messages-chat").animate({scrollTop: $(document).height()}, 1000);
                }
            }
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
        var receiverId = <?php echo $user['id']; ?>;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/sendMessage',
            type: "POST",
            data: {message: chatData, receiver_id: receiverId},
            dataType: 'json',
            context: this,
            success: function (data)//randJobData
            {
                if (data.status == 'success') {
                    $(".write-message").val("");
                    var msg = '<div class="message">' +
                            '                        <div class="response">' +
                            '                            <p class="text"> ' + data.chat.message + ' <span class="time"> ' + data.chat.timing + ' </span></p>' +
                            '                            ' +
                            '                        </div>' +
                            '                    </div>';

                    $(".messages-chat").append(msg);
                    $(".write-message").val("");
                    $(".write-message").animate({scrollTop: $(document).height()}, 1000);
                }
            }
        });
    }

</script>
