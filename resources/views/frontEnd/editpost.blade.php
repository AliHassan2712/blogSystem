<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AdminLTE 3 | @yield('title')</title>
    
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('cms/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('cms/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="{{ asset('cms/plugins/toastr/toastr.min.css') }}">
        <link rel="stylesheet" href="{{ asset('cms/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        @yield('css')
    </head>
    
</head>
<body>
    
    <div class="container">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">update Post</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="form-reset">
                <div class="card-body">
                    <div class="form-group">
                        <label>Content</label>
                        <input type="text" style="display: none" id="user_id" value="{{Auth::user()->id}}">
                        <textarea class="form-control" name="content" id="content" rows="3" placeholder="Enter post content ...">{{$post->content}}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" onclick="updateItem('/user/update/'+{{ $post->id }})"
                        class="btn btn-primary">update</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/sweet.js') }}"></script>

    <script>
        function updateItem(url) {
            let formatDate = new FormData();
            formatDate.append('_method', 'put');
            formatDate.append('content', document.getElementById('content').value);
            formatDate.append('user_id', document.getElementById('user_id').value);

            axios.post(url, formatDate)
                .then(function(response) {
                    console.log(response.data.message);
                    toastr.success(response.data.message);
                    document.getElementById('form-reset').reset();
                    window.location.href = '/user/';
                })
                .catch(function(error) {
                    console.log(error.response.data.message);
                    toastr.error(error.response.data.message)
                });
        }
    </script>
</body>



</html>