@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Merchants</h1>
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
            <a type="button" href="{{ route('admin.merchants.create') }}" class="btn btn-primary">Add Merchant</a>
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
                            <label for="filter_phone" class="control-label">Phone</label>
                            <input type="text" class="form-control" id="filter_phone">
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ActivateAdvanceSerach" class="control-label">&nbsp;</label>
                            <button type="button" class="btn btn-info form-control" id="ActivateAdvanceSerach">Advance
                                Search</button>
                            <button type="button" class="btn btn-info form-control" id="HideActivateAdvanceSerach"
                                style="display: none;">Hide Advance Search</button>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card-body searchFilters m-b-10 " id="AdvanceFilters" style="display: none;">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filter_address" class="control-label">Address</label>
                            <input type="text" class="form-control" id="filter_address">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filter_merchantUrl" class="control-label">URL</label>
                            <input type="text" class="form-control" id="filter_merchantUrl">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filter_store_name" class="control-label">Store name</label>
                            <input type="text" class="form-control" id="filter_store_name">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filter_merchant_code" class="control-label">Merchant Code</label>
                            <input type="text" class="form-control" id="filter_merchant_code">
                        </div>
                    </div>
                </div>
                    <div class="row mt-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="filter_secret_id" class="control-label">Secret ID</label>
                            <input type="text" class="form-control" id="filter_secret_id">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status" class="control-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value=""> - Status - </option>
                                <option value="not_active">Innactive</option>
                                <option value="active">Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Merchants</h6>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-responsive-block table-responsive" id="dataTable"
                        width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>URL</th>
                                <th>Phone</th>
                                <th>Merchant Code</th>
                                <th>Secret Id</th>
                                <th>Store name</th>
                                <th>Status</th>
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
    <!-- /.container-fluid -->
@endsection

@section('js')
    <script>
        $(document).ready(function(e) {
            $("#ActivateAdvanceSerach").click(function() {
                $("#AdvanceFilters").show();
                $("#HideActivateAdvanceSerach").show();
                $("#ActivateAdvanceSerach").hide()
            });
            $("#HideActivateAdvanceSerach").click(function() {
                $("#AdvanceFilters").hide();
                $("#HideActivateAdvanceSerach").hide();
                $("#ActivateAdvanceSerach").show();
            });
            var table = $('#dataTable');
            $.fn.dataTable.ext.errMode = 'none';

            var merchant_datatable = table.DataTable({
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
                    "url": "{{ route('admin.merchants.datatable') }}",
                    "method": "POST",
                    'data': function(data) {
                        data.merchant_name = $('#filter_name').val();
                        data.merchant_email = $('#filter_email').val();
                        data.merchant_phone = $('#filter_phone').val();
                        data.merchant_address = $('#filter_address').val();
                        data.merchant_merchantUrl = $('#filter_merchantUrl').val();
                        data.merchant_store_name = $('#filter_store_name').val();
                        data.merchant_code = $('#filter_merchant_code').val();
                        data.merchant_secret_id = $('#filter_secret_id').val();
                        data.status = $('#status').val();

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
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'merchantUrl',
                        name: 'merchantUrl'
                    },
                    {
                        data: 'telephone',
                        name: 'telephone'
                    },
                    {
                        data: 'merchant_code',
                        name: 'merchant_code'
                    },
                    {
                        data: 'secret_id',
                        name: 'secret_id'
                    },
                    {
                        data: 'store_name',
                        name: 'store_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
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


            $('#filter_name').keyup(function() {
                merchant_datatable.draw();
            });

            $('#filter_email').change(function() {
                merchant_datatable.draw();
            });

            $('#filter_phone').keyup(function() {
                merchant_datatable.draw();
            });
            $('#filter_address').keyup(function() {
                merchant_datatable.draw();
            });
            $('#filter_merchantUrl').keyup(function() {
                merchant_datatable.draw();
            });
            $('#filter_store_name').keyup(function() {
                merchant_datatable.draw();
            });
            $('#filter_merchant_code').keyup(function() {
                merchant_datatable.draw();
            });
            $('#filter_secret_id').keyup(function() {
                merchant_datatable.draw();
            });

            $('#status').change(function () {
                merchant_datatable.draw();
            });
        });
    </script>
@endsection
