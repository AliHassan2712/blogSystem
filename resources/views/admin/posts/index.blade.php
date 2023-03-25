@extends('admin.layouts')

@section('css')

@endsection

@section('title', 'Posts')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Posts Table</h3>
                <a href="{{ route('posts.create') }}" class="btn btn-success float-right">New Post</a>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Content</th>
                            <th>Likes No.</th>
                            <th>Comments No.</th>
                            <th>USer Id</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <th>{{ $post->id }}</th>
                                <th>{{ $post->content }}</th>
                                <th>{{ $post->likes_no }}</th>
                                <th>{{ $post->coments_no }}</th>
                                <th>{{ $post->user_id }}</th>
                                <th>{{ $post->created_at }}</th>
                                <th>{{ $post->updated_at }}</th>
                                <th>
                                    <div class="btn-group">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-info">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="deleteItem('/admin/posts/', this, {{ $post->id }})"
                                            class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">«</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function deleteItem(url, ref, id) {
            Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(url + id)
                            .then(function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    response.data.message,
                                    'success'
                                )
                                ref.closest('tr').remove();
                            })
                            .catch(function(error) {
                                Swal.fire(
                                    'Error!',
                                    error.response.data.message,
                                    'error'
                                )
                            });
                    }
                })
        }
    </script>
@endsection()

