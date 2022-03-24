<div class="MobilesearchDropdown" style="display: block;">
    @foreach($array as $data)
    <li>
        <a href="{{route('user-profile',$data['user_id'])}}">
            <table class="search-table" style="width: 100%;">
                <tbody>
                    <tr>
                        <td class="responsive" style="width: 40px;">
                            <img src="{{$data['profile_pic']}}"></td>
                        <td style="color:#000;text-align: left;">
                            <h6 style="margin: 0px;">{{$data['name']}}</h6><span style="color:#666;font-size:12px;">{{$data['email']}}</span></td>
                        <td class="Fbutton" style="float: right; z-index: 1111;font-size: 13px;">
                            <span class="follow-btn" href="#"><u>view profile</u></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </a>
    </li>
    @endforeach
</div>
