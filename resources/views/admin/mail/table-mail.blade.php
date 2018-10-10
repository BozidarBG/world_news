<tr data-id="{{$hashid}}" {{$unread}}>
    <td class="email-checkbox">
        <input type="checkbox" class="checkbox">
    </td>

    <td class="email-favorite"><i class="{{$star}} fa-star"></i></td>

    <td class="email-name">{{$user}}</td>

    <td class="email-subject">
        <a class="email-link" href='{{route($route, ["hashid"=>$email->hashid])}}'>{{$title}}</a>
    </td>

    <td class="email-date">{{$date}}</td>
</tr>