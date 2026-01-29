@extends('admin.layouts.master')
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
@section('content')

<div class="container-fluid">

  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Users</h1>
  <div class="row">
      <div class="col" style="margin-top: 20px;">
          @if (Session::has('message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ Session('message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span class="fa fa-times"></span>
                  </button>
              </div>
          @endif

          @if (Session::has('delete-message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ Session('delete-message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span class="fa fa-times"></span>
                  </button>
              </div>
          @endif
      </div>
  </div>
  <div class="pull-right">
      <a type="button" href="{{ route('users.create') }}" class="btn btn-primary">Add User</a>
  </div>

  <br>
  <div class="card shadow mb-4">

      <div class="card-body p-t-10 searchFilters">
          <div class="row">
              <div class="col-md-3">
                  <div class="form-group">
                      <label for="filter_name" class="control-label">Name</label>
                      <input type="text" class="form-control" id="filter_name">
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label for="filter_email" class="control-label">Email</label>
                      <input type="text" class="form-control" id="filter_email">
                  </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                      <label for="filter_role" class="control-label">Role</label>
                      <select name="role" id="filter_role" class="form-control">
                        <option value=""> -Role- </option>
                        <option value="Merchant">Merchant</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                    </select>
                  </div>
              </div>
          </div>
      </div>
      
  </div>
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Users</h6>

      </div>

      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-hover table-condensed table-responsive-block table-responsive" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                          <th></th>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Actions</th>
                      </tr>
                  </thead>

                  <tbody>
                      <tr>
                          <td></td>
                      </tr>


                  </tbody>
              </table>
          </div>
      </div>
  </div>

</div>
@endsection
@section('js')
    <script>
        $(document).ready(function(e) {
            var table = $('#dataTable');
            $.fn.dataTable.ext.errMode = 'none';

            var user_datatable = table.DataTable({
                "serverSide": true,
                "sDom": '<"H"lfr>t<"F"ip>',
                "destroy": true,
                "pageLength": 10,
                "sPaginationType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "ajax": {
                    "url": "{{ route('admin.user.datatable') }}",
                    "method": "POST",
                    'data': function(data) {
                        data.user_name = $('#filter_name').val();
                        data.user_email = $('#filter_email').val();
                        data.user_role = $('#filter_role').val();


                    }
                },
                "order": [
                    [0, "asc"]
                ],
                "columns": [{
                        data: 'checkboxes',
                        name: 'checkboxes',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'

                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
                "language": {
                    "info": "Showing _START_ to _END_ of _TOTAL_ records",
                }

            });

            $('#filter_name').keyup(function () {
              user_datatable.draw();
            });

            $('#filter_email').keyup(function () {
              user_datatable.draw();
            });

            $('#filter_role').change(function () {
               user_datatable.draw();
            });

        });
    </script>
