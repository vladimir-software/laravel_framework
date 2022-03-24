@extends('layouts.elements.app')
@section('content')
<div class="container">
    <div class="row my-4">
        <div class="col-sm-12 col-md-12 col-lg-12 mb-12 mb-md-0 order-2 order-md-12">
            <div class="card-header text-center font-bold" style="border-bottom: 0px;">
                <h5 style="color: #ff7c00; font-family: sans-serif;"><i class="fas fa-project-diagram"></i> Manage Project</h5>
                
                <div class="card-body row">
                    <div style="float:right; width: 100%;">
                        <img src="{{$data['my_profile_picture']}}" style="max-height: 100px; max-width: 100px;" class="rounded-circle img-center img-fluid shadow shadow-lg--hover"/>
                        <img src="{{$data['other_profile_picture']}}" style="max-height: 100px; max-width: 100px;" class="rounded-circle img-center img-fluid shadow shadow-lg--hover"/>
                    </div>            
                
                </div>
                <div class="card-body row" style="clear:both;">
                    <h4 style="color: black;"><i class="fas fa-info-circle"></i> Project Details</h4>                    
                </div>
                <div class="card-body row">
                    <h5>Start Date:</h5>
                    &nbsp; <input type="text" id="start_date" value="<?=$data['start_date']?>" />&nbsp;&nbsp;
                    <h5>End Date:</h5>
                    &nbsp;&nbsp;
                    <input type="text" id="end_date" value="<?=$data['end_date']?>" />
                </div>
                <div class="card-body row">
                    <input type="checkbox" id="money_exchanged" name="money_exchanged" value="1" onchange="saveProjectData('money_exchanged')" <?=($data['money_exchanged']) ? 'checked': ''?>> 
                    <span style="margin: 3px; color: #666;">Includes Fee? </span>
                </div>
                <div id="amount-paid-info" class="card-body row" style="display:none;">
                    <h5>Cost Estimate $</h5> &nbsp; <input type="number" id="amount" value="<?=$data['amount']?>" onchange="saveProjectData('amount');" />&nbsp;&nbsp;
                    <input type="checkbox" id="is_paid" name="is_paid" value="1" onchange="saveProjectData('is_paid')" <?=($data['is_paid']) ? 'checked': ''?>> <span style="margin: 3px; color: #666;">Payment Received </span>
                </div>
                <div class="card-body row">
                
                    <h5>Project Title <span style="font-size: 10px;">(click to edit)</span></h5>
                    <p id="project-title" style="min-width: 100%; min-height: 25px; border: dotted 1px #000;"><?=$data['title']?></p>
                    <textarea id="project-title-edit" style="display: none;" rows="1" cols="160"><?=$data['title']?></textarea>

                    <h5>Project Description <span style="font-size: 10px;">(click to edit)</span></h5>
                    <p id="project-description" style="min-width: 100%; min-height: 100px; border: dotted 1px #000;"><?=$data['description']?></p>
                    <textarea id="project-description-edit" style="display: none;" rows="10" cols="160"><?=$data['description']?></textarea>

                    <br />
                    <h5>Project Status [<span id="percent-done">...</span>]</h5>
                    <div id="progressbar" style="width: 100%; margin: 10px;"></div>
                    <div class="row" style="min-width: 100%;"></div>
                    <div id="progressbar-milestones" style="min-width: 100%;">
                        <div class="milestone-item" style="float: left;"><strong>Start</strong></div>
                        <span class="milestone-item" style="float: right;"><strong>End</strong></span>
                        <span style="clear: both;"></span><br />
                        <br />
                        <div></div>
                        <div id="tags-panel">
                            <div class="card-body row">
                                <h4>Current Tasks to finish project (sort/edit)</h4>
                            </div>
                            <div class="card-body row">
                                <div class="dual-list list-right col-md-4">
                                    <h5>TODO</h5>
                                    <div class="well">
                                        <ul id="todo-list-group" class="list-group"></ul>
                                    </div>
                                </div>
                                <div class="dual-list list-right col-md-4">
                                    <h5>IN PROGRESS</h5>
                                    <div class="well">
                                        <ul id="in-progress-list-group" class="list-group"></ul>
                                    </div>
                                </div>
                                <div class="dual-list list-right col-md-4">
                                    <h5>FINISHED</h5>
                                    <div class="well">
                                        <ul id="finished-list-group" class="list-group"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body row">
                            <br />
                            <input id="milestone-item" type="text" name="milestone-item" />&nbsp;
                            <div id="milestones-add" onclick="addItem()" style="cursor: pointer;">Add Task</div>
                        </div>
                        <div class="card-body row">
                        <br /><br />
                        </div>
                        <div style="padding: 5px; background:black;">
                            <div class="card-body row">
                                <div id="oustanding-edits" class="card-body row" style="padding-bottom: 0;">
                                    <h5><i class="fas fa-exclamation-triangle"></i>&nbsp;<u>Recent Edits</u> (needing approval)</h5>                    
                                </div>
                            </div>
                            <div class="card-body row">
                                <h5 id="no-edits">-None-</h5>
                            </div>
                            <div class="card-body row" style="padding-top: 0;">
                                <div id="outstanding-edits-items" class="card-body row">
                                    <ul id="outstanding-edits-items-list"></ul>
                                </div>
                            </div>
                            <div class="card-body row" style="padding-top: 0;">
                                <div id="outstanding-edits-items" class="card-body row">
                                    <form action="{{route('projectApprove')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="projectId" value="<?=$data['projectId']?>" />
                                        <input type="hidden" name="userEditId" value="<?=$data['otherPartyUserId']?>" />
                                        <button id="approve-edits-button" style="display: none;" type="submit" class="btn btn-light">Approve Edits</button><br />
                                    </form>
                                </div>
                                <div style="color: red; font-weight: bold;">red</div>
                                &nbsp; is your own edits to approve. &nbsp;
                                <div style="color: green; font-weight: bold;">green</div>
                                &nbsp; is your partner's to review/confirm above
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog" title="View Task" style="min-width: 50%; min-height: 200px; display:none;">
    <form role="form">
        <br style="clear:both">
			<div class="form-group">
				<input type="text" class="form-control" id="task-title" name="task-title" placeholder="Name" required>
				<input type="hidden" id="task-id" name="task-id">
			</div>
            <div class="form-group">
                <textarea class="form-control" type="textarea" id="task-description" placeholder="Details" maxlength="140" rows="7"></textarea>
            </div>        
            <button type="button" id="edit-task-details" name="edit-task-details" class="btn btn-primary pull-right" onclick="saveTask();">Save Task</button>
            <button type="button" id="close-dialog" name="close-dialog" class="btn pull-right" onclick="$( '#dialog' ).dialog( 'close' );">Close</button><br/><br/>
            <button type="button" id="close-dialog" name="close-dialog" style="float: right; font-size: 10px;" class="btn btn-danger pull-right" onclick="deleteTask();">Delete</button>
        </form>
</div>

<!--END CONNECTED MODAL-->
@endsection
@push('scripts')
<script type="text/javascript">

  var outstandingEdits = [];
  function addOutstandingEdits(fieldName, color) {
    fieldName = fieldName.replace('-edit', '');
    fieldName = fieldName.replace('-', ' ');
    fieldName = fieldName.replace('_', ' ');
    var alreadyHasItem = false;
    $( "#no-edits" ).hide();
    $.each(outstandingEdits, function( index, value ) {
        if ((fieldName == value[0]) && (color == value[1])) alreadyHasItem = true;
    });
    if (!alreadyHasItem) {
        outstandingEdits.push([fieldName, color]);
        $('#outstanding-edits-items-list').append('<li style="text-align:left; color:' + color + ';">* ' + fieldName + '</li>');
    }
  };
  
  function saveTask() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/project-task-edit",
        data: '&method=edit&projectId=<?=$data['projectId']?>&title='+$('#task-title').val()+'&description=' + $('#task-description').val() +'&id=' + $('#task-id').val(),
        dataType: 'json',
        context: this,
        success: function (data) {
            console.log(data);
            location.reload();
        }
    });
  }
  
  function editTask(id) {
    $( "#dialog" ).dialog();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/project-task-details",
        data: '&projectId=<?=$data['projectId']?>&id=' + id,
        dataType: 'json',
        context: this,
        success: function (data) {
            console.log(data.title);
            $( "#task-description" ).val(data.description);
            $( "#task-title" ).val(data.title);
            $( "#task-id" ).val(data.id);
        }
    });
  }

  function deleteTask() {
    var r = confirm("Delete Project Task?");
    if (r == true) deleteProjectTask($('#task-id').val());
  }
  
  function deleteProjectTask(id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/project-task-edit",
        data: '&method=delete&projectId=<?=$data['projectId']?>&id=' + id,
        dataType: 'json',
        context: this,
        success: function (data) {
            console.log(data);
            location.reload();
        }
    });
  }
  
  
  $( function() {
  
    // prepopulate the fields based on who has outstanding edits
    @if(!empty($data['projectEdits']))
    @foreach($data['projectEdits'] as $projectEdit)
        $('#outstanding-edits-items').show();
        var editField = '{{$projectEdit->field}}';
        editField = editField.replace('-edit', '');
        @if($data['otherPartyUserId'] == $projectEdit->user_id)
            addOutstandingEdits('{{$projectEdit->field}}', 'red');
            $( "#" + editField ).css('border', 'solid 2px red');
            $( "#approve-edits-button" ).show();
            $( "#no-edits" ).hide();
        @else
            addOutstandingEdits('{{$projectEdit->field}}', 'green');
            $( "#" + editField ).css('border', 'dotted 3px green');
            $( "#no-edits" ).hide();
        @endif    
    @endforeach
    @endif
    
    // prepopulate the todo lists based on current project status
    @if(!empty($data['projectTasks']))
    @foreach($data['projectTasks'] as $projectTask)
            @if ($projectTask["status"]=='todo')
                $("#todo-list-group").append('<li class="list-group-item ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$projectTask["title"]}} <i class="fas fa-pen-square" onclick="editTask(\'{{$projectTask["id"]}}\')"></i></li>');
            @endif            
            
            @if ($projectTask["status"]=='progress')
                $("#in-progress-list-group").append('<li class="list-group-item ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$projectTask["title"]}} <i class="fas fa-pen-square" onclick="editTask(\'{{$projectTask["id"]}}\')"></i></li>');
            @endif
            
            @if ($projectTask["status"]=='finished')
                $("#finished-list-group").append('<li class="list-group-item ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>{{$projectTask["title"]}} <i class="fas fa-pen-square" onclick="editTask(\'{{$projectTask["id"]}}\')"></i></li>');
            @endif            
    @endforeach
    setTimeout(function(){ updateProjectBar(); }, 1000);
    @endif
  
    @if(!empty($data['money_exchanged']))
         $('#amount-paid-info').show();
    @endif
  
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    $( "#start_date" ).datepicker({
        onSelect: function(dateText) {
            $( "#start_date" ).attr('style', 'border: dotted 3px green');
            saveProjectData('start_date');
        }
    });
    
    $( "#end_date" ).datepicker({
        onSelect: function(dateText) {
            $( "#end_date" ).attr('style', 'border: dotted 3px green');
            saveProjectData('end_date');
        }
    });
    
    $('#amount').change(function () {
        $( "#amount" ).attr('style', 'border: dotted 3px green');
    });
    
    $('#money_exchanged').change(function() {
        if(this.checked) {
            $('#amount-paid-info').show();
        } else {
            $('#amount-paid-info').hide();
        }
    });
    
    $("input[name=milestone-item]").keyup(function(event){
      if(event.keyCode == 13) $("#button").click();
    });
  
    $(document).on('dblclick','li', function(){
        $(this).toggleClass('strike').fadeOut('slow');
    });

    $('input').focus(function() {
        $(this).val('');
    });

    $('#todo-list-group').sortable({
        connectWith: '#in-progress-list-group',
        update: function( ) {
            sortTaskList();
        }
    }).disableSelection();
    
    $('#in-progress-list-group').sortable({
        connectWith: '#finished-list-group',
        update: function( ) {
         sortTaskList();
        }
    }).disableSelection();
    
    $('#finished-list-group').sortable({
        connectWith: '#todo-list-group',
        update: function( ) {
         sortTaskList();
        }
    }).disableSelection();

    $('ol').sortable();
    $( "#progressbar" ).progressbar({
      value: 0
    });

    $("#project-title").click(function () {
      $(this).css('display','none');
      $('#project-title-edit').css('display', 'block');
      $('#project-title-edit').val($(this).text());
      $('#project-title-edit').focus();
    });
    
    $('#project-title-edit').blur(function () {
        var r = confirm("Save New Title?");
        if (r == true) {
          var value = $(this).val();
          $("#project-title").text(value);
          $(this).css('display','none');
          $('#project-title').css('display', 'block');
          $('#project-title').css('border', 'dotted 3px green');
          saveProjectData('project-title-edit');
        } else {
          var value = $(this).val();
          $("#project-title").text(value);
          $(this).css('display','none');
          $('#project-title').css('display', 'block');
        }
    });
      
    $("#project-description").click(function () {
      $(this).css('display','none');
      $('#project-description-edit').css('display', 'block');
      $('#project-description-edit').val($(this).text());
      $('#project-description-edit').focus();
    });

    $('#project-description-edit').blur(function () {
        var r = confirm("Save New Description?");
        if (r == true) {
          var value = $(this).val();
          $("#project-description").text(value);
          $(this).css('display','none');
          $('#project-description').css('display', 'block');
          $('#project-description').css('border', 'dotted 3px green');
          saveProjectData('project-description-edit');
        } else {
          var value = $(this).val();
          $("#project-description").text(value);
          $(this).css('display','none');
          $('#project-description').css('display', 'block');
        }
    });
});

function addItem() {
    if ($('#milestone-item').val()) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: "/project-task-edit",
            data: '&method=add&projectId=<?=$data['projectId']?>&status=todo&title=' + $('#milestone-item').val(),
            dataType: 'json',
            context: this,
            success: function (data) {
                console.log(data);                
                $("#todo-list-group").append('<li class="list-group-item ui-state-default"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' + $('#milestone-item').val() + ' <i class="fas fa-pen-square" onclick="editTask(\'' + $.trim(data.task_id) + '\')"></i></li>');
                $('#milestone-item').val('');
                updateProjectBar();
            }
        });
    }
}

function updateProjectBar() {
    var todo = $('ul#todo-list-group li').length;
    var progress = $('ul#in-progress-list-group li').length;
    var finished = $('ul#finished-list-group li').length;

    var total = todo + progress + finished;
    var percentFinished = finished/total * 100;

    $( "#progressbar" ).progressbar({
      value: percentFinished
    });

    if (isNaN(percentFinished)) {
        $('#percent-done').html('0%');
    } else {
        $('#percent-done').html(Math.round(percentFinished) + '%');        
    }
}

function sortTaskList() {
    var todoList = document.getElementById('todo-list-group');
    var inProgressList = document.getElementById('in-progress-list-group');
    var finishedList = document.getElementById('finished-list-group');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/project-task-edit",
        data: '&method=sort&projectId=<?=$data['projectId']?>&status=sort&todo=' + todoList.innerHTML + '&progress=' + inProgressList.innerHTML + '&finished=' + finishedList.innerHTML,
        dataType: 'json',
        context: this,
        success: function (data) {
            console.log(data);
            $('#milestone-item').val('');
            updateProjectBar();
        }
    });
}

function saveProjectData(fieldName) {
    $("#edit-made-message").show();    
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: "/project-edit",
        data: '&fieldName=' + fieldName + '&projectId=<?=$data['projectId']?>' +  '&is_paid=' + $('#is_paid').is(':checked') + '&amount=' + $("#amount").val() + '&start_date=' + $("#start_date").val() +  '&end_date=' + $("#end_date").val() +  '&money_exchanged=' + $('#money_exchanged').is(':checked') +  '&project-title-edit=' + $("#project-title-edit").val() +  '&project-description-edit=' + $("#project-description-edit").val(),
        dataType: 'json',
        context: this,
        success: function (data) {
            console.log(data);
            addOutstandingEdits(data.fieldName, 'green');
        }
    });
}
</script>
<style>
    div.ui-dialog-titlebar.ui-corner-all.ui-widget-header.ui-helper-clearfix.ui-draggable-handle > button {
        display:none;
    }

    .ui-button-icon-space{
        display:none;
    }

    hr {
        border: 0;
        height: 1px;
        background: #333;
        background-image: linear-gradient(to right, #ccc, #333, #ccc);
    }

    .btn-md {
        color:white;
    }
    
    .btn-success, .ui-button-text {
        color:white;
    }
    
    #milestone-button-text-open, #milestone-button-text-close {
        color:white;
    }
    
    .list-group {
        cursor:row-resize;
    }
    
    .list-group { list-style-type: none; margin: 0; padding: 0;  }
    .list-group li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em;  }
    .list-group li span { position: absolute; margin-left: -1.3em; }
    
    #todo-list-group, #in-progress-list-group, #finished-list-group {
        min-height: 100px;
    }
    
    #todo-list-group {
        border: dotted 2px red;
    }
    
    #in-progress-list-group {
        border: dotted 2px blue;
    }
    
    #finished-list-group {
        border: dotted 2px green;
    }
    
    ol {
        color:black;
        cursor:row-resize;
    }
    
    .milestone-project-item {
        font-size: 10px;
    }    

    #milestones-add {
        display: inline-block;
        background-color:#96191b;
        color:#ffffff;
        border-radius: 5px;
        text-align:center;
        padding: 5px 15px;
    }

    .dual-list .list-group {
        margin-top: 8px;
    }

    .list-left li, .list-right li {
        cursor: pointer;
    }

    .list-arrows {
        padding-top: 100px;
    }

    .list-arrows button {
        margin-bottom: 20px;
    }

    .card-body {
        background:white;
        padding: 18px;
    }

    .list-group-item {
        margin-bottom: 5px;
    }


    body {
        overflow-x: scroll; 
        width: 1500px
        color: #666666;
    }

    #sortable1, #sortable2, #sortable3 { 
        list-style-type: none; 
        margin: 0; 
        float: left; 
        margin-right: 10px; 
        background: #eee; 
        padding: 5px; 
    }

    #sortable1 li, #sortable2 li, #sortable3 li { 
        margin: 5px; 
        padding: 5px; 
        font-size: 1.2em; 
        cursor: move;
    }


    div.box {
        width: 300px;
        display: inline-block;
        margin: 10px;
        background-color: #eee;
    }

    div.header {
        text-align: center;
        font-weight: bold;
        padding: 10px 5px 5px;
        cursor: move;
    }

    .box ul {
        width: 290px;
    }

    div.orders {

    }

    div.column {
        width: 350px;
        float: left;
        height: auto;
        margin: 2px;
        min-height: 50px;
        border: 1px #d3d3d3 dashed;
    }

    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    .ui-dialog .ui-state-error { padding: .3em; }

    .btnToolbar {
        margin-bottom: 10px;
    }
</style>
@endpush
