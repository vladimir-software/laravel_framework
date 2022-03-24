<footer class="footer">
    <div class="container-fluid clearfix">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2019. All rights reserved.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i class="mdi mdi-heart text-danger"></i></span>
    </div>
</footer>                
<script src="http://127.0.0.1:8000/bootstrap/js/jquery.min.js" ></script> 
<script type="text/javascript">
    $(document).ready(function() {
        $.getJSON( "/getUserAdminInfo", function( data ) {
          $('#admin-name').html(data.fullname);
          if (data.profile_pic) {
            $('#admin-profile-image').attr('src', data.profile_pic);
            $('#admin-small-image').attr('src', data.profile_pic);
          }
          if (data.account_type_id == 3) {
              $('#admin-designation').html('Super Admin');
          } else {
              $('#admin-designation').html('Administrator');
          }
        });
    });
    
    $(document).ready(function() {
    
        var allChecked = false;
        $('#contact_message_all').click(function() {
           allChecked = !allChecked;
           $('input[type=checkbox]').each(function () {
               this.checked = !allChecked;
           });
           $( "#delete-messages" ).prop( "disabled", allChecked );
        });
        
        $('.message_checkbox').click(function() {
            var anythingChecked = false;
            $('input[type=checkbox]').each(function () {
                if (this.checked) anythingChecked = true;
            }); 
            $( "#delete-messages" ).prop( "disabled", !anythingChecked );
        });
        
        $('#delete-messages').click(function() {
            var messageIds = '';
            $('input[type=checkbox]').each(function () {
                if (this.checked) messageIds = messageIds + $(this).val() + ","
            });
            $.getJSON( "/admin/deleteContactMessages?messageIds=" + messageIds, function( data ) {
                location.reload(true);
            });
        });
    });
</script>
