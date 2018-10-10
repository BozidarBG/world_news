@extends('layouts.admin.adminlayout')
@section('styles')
    <style>
        .input-text{
            background:none !important;
            box-shadow:none;
            border:none;
        }

    </style>
@endsection
@section('content')

    <div class="row">
        <meta name="csrf-token" content="{{ csrf_token() }}" id="token">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Categories</div>
            </div>
            <div class="row ">
                <div class="col-md-8 col-sm-12 col-xs-12 mt-2">
                    <div class="card">
                        <table class="table">
                            <thead class="thead-light">
                            <tr>
                                <th>Category Name</th>
                                <th>Importance</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody id="main_table">
                            @foreach($categories->all() as $category)
                                <tr data-id="{{$category->id}}">
                                    <td><input type="text" value="{{$category->title}}" class=" form-control input-text" disabled/></td>
                                    <td><input type="number" value="{{$category->importance}}" class="form-control input-text " disabled/></td>
                                    <td><a href="#" class="btn btn-info btn-sm">Edit</a></td>
                                    <td><a href="#" class="btn btn-danger btn-sm">Delete</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 mt-2">
                    <div class="card">
                        <div class="card-header">
                            <h4>Create Category</h4>
                        </div>
                        <div class="card-body">
                            <div id="add_category">
                                <div class="form-group">
                                    <label for="title">Category Name</label>
                                    <input type="text" name="title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="importance">Importance</label>
                                    <input type="number" name="importance" class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="text-center">
                                        <button type="submit" name="submit" id="create_category" class="btn btn-default">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        let token=document.getElementById('token').content;

        function addEditAndDeleteListeners(){
            let editBtns=document.getElementsByClassName('btn-info');
            for(let i=0; i<editBtns.length; i++){
                editBtns[i].addEventListener('click', editListener, true);
            }
            let deleteBtns=document.getElementsByClassName('btn-danger');
            for(let i=0; i<deleteBtns.length; i++){
                deleteBtns[i].addEventListener('click', deleteListener, true);
            }
        }
        //dajemo edit i delete listenere na početku svima
        addEditAndDeleteListeners();

        //UPDATE CATEGORY
        //svako dugme dobija po jedan ovakav listener
        function editListener(){
            event.preventDefault();
            //skidamo svima edit listener
            let editBtns=document.getElementsByClassName('btn-info');
            for(let i=0; i<editBtns.length; i++){
                editBtns[i].removeEventListener('click', editListener, true);
            }
            let editBtn=event.target;
            //console.log(editBtn);
            let tableRow=editBtn.parentElement.parentElement; //td data-id=5 iz baze
            let clickId=tableRow.getAttribute('data-id');
            //uzimamo stare vrednosti
            let oldName=tableRow.children[0].children[0].value;
            let oldImportance=tableRow.children[1].children[0].value;
            //uzimamo sve buttons koji imaju klasu cancel i dajemo event listener returnToEdit
            let cancelBtns=document.getElementsByClassName('cancel');

            //skidamo disabled i input-text sa name i importance
            tableRow.children[0].children[0].removeAttribute('disabled');//input name
            tableRow.children[0].children[0].classList.remove('input-text');
            tableRow.children[1].children[0].removeAttribute('disabled'); //input importance
            tableRow.children[1].children[0].classList.remove('input-text');
            //menjamo Edit u Cancel i menjamo mu klase
            let cancelBtn="<td><a href='#' class='btn btn-warning btn-sm cancel'>Cancel</a></td>";
            tableRow.children[2].innerHTML=cancelBtn;

            //menjamo Delete u Save i menjamo klase
            let saveBtn="<td><a href='#' class='btn btn-success btn-sm save'>Save</a></td>";
            tableRow.children[3].innerHTML=saveBtn;
            //uzimamo sve buttons koji imaju klasu save i dajemo event listener saveData
            let saveBtns=document.getElementsByClassName('save');
            for(let x=0; x<saveBtns.length; x++){
                saveBtns[x].addEventListener('click', saveData, true);
            }
            for(let y=0; y<cancelBtns.length; y++){
                cancelBtns[y].addEventListener('click', cancelEdit, true);
                cancelBtns[y].oldN=oldName;
                cancelBtns[y].oldI=oldImportance;

            }

        }

        function cancelEdit(){
            event.preventDefault();
            let editBtn=event.target;
            //ukoliko se klikne edit, nešto promeni, ne usnimi a klikne cancel,moramo da vratimo na stare vrednosti
            let tableRow=event.target.parentElement.parentElement;

            tableRow.children[0].children[0].value=event.target.oldN;
            oldImportance=tableRow.children[1].children[0].value=event.target.oldI;


            //let tableRow=editBtn.parentElement.parentElement; //td data-id=id iz baze
            tableRow.children[0].children[0].setAttribute('disabled', true);
            tableRow.children[0].children[0].classList.add('input-text');
            tableRow.children[1].children[0].setAttribute('disabled', true);
            tableRow.children[1].children[0].classList.add('input-text');
            tableRow.children[2].innerHTML='<a href="#" class="btn btn-info btn-sm">Edit</a>';
            tableRow.children[3].innerHTML="<td><a href='#' class='btn btn-danger btn-sm save'>Delete</a></td>";
            //moramo ponovo event listenere da damo za sve
            addEditAndDeleteListeners();
        }
        function showToastr(val, success){
            if(success){
                toastr.success('Category updated successfully!')
            }else{
                toastr.error('Something went wrong!')
            }
        }
        function saveData(){
            event.preventDefault();
            let tableRow=event.target.parentElement.parentElement;
            let id=tableRow.getAttribute('data-id');
            let newName=tableRow.children[0].children[0].value;
            let newImportance=tableRow.children[1].children[0].value;
            if(id && newName.trim() && newImportance.trim()){
                //šaljemo ajax request
                ajax("POST", "/admin/categories/update/"+id, "title="+newName+"&importance="+newImportance, showToastr, null)

            }//if
            tableRow.children[0].children[0].setAttribute('disabled', true);
            tableRow.children[0].children[0].classList.add('input-text');
            tableRow.children[1].children[0].setAttribute('disabled', true);
            tableRow.children[1].children[0].classList.add('input-text');
            tableRow.children[2].innerHTML='<a href="#" class="btn btn-info btn-sm">Edit</a>';
            let deleteBtn="<td><a href='#' class='btn btn-danger btn-sm save'>Delete</a></td>";
            tableRow.children[3].innerHTML=deleteBtn;
            addEditAndDeleteListeners();
        }//saveData


        // END UPDATE

        //CREATE & INDEX GET
        let createForm=document.getElementById('add_category');

        const showCreatedRow=(val, success, data)=>{
            //console.log(success, data)
            if(success){
                let newRow=`
            <tr data-id="${data.id}">
                        <td><input type="text" value="${data.title}" class=" form-control input-text" disabled/></td>
                <td><input type="number" value="${data.importance}" class="form-control input-text" disabled/></td>
                <td><a href="#" class="btn btn-info btn-sm">Edit</a></td>
                        <td><a href="#" class="btn btn-danger btn-sm">Delete</a></td>
                        </tr>
                      `;
                document.getElementById('main_table').innerHTML+=newRow;
                addEditAndDeleteListeners()
            }
        }

        function newCategoryCreated(val, success, obj){
            //console.log(val, success, obj);
            if(success){
                toastr.success('Category created successfully!');
                ajax("GET", "/admin/categories",null, showCreatedRow, null)
            }
        }

        //početak create
        let createCategory=document.getElementById('create_category');
        createCategory.addEventListener('click', function(){
            event.preventDefault();
            //let formToken=document.getElementById('token');

            let title=createForm.children[0].children[1].value;
            let importance=createForm.children[1].children[1].value;
            if(title.trim() && importance.trim()){
                //šaljemo ajax request
                ajax("POST", "/admin/categories", "title=" + title+"&importance="+importance, newCategoryCreated, null);


                //čistimo formu
                createForm.children[0].children[1].value="";
                createForm.children[1].children[1].value="";

            }

        });
        //END CREATE & INDEX GET

        //DELETE

        function ajax(method, url, params, callback, callbackParams){
            let http=new XMLHttpRequest();
            http.onreadystatechange=function(){
                if(http.readyState==XMLHttpRequest.DONE){
                    if(http.status==200){ //sve je ok
                        var obj=JSON.parse(http.responseText);
                        callback(callbackParams, true, obj); //true za success
                        // callback(true, obj);
                    }else if(http.status==400){//imamo neki error
                        var obj=JSON.parse(http.responseText);
                        callback(false, obj.message); //false za bilo je problema
                    }else{
                        callback(false, 'There was some error');

                    }
                }

            }

            http.open(method, url, true);
            http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            http.setRequestHeader('X-Requested-With', 'XMLHttpRequest'); //ovo laravelu daje do znanja da je ovo ajax req
            http.send(params+"&_token="+token);
        }


        function deleteListener(){
            event.preventDefault();

            //uzimamo id
            let tableRow=event.target.parentElement.parentElement; //td data-id=id iz baze
            let id=tableRow.getAttribute('data-id');
            //console.log(id)
            confirm('Are you sure that you want to delete this category?')
            if(id ){

                //šaljemo ajax request
                ajax('POST', '/admin/categories/delete/'+id, null, categoryDeleted, tableRow);
            }//if a izmedju je bio jquery ajax
        }
        //ako je ok, onda izbaciti zadnji red
        //success treba da primi true ili false
        function categoryDeleted(rowToDelete, success, responseArr){

            if(responseArr[0]==="success"){
                rowToDelete.style.background="red";
                setTimeout(function(){
                    rowToDelete.remove();
                    toastr.success('Category deleted successfully!');
                    //ako imamo paginaciju, ajax će napraviti problem, zato bolje da reload
                    //location.reload();
                },300);
            }else if(responseArr[0]==="posts"){
                toastr.error('Category could not be deleted because there are posts for this category!');
            }else{
                toastr.error('There was some error!');
            }
        }

        //END DELETE




    </script>
@endsection