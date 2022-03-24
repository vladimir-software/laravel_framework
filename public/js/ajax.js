$(document).on('click', '.addDataToSession', function () {
    var types = [];
    $(this).parents('.userConnectionDataContainer').find(".relation").each(function () {
        types.push($(this).val());
    });
    var id = $(this).attr('rel');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/userProfileSession",
        data: {types: types, id: id},
        success: function (data)
        {
            window.location.href = '/user-profile/' + data.id;
        }
    });
});

//USER LOGIN
$("#loginForm").submit(function (e) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/post-login",
        data: $("#loginForm").serialize(),
        dataType: 'json',
        context: this,
        success: function (data)
        {
            if (data.status == 'success') {
                toastr["success"]("Successfully Logged In!");
                setTimeout(function () {
                    window.location.href = "home";
                }, 800);
            } else if (data.status == 'notApproved') {
                $(".errorForApproval").show();
                $(".errorForApproval").html(data.message);
            } else {
                $('.appendError').html('<span class="text-danger small">' + data.message + '</span>');
            }
        }
    });
});

//USER SIGN UP
$("#signUpForm").submit(function (e) {
    if ($('#pass2').val() !== $('#pass1').val()) {
        $('.appendError').html('');
        var myvar = '<div class="alert alert-danger"><strong>Alert! </strong>Your password and confirmation password do not match</div>';
        $('.appendError').append(myvar);
        $('#signup-btn').prop('disabled', true);
        return false;
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/post-signup",
        data: $("#signUpForm").serialize(),
        dataType: 'json',
        context: this,
        success: function (data)
        {
            if (data.status == 'success') {
                window.location.href = "/business";
            } else {
                toastr["error"](data.message);
            }
        }
    });
});

//CONFIRM PASSWORD ERRORF
$('#pass2').keyup(function () {
    $('.appendError').html('');
    $('#signup-btn').prop('disabled', false);
    return false;

});
///////////////////login password 
$('#loginPassword').keyup(function () {
    $('.appendError').html('');
    $('#signup-btn').prop('disabled', false);
    return false;
});
///////////////////////////

$(".searchUser").on('keyup', function (e) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "ajaxUserSearch",
        data: {keyword: $(this).val()},
        //dataType: 'json',
        context: this,
        success: function (data)
        {
            $('.customSearchList').html(data)
        }
    });
});

$(document).click(function () {
    $('.MobilesearchDropdown').remove();
});
