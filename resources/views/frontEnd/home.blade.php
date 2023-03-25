<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

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
<body>

    <nav class="navbar navbar-expand navbar-primary navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('userHome')}}" class="nav-link">Home</a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('addPost')}}" class="nav-link">Add Post</a>
          </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
          <!-- Navbar Search -->
          <li class="nav-item">
            <a class="nav-link" href="{{route('user.logout')}}">
              Logout
            </a>
           
          </li>


      </nav>

<div>
<div class=" m-3"> 

   
    @foreach ($posts as $post) 
    
    <input type="text" style="display: none" id="user_id" value="{{Auth::user()->id}}">
    <input type="text" style="display: none" id="post_id" value="{{$post->id}}">


    <div class="container">
    <div class="post ">
        <div class="user-block">
            
        
          <img class="img-circle img-bordered-sm" src="{{Storage::url('users/'.$post->user->cover) }}" alt="user image">
          <span class="username">
            <a href="#">{{$post->user->name}}</a>
          
<div class="btn-group float-right btn-tool">
          <div style="display: {{Auth::user()->id == $post->user->id? 'block': 'none'}}" class="">
            <button  onclick="deleteItem('/user/delete/', this, {{ $post->id }})"
                class="btn btn-danger  ">
                <i class="fas fa-trash"></i>
            </button>

            <a href="{{route('editPost',$post->id)}}" 
              class="btn btn-info  ">
              <i class="fas fa-pen"></i>
          </a>

        </div>
      </div>
          </span>
          <span class="description">{{$post->created_at}}</span>
        </div>
        <!-- /.user-block -->
        <p>
         {{$post->content}}
        </p>

        <p>
          <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
          <span class="float-right">

            <a class="link-black text-sm ml-3" style="cursor: pointer" onclick="toggle({{$post->id}})">
              <i class="far fa-comments mr-1"></i> Comments ({{count($post->comments)}})
          </a> 
          </span>
        </p>

        <div class="input-group input-group-sm">

          <input type="text" class="form-control" id="content">
          <span class="input-group-append">
            <button type="button" class="btn btn-info btn-flat" onclick="storeItem('/user/comment')">send</button>
          </span>
        </div>
        
      </div>
   
    </div>

    <div id="content-{{$post->id}}" style="margin: auto; display:none;">

      @foreach ($post->comments as $comment )

      <div class="container">
          <div class="row mb-2" >
              <div class="col-10" style="margin: auto">
                  <div class="card card-white post" style="padding: 10px">
                      <div class="post-heading">
                          <div class="float-left image">
                              <img src="{{Storage::url('users/'.$comment->user->cover)}}" width="40px" height="40px" class="img-circle avatar" alt="user profile image">
                          </div>
                          <div class="float-left meta">
                              <div class="title h5">
                                  <a href="#" class="ml-2" style="font-size:16px"><b>{{$comment->user->name}} </b></a>

                              </div>
                              <p class="text-muted time" style="font-size:16px">{{$comment->created_at}}</p>
                          </div>
                      </div>
                      <div class="post-description" style="padding: 10px">
                          <p>{{$comment->content}} </p>

                      </div>
                  </div>
              </div>

          </div>
      </div>

      @endforeach

    </div>

</div>

</div>
    @endforeach



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
                  window.location.href = '/user/';
                              })
              .catch(function(error) {
                  console.log(error.response.data.message);
                  toastr.error(error.response.data.message)
              });
      }
  </script>
    
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
                            window.location.href = '/user/';

                              Swal.fire(
                                  'Deleted!',
                                  response.data.message,
                                  'success',
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
  
  
  <script>
    function editItem(url) {
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

<script>

  function toggle(id){
      var content = document.getElementById("content-"+id);

      if (content.style.display === "none") {
          content.style.display = "block";
      } else {
          content.style.display = "none";
      }



  }
</script>
    <!-- jQuery -->
    <script src="{{ asset('cms/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('cms/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('cms/dist/js/adminlte.min.js') }}"></script>

    <script src="{{ asset('cms/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('cms/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset('js/sweet.js') }}"></script>

    @yield('script')


</body>
</html>