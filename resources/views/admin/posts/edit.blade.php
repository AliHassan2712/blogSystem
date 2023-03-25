@extends('admin.layouts')

@section('css')

@endsection

@section('title', 'Edit post')

@section('content')
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit post</h3>
            </div>
            <!-- form start -->
            <form id="form-reset">
                <div class="card-body">
                    <div class="form-group">
                        <label>Content</label>
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Enter post content ...">{{ $post->content }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="updateItem('/admin/posts/'+{{ $post->id }})"
                        class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateItem(url) {
            let formatDate = new FormData();
            formatDate.append('_method', 'put');
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
@endsection
