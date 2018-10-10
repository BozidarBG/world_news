<?php
/**
 * Created by PhpStorm.
 * User: Bole
 * Date: 3.10.2018
 * Time: 1:46
 */
public function store(Request $request)
{
    //dd($request->all());
    //ako dolazimo sa edit, onda smo stavili id emaila u sesiju. ako ne, onda je id emaila null
    $email_id = Session::has('email_id') ? Session::pull('email_id') : null;
    if ($request->has('send')) {
        $this->sendEmail($request, $email_id);
        return redirect()->route('email.inbox');
    } elseif ($request->has('save')) {
        $this->saveToDrafts($request, $email_id);
        return redirect()->route('email.inbox');
    } else {
        //nešto je petljao oko html-a
        return redirect()->back();
    }
}


protected function sendEmail($request, $email_id)
{
    $this->validate($request, [
            'receiver' => 'required|integer',
            'title' => 'required|string',
            'body' => 'required|string',
    ]);

    $receiver = User::where('id', $request->receiver)->first();
    if ($receiver) {
        if ($email_id) {
            //znači dolazimo sa edit. ne pravimo novu instancu nego koristimo postojeći red
            $email = Email::findOrFail($email_id);
            $email->is_draft = 0;
            Session::forget('email_id');
        } else {
            //znači ne dolazimo sa edit stranice. pravimo novu instancu tj novi red
            $email = new Email();
            $email->sender = Auth::id();
            $email->receiver = $request->receiver;
            $email->title = $request->title;
            $email->body = $request->body;
            $lastId=Email::count() ? Email::latest()->first()->id : 0;
            $hashids = new Hashids('email', 10);
            $hash_id=$hashids->encode($lastId+1);
            $email->hashid=$hash_id;
        }
        if ($email->save()) {
            toastr()->success('Email sent successfully!');
        } else {
            toastr()->error('Email was not sent!');
        }
        //primalac ne postoji
    } else {
        toastr()->error('Such user does not exists!');
        return redirect()->back();
    }
}

protected function saveToDrafts($request, $email_id){

    if($email_id){
        //znači dolazimo sa edit. ne pravimo novu instancu nego koristimo postojeći red
        $email=Email::findOrFail($email_id);
        $email->sender=Auth::id();
        $email->receiver=$request->receiver;
        $email->title=$request->title;
        $email->body=$request->body;
        $request->session()->forget('email_id');
        $email->save();
    }else{
        //znači ne dolazimo sa edit stranice. pravimo novu instancu tj novi red i dajemo is_draft=true
        $email=new Email();
        $email->sender=Auth::id();
        $email->receiver=$request->receiver;
        $email->title=$request->title;
        $email->body=$request->body;
        $email->is_draft=true;
        $lastId=Email::count() ? Email::latest()->first()->id : 0;
        $hashids = new Hashids('email', 10);
        $hash_id=$hashids->encode($lastId+1);
        $email->hashid=$hash_id;
        //
        $email->save();
    }
    toastr()->success('Email saved to drafts successfully!');
}



<i class="fas fa-star"></i>
                <div class="card-body p-1">
                    <table class="table table-responsive-md">
                        <tbody >
@if($emails->count()>0)
    @foreach($emails as $email)
        <tr data-id="{{$email->hashid}}"
            @if($page_name==="Inbox" && !$email->was_read)
            class="unread"
                @endif
        >
            <td class="email-checkbox">
                <input type="checkbox" class="checkbox">
            </td>

            @if($page_name==="Inbox")
                <td class="email-favorite">
                    @if($email->important_receiver)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                </td>
                <td class="email-name">{{$email->getUsersName($email->sender)}}</td>
            @elseif($page_name==="Sent")
                <td class="email-favorite">
                    @if($email->important_sender)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                </td>
                <td class="email-name">{{$email->getUsersName($email->receiver)}}</td>
            @elseif($page_name==="Drafts")
                <td class="email-favorite">
                    @if($email->important_sender)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                </td>
                <td class="email-name">{{$email->getUsersName($email->receiver)}}</td>
            @elseif($page_name==="Trash")
                <td class="email-name">{{$email->getUsersName($email->sender)}}</td>
            @elseif($page_name==="Search results" && $page_from==="Inbox")
                <td class="email-name">{{$email->getUsersName($email->sender)}}</td>
            @elseif($page_name==="Search results" && ($page_from==="Drafts" || $page_from ==="Sent"))
                <td class="email-name">{{$email->getUsersName($email->receiver)}}</td>
            @endif
            <td class="email-subject">
                @if($page_name==="Drafts")
                    <a class="email-link" href="{{route('email.edit', ['hashid'=>$email->hashid])}}">{{$email->title ?? 'No title'}}</a>
                @else
                    <a class="email-link" href="{{route('email.show', ['hashid'=>$email->hashid])}}">{{$email->title ?? 'No title'}}</a>
                @endif
            </td>
            <td class="email-date">{{$email->showDate(true)}}</td>
        </tr>
    @endforeach
@else
    <tr><td>There are no emails in this box</td></tr>
    @endif
    </tbody>
    </table>
    </div>



    <tr data-id="{{$hashid}}" {{$unread}}>
        <td class="email-checkbox">
            <input type="checkbox" class="checkbox">
        </td>

        <td class="email-favorite">{{$star}}</td>

        <td class="email-name">{{$user}}</td>

        <td class="email-subject">
            <a class="email-link" href="{{$route}}">{{$title}}</a>
        </td>

        <td class="email-date">{{$date}}</td>
    </tr>