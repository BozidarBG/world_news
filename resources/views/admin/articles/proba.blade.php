<div class="col-md-4">
    <div class="card w-33">
        <form action="{{route('articles.moderator-article-position', ['id'=>$article->id])}}" method="post" >
            {{csrf_field()}}
            <div class="card-header bg-danger ">
                <h5 class="text-white text-center">Important articles</h5>
            </div>
            <div class="card text-center p-4">
                <label for="where">Slider or Aside</label>
                <select class="mt-4 mb-4 " name="where">
                    <option value="">Select where to put</option>
                    <option value="1">Slider</option>
                    <option value="2">Aside</option>
                </select>
                <br>
                <label for="position">Position</label>
                <select class="mt-4 mb-4 " name="position">
                    <option value="">Select position</option>
                    <option value="1">First</option>
                    <option value="2">Second</option>
                    <option value="3">Third</option>
                    <option value="4">Fourth</option>
                </select>
                <br>
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-info">Update importants</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="col-md-8">
    <div class="card w-64 mb-4">
        <div class="card-header bg-warning">
            <h5 class="text-white text-center">Current important articles with positions</h5>
        </div>
        <div class="card-body">
            <h5 class="card-title">
                Slider:
            </h5>
            <div class="row">
                <div class="col-md-1">1</div>
                <div class="col-md-11">dfasdfadfad af asdf asdf asd fadsf </div>
            </div>
            <br>
            <h5 class="card-title">
                Aside:
            </h5>
            <div class="row">
                <div class="col-md-1">1</div>
                <div class="col-md-11">dfasdfadfad af asdf asdf asd fadsf </div>
            </div>
        </div>
    </div>
</div>
