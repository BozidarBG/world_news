@extends('layouts.admin.adminlayout')

@section('styles')
    <link rel="stylesheet" href="{{asset('css/email.css')}}">
    <style>

    </style>

@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-4 col-sm-12 col-xs-12 pb-1">
                        <h5 id="page_name">{{$page_name}}
                            @if($page_name==="Search results")
                                for "{{$query}}"
                            @endif
                        </h5>
                        <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12 pb-1">
                        @if($page_name !== "Search results")
                        <form class="form-inline float-right" method="post" action="{{route('email.search')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" name="search" class="form-control" placeholder="Search">
                                <input type="hidden" name="page_name" value="{{$page_name}}">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-warning">Submit</button>
                            </div>

                        </form>
                            @endif
                    </div>
                </div>
            </div>
            <div class="card-body p-1">
                <div class="card-body p-1">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <button class="btn btn-sm btn-warning" id="selectAll">Select all</button>
                            @if($page_name==="Trash")
                            <button class="btn btn-sm btn-danger" id="foreverDelBtn">Delete forever</button>
                            <button class="btn btn-sm btn-success" id="restoreBtn">Restore</button>
                            @endif
                            @if($page_name!=="Trash")
                                <button class="btn btn-sm btn-danger" id="delBtn">Delete selected</button>
                            @endif
                            <button class="btn btn-sm btn-primary" onclick="return location.reload()">Refresh page</button>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="float-left">
                                <a class="btn btn-sm btn-new " role="button" href="{{route('email.compose')}}">Compose new email</a>
                            </div>

                            <div class="float-right">
                                <a href="{{$emails->nextPageUrl()}}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Next page">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                <a href="{{$emails->previousPageUrl()}}" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="top" title="Previous page">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

                ?>
                <div class="card-body p-1">
                    <table class="table table-responsive-md">
                        <tbody >
                    <?php
                        if($emails->count()>0){
                            if($page_name==="Inbox" || ($page_name==="Search results" && $page_from==="Inbox")){
                                foreach($emails as $email){
                                    $hashid=$email->hashid;
                                    $unread=$email->was_read ? null : "class=unread";
                                    $star=$email->important_receiver ? 'fas' : 'far';
                                    $user=$email->getUsersName($email->sender);
                                    $route="email.show";
                                    $title=$email->title;
                                    $date=$email->showDate(true);

                                    ?> @include('/admin/mail/table-mail') <?php
                                    }//endforeach
                            }elseif($page_name==="Sent" || $page_name==="Drafts" || ($page_name==="Search results" && ($page_from==="Sent" || $page_from==="Drafts"))){
                                foreach($emails as $email){
                                    $hashid=$email->hashid;
                                    $unread= null;
                                    $star=$email->important_sender ? 'fas' : 'far';
                                    $user=$email->getUsersName($email->receiver);
                                    $route=$page_name==="Sent" ? "email.show": "email.edit";
                                    $title=$email->title;
                                    $date=$email->showDate(true);

                                ?> @include('/admin/mail/table-mail') <?php
                                }//endforeach
                            }elseif($page_name==="Trash" || ($page_name==="Search results" && $page_from==="Trash")){
                                    foreach($emails as $email){
                                    $hashid=$email->hashid;
                                    $unread= $email->receiver ===Auth::id() && $email->was_read===0 ? "class=unread" : null ;
                                    $star=($email->important_sender && $email->sender===Auth::id()) || ($email->important_receiver && $email->receiver===Auth::id()) ? 'fas' : 'far';
                                    $user=$email->sender===Auth::id() ? $email->getUsersName($email->receiver) : $email->getUsersName($email->sender);
                                    $route="email.show";
                                    $title=$email->title;
                                    $date=$email->showDate(true);

                                    ?> @include('/admin/mail/table-mail') <?php
                                    }//endforeach
                            }//end if page name
                        }else{
                            ?><tr><td>There are no emails in this box</td></tr> <?php
                        }//end if email->count

                            ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script>
    function c(x){
        console.log(x);
    }

    let favorites=document.getElementsByClassName('email-favorite');
    let page_name=document.getElementById('page_name').innerText;
    let token=document.getElementById('token').content;
    let checkboxes=document.getElementsByClassName('checkbox');
    let selectAll=document.getElementById('selectAll');
    let delBtn=document.getElementById('delBtn');
    addFavoriteListeners();
    //addDeleteListener();

/********* delete mails *********/

    //when clicked, toggle select all checkboxes or deselect all checkboxes
    selectAll.addEventListener('click', function(){
        toggleSelect();
    });

    function toggleSelect(){
        if(selectAll.innerText==="Select all"){
            for(let x=0; x<checkboxes.length; x++){
                checkboxes[x].checked=true;
                selectAll.innerText="Deselect all";
            }
        }else{
            for(let x=0; x<checkboxes.length; x++){
                checkboxes[x].checked=false;
                selectAll.innerText="Select all";
            }
        }

    }

    delBtn.addEventListener('click', function(){
        removeChecked('/admin/email/delete');
    });

    //loops through all rows to see if child element input has checked===true. all with checked===true are placed in
    //checkedArr (contains hashids)and then sent to backend to be deleted or restored
    function removeChecked(url){
        let checkedArr=[];
        let trsToBeRemoved=[];
        for(let i=0; i<checkboxes.length; i++){
            if(checkboxes[i].checked===true){
                checkedArr.push(checkboxes[i].parentElement.parentElement.getAttribute('data-id'));
                trsToBeRemoved.push(checkboxes[i].parentElement.parentElement);
            }
        }

        if(checkedArr.length>0){
            ajax('post', url , "&hashids="+checkedArr, removeRows, trsToBeRemoved)
        }
    }


    function removeRows(success, obj, trsToBeRemoved){
        if(success){

            //we put all removed hashids (received from server) to array
            let removedHashids=[];
            for(let i=0; i<obj[1].length; i++){
               // c(obj[1][i]); ok
               // c(trsToBeRemoved.length) ok
                removedHashids.push(obj[1][i]);
            }
            let trLength=trsToBeRemoved.length;
            //loop throuht all table rows that should be removed and ask if tr data-id is in array of removed hashids
            for(let i=0; i<trLength; i++){
                //if it exists, remove the row
                if(removedHashids.indexOf(trsToBeRemoved[i].getAttribute('data-id') !=0)){
                    trsToBeRemoved[i].remove();
                }
            }
        }
    }
/****** end delete mails *********/

/************* favorite mails ************/
    function addFavoriteListeners() {
        for (let i = 0; i < favorites.length; i++) {
            favorites[i].addEventListener('click', function () {
                var evTarget=event.target;
                var hashid = evTarget.parentElement.parentElement.getAttribute('data-id');
                ajax('POST', '/admin/email/favorite/'+hashid, "", changeStar, evTarget);
            });
        }
    }

    //depending on server response, it will change star of the event target
    function changeStar(success, obj, evTarget){

        if(success){
            //if hashid received from server is the same as hashid of parent of event target

            if(obj.success===evTarget.parentElement.parentElement.getAttribute('data-id')){
                //update star
                if(evTarget.classList.contains('fas')){
                    evTarget.classList.remove('fas');
                    evTarget.classList.add('far');
                }else{
                    evTarget.classList.remove('far');
                    evTarget.classList.add('fas');
                }
            }
        }
    }
/****** end favorite mails ******************/
    function ajax(method, url, params, callback, callbackParams){
        var http;

        if(window.XMLHttpRequest){
            http=new XMLHttpRequest();
        }else{
            http=new ActiveXObject("Microsoft.XMLHTTP");
        }

        http.onreadystatechange=function(){
            if(http.readyState==XMLHttpRequest.DONE){
                if(http.status==200){
                    var response=http.responseText;
                    var obj=JSON.parse(response);
                    callback(true, obj, callbackParams);
                }else if(http.status==400){
                    response=http.responseText;
                    obj=JSON.parse(response);
                    callback(false, obj);
                }
            }
        }
        http.open(method, url, true);
        http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        http.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        http.send(params+"&_token="+token);

    }

</script>
    @if($page_name==="Trash")
<script>
    document.getElementById('restoreBtn').addEventListener('click', function(){
        removeChecked('/admin/email/restore');
    });

    document.getElementById('foreverDelBtn').addEventListener('click', function(){
        removeChecked('/admin/email/destroy');
    });

</script>
    @endif
@endsection