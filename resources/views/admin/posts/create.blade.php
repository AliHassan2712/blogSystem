@extends('admin.layouts')

@section('css')

@endsection

@section('title', 'Posts')

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create Post</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form-reset">
                <div class="card-body">
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Enter post content ..."></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="storeItem('/admin/posts')" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script>
        function storeItem(url) {
            let formatDate = new FormData();
            formatDate.append('content', document.getElementById('content').value);

            axios.post(url, formatDate)
                .then(function(response) {
                    console.log(response.data.message);
                    toastr.success(response.data.message);
                    document.getElementById('form-reset').reset();
                    window.location.href = '/admin/posts';
                })
                .catch(function(error) {
                    console.log(error.response.data.message);
                    toastr.error(error.response.data.message)
                });
        }
    </script>
@endsection()
