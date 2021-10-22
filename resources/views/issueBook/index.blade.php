<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                       <li class="nav-item">
                            <a class="nav-link" href="{{route('member.index')}}">Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('book.index')}}">Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('issueBook.index')}}">Issue Book</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>   
<div class="container">
    <h1>Issue Book Management</h1>
    <br>
    <br>
    <br>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Create New</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Member</th>
                <th>Book</th>
                <th>Issue Date</th>
                <th>Return Date</th>
                <th>Is Return</th>
                <th>Issued By</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
   
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="alert alert-danger print-error-msg" style="display:none">
                <ul></ul>
            </div>
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="productForm" name="productForm" class="form-horizontal">
                   <input type="hidden" name="product_id" id="product_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Member</label>
                        <div class="col-sm-12">
                        <select class="form-control" name="member_id" id="member_id">
                             
                        </select>
                        </div>
                    </div>
     
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Book</label>
                        <div class="col-sm-12">
                        <select class="form-control" name="book_id" id="book_id">
                            
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Issue Date</label>
                        <div class="col-sm-12">
                        <input type="date" class="form-control" id="issue_date" name="issue_date" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Return Date</label>
                        <div class="col-sm-12">
                        <input type="date" class="form-control" id="return_date" name="return_date" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Is Returned</label>
                        <div class="col-sm-12">
                        <select class="form-control" name="is_return" id="is_return">
                            <option selected disabled>Select Option</option>    
                            <option value="1">returned</option>
                            <option value="0">not returned</option>
                        </select>
                        </div>
                    </div>
      
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                     </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
</body>
    
<script type="text/javascript">
  $(function () {
     
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('issueBook.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'member', name: 'member.name'},
            {data: 'book', name: 'book.book_name'},
            {data: 'issue_date', name: 'issue_date'},
            {data: 'return_date', name: 'return_date'},
            {data: 'isReturn', name: 'isReturn.is_return'},
            {data: 'createdBy', name: 'createdBy.name'},
            {data: 'action', name: 'action', orderable: false, searchable: false, target:0},
        ]
    });
     
    $('#createNewProduct').click(function () {

        $.ajax({
          type:"get",
          url: "{{ route('all-members') }}",
          success: function (data) {
            console.log(data);
            $("#member_id").empty();
            $("#member_id").append('<option selected disabled>Select Member</option>');
                $.each(data,function(key, value){
                    console.log('id', data);
                    // console.log('name', data.name);
                    $("#member_id").append('<option value="'+key+'">'+value+'</option>');
                });
         
          }
      });

      $.ajax({
          type:"get",
          url: "{{ route('all-books') }}",
          success: function (data) {
            console.log(data);
            $("#book_id").empty();
            $("#book_id").append('<option selected disabled>Select Book</option>');
                $.each(data,function(key, value){
                    $("#book_id").append('<option value="'+key+'">'+value+'</option>');
                });
         
          }
      });

        $('#saveBtn').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#modelHeading').html("Create New Product");
        $('#ajaxModel').modal('show');
    });
    
    $('body').on('click', '.editProduct', function () {
      var product_id = $(this).data('id');
      $.get("{{ route('issueBook.index') }}" +'/' + product_id +'/edit', function (data) {
          $('#modelHeading').html("Edit Product");
          $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          $('#product_id').val(data.id);
          $('#member_id').val(data.member_id);
          $('#book_id').val(data.book_id);
          $('#issue_date').val(data.issue_date);
          $('#return_date').val(data.return_date);
          $('#is_return').val(data.is_return);
      })
   });
    
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');
    
        $.ajax({
          data: $('#productForm').serialize(),
          url: "{{ route('issueBook.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
            if($.isEmptyObject(data.error)){
              $('#productForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              
              table.draw();
            //   location.reload();
                
            }else{
                printErrorMsg(data.error);
                console.log('Error:', data);
            }
         
          }
        //   error: function (data) {
        //       console.log('Error:', data);
        //       $('#saveBtn').html('Save Changes');
        //   }
      });
      function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }
    });
    
    $('body').on('click', '.deleteProduct', function () {
     
        var product_id = $(this).data("id");
        confirm("Are You sure want to delete !");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('issueBook.store') }}"+'/'+product_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
     
  });
</script>
</html>