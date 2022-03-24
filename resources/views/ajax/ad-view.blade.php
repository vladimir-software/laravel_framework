@foreach($ad as  $data)  
<li class="stack__item userConnectionDataContainer 123">
    <div style="background: #ff7c01;padding:1rem 0;display: flex;
         justify-content: center;
         align-items: center;
         width: 100%;">
        <img src="{{asset($data->image)}}" alt="no image" class="userImage"> 
    </div>  
    <input class="user_id" value="0" id="user_id" hidden="">  
</li>
@endforeach  
