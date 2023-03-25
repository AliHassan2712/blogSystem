@extends('admin.layouts')

@section('css')

@endsection

@section('title', 'Create comments')

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create comment</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form-reset">
                <div class="card-body">
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Enter post content ..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="post_id">Post ID</label>
                        <input type="number" name="post_id" class="form-control" id="post_id"
                            placeholder="Enter post_id" >
                    </div>
                    <div class="form-group">
                        <label for="user_id">USer ID</label>
                        <input type="number" name="user_id" class="form-control" id="user_id"
                            placeholder="Enter user_id" >
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="storeItem('/admin/comments')" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function storeItem(url) {
            let formatDate = new FormData();
            formatDate.append('post_id', document.getElementById('post_id').value);
            formatDate.append('content', document.getElementById('content').value);
            formatDate.append('user_id', document.getElementById('user_id').value);

            axios.post(url, formatDate)
                .then(function(response) {
                    console.log(response.data.message);
                    toastr.success(response.data.message);
                    document.getElementById('form-reset').reset();
                    window.location.href = '/admin/comments';
                })
                .catch(function(error) {
                    console.log(error.response.data.message);
                    toastr.error(error.response.data.message)
                });
        }
    </script>
@endsection()
