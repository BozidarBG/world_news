@extends('layouts.admin.adminlayout')

@section('styles')

@endsection

@section('content')



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Create New Article
                </div>

                <div class="card-body">
                    @include('admin.includes.errors')
                    <form action="{{route('articles.store')}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" value="{{old('title')}}">
                        </div>

                        <div class="form-group">
                            <label for="photo">Photo</label>
                            <input type="file" name="photo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="category">Select a Category</label>
                            <select id="category" name="category"   class="form-control" value="{{old('category')}}">
                                <option value="">Please select</option>
                                @if(count($categories))
                                    @foreach($categories->all() as $category)
                                        <option  value="{{$category->id}}" {{ old('category') == $category->id ? 'selected' : '' }}>{{$category->title}}</option>
                                    @endforeach
                                @else
                                    <option>error</option>
                                @endif
                            </select>
                        </div>

                        <div class="form-group" >
                            <label for="body">Content</label>
                            <textarea  name="body"  class="form-control">{!! old('body')!!}</textarea>
                        </div>


                        <div class="form-group">
                            <div class="text-center">
                                <button type="submit" name="send" class="btn btn-success">Send for approval</button>
                                &nbsp; &nbsp;or&nbsp; &nbsp;
                                <button type="submit" name="save" class="btn btn-warning">Save to drafts</button>
                            </div>
                        </div>


                    </form>
                </div>


            </div>
        </div>
    </div>

    @endsection



@section('scripts')

    <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'body' );
        CKEDITOR.config.removePlugins = 'image';
    </script>

    @endsection