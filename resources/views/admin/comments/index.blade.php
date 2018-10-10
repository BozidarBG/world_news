@extends('layouts.admin.adminlayout')

@section('styles')
<style>
    .table-comments th:nth-child(1){
         width: 5%;
     }
    .table-comments th:nth-child(2){
        width: 15%;
    }
    .table-comments th:nth-child(3){
        width: 60%;
    }
    .table-comments th:nth-child(4), .table-comments th:nth-child(5){
        width: 10%;
    }

</style>
    @endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" id="page_name">
                {{$page_name}}
            </div>
            <div class="card-body">
            @if($items->count()>0)
                    {!! csrf_field() !!}
            <table class="table table-comments">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Link</th>

                        <th>Body</th>
                        @if($page_name==="Unapproved comments" || $page_name==="Unapproved replies")
                        <th>Approve</th>
                        @elseif($page_name==="Approved comments" || $page_name==="Approved replies")
                        <th>Unpprove</th>
                        @endif
                        <th>Delete</th>

                    </tr>
                </thead>

                <tbody>
                @foreach($items as $item)
                    <tr data-id="{{$item->id}}">
                        <td>{{$item->id}}</td>
                        <?php
                        if($page_name==="Unapproved comments" || $page_name==="Approved comments"){
                            $category_slug=$item->article->category->slug;
                            $article_slug=$item->article->slug;
                        }elseif($page_name==="Unapproved replies" || $page_name==="Approved replies"){
                            $category_slug=$item->comment->article->category->slug;
                            $article_slug=$item->comment->article->slug;
                        }else{
                            $category_slug="#";
                            $article_slug="#";
                        }

                        ?>
                        <td><a href="{{route('show', ['category_slug'=>$category_slug, 'article_slug'=>$article_slug])}}">View article</a></td>
                        <td class="field-width">{{$item->body}}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm edit">
                                @if($page_name=='Unapproved comments' || $page_name=='Unapproved replies')
                                    Approve
                                @elseif($page_name==="Approved comments" || $page_name=='Approved replies')
                                    Unapprove
                                @endif
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm del" role="button" onclick=" return confirm('Are you sure that you want to delete this?')">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
            </div>
        </div>
    @else
        <h4>There are no items in this category</h4>
    @endif

    @if($items->perPage()<$items->total())
        <nav class="text-center">
            <ul class="pagination justify-content-center">
                {{$items->render()}}
            </ul>
        </nav>
    @endif



    </div> <!--end col md 12-->
</div> <!--end row-->


    @endsection

@section('scripts')
    @if($page_name=='Unapproved comments' || $page_name=='Approved comments')
        <script>
            let updateUrl="/admin/comments/update";
            let deleteUrl="/admin/comments/destroy";
        </script>
    @elseif($page_name==="Unapproved replies" || $page_name=='Approved replies')
        <script>
            let updateUrl="/admin/replies/update";
            let deleteUrl="/admin/replies/destroy";
        </script>
    @endif
    <script>
        let token=document.querySelector('input[name=_token]').value;
        let edits=document.getElementsByClassName('edit');
        let deletes=document.getElementsByClassName('del');
        let pageName=document.getElementById('page_name');
        addEditListeners();
        addDeleteListeners();

        function addEditListeners(){
            for(let i=0; i<edits.length; i++){
                edits[i].addEventListener('click', function(e){
                    sendAjaxRequest(e,updateUrl);
                });
            }
        }

        function addDeleteListeners(){
            for(let i=0; i<deletes.length; i++){
                deletes[i].addEventListener('click', function(e){
                    sendAjaxRequest(e, deleteUrl);
                });
            }
        }
        function sendAjaxRequest(e, url){
            e.preventDefault();
            let id=e.target.parentElement.parentElement.getAttribute('data-id');
            let rowToBeRemoved=e.target.parentElement.parentElement;

            ajax('POST', url, 'id='+id, removeLine, rowToBeRemoved);
        }


        //accepts boolean, response obj and <tr> to be removed
        function removeLine(success, obj, eventTarget){
            let response=obj;
            if(success){
                let rowToDelete=eventTarget;
                rowToDelete.style.background="red";
                setTimeout(function(){
                    rowToDelete.remove();
                    toastr.success(response.success);
                },500);
            }else{
                toastr.error(response.error);
            }
        }

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


@endsection