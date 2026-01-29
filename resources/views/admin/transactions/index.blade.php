@extends('admin.layouts.master')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Transactions</h1>

        <div class="card shadow mb-4">

            <div class="card-body p-t-10 searchFilters">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="filter_merchant" class="control-label">Merchant</label>
                            <input type="text" class="form-control" id="filter_merchant">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="from" class="control-label">From</label>
                            <input type="text" id="from" placeholder="mm-dd-yyyy" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="to" class="control-label">To</label>
                            <input type="text" id="to" placeholder="mm-dd-yyyy" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date_options" class="control-label">Quick Date</label>
                            <select name="date_options" id="date_options" class="form-control">
                                <option value="">Pick an option</option>
                                <option value_from="{{ date('m-d-Y', strtotime('yesterday')) }}"
                                        value_to="{{ date('m-d-Y', strtotime('yesterday')) }}" value="yesterday">
                                    Yesterday
                                </option>
                                <option value_from="{{ date('m-d-Y') }}" value_to="{{ date('m-d-Y') }}" value="today">
                                    Today
                                </option>
                                <option value_from="{{ date('m-d-Y', strtotime('monday this week')) }}"
                                        value_to="{{ date('m-d-Y', strtotime('friday this week')) }}"
                                        value="this_weekdays">
                                    This Weekdays
                                </option>
                                <option value_from="{{ date('m-d-Y', strtotime('monday this week')) }}"
                                        value_to="{{ date('m-d-Y', strtotime('sunday this week')) }}"
                                        value="this_whole_week">
                                    This Whole Week
                                </option>
                                <option value_from="{{ date('m-d-Y', strtotime('first day of this month')) }}"
                                        value_to="{{ date('m-d-Y', strtotime('last day of this month')) }}"
                                        value="this_month">
                                    This Month
                                </option>
                                <option value_from="{{ date('m-d-Y', strtotime('first day of January ' . date('Y'))) }}"
                                        value_to="{{ date('m-d-Y', strtotime('last day of December ' . date('Y'))) }}"
                                        value="this_year">
                                    This Year
                                </option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ActivateAdvanceSerach" class="control-label">&nbsp;</label>
                            <button type="button" class="btn btn-info form-control" id="ActivateAdvanceSerach">Advance
                                Search
                            </button>
                            <button type="button" class="btn btn-info form-control" id="HideActivateAdvanceSerach"
                                    style="display: none;">Hide Advance Search
                            </button>
                        </div>
                    </div>


                </div>
            </div>
            <div class="card-body searchFilters m-b-10 " id="AdvanceFilters" style="display: none;">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="filter_order_id" class="control-label">Order ID</label>
                            <input type="text" class="form-control" id="filter_order_id">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="filter_amount" class="control-label">Amount ($)</label>
                            <input type="text" class="form-control" id="filter_amount">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="filter_invoice_no" class="control-label">Invoice No</label>
                            <input type="text" class="form-control" id="filter_invoice_no">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status" class="control-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Status</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Complete</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_type" class="control-label">Payment Type</label>
                            <select name="payment_type" id="payment_type" class="form-control">
                                <option value="">Type</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="user_credit">User Credit</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-responsive-block table-responsive"
                           id="dataTable"
                           width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th></th>
                            <th>ID</th>
                      <!--       <th>Merchant</th> -->
                            <th>Partial</th>
               <!--              <th>Referance id</th> -->
                            <th>Payment Type</th>
                            <th>Payment Date</th>
                            <th>Amount</th>
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
        $(document).ready(function (e) {
            $("#ActivateAdvanceSerach").click(function () {
                $("#AdvanceFilters").show();
                $("#HideActivateAdvanceSerach").show();
                $("#ActivateAdvanceSerach").hide()
            });
            $("#HideActivateAdvanceSerach").click(function () {
                $("#AdvanceFilters").hide();
                $("#HideActivateAdvanceSerach").hide();
                $("#ActivateAdvanceSerach").show();
            });
            var table = $('#dataTable');
            $.fn.dataTable.ext.errMode = 'none';

            var transaction_datatable = table.DataTable({
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
                    "url": "{{ route('admin.transactions.datatable') }}",
                    "method": "POST",
                    'data': function (data) {
                        data.filter_merchant = $('#filter_merchant').val();
                        data.order_id = $('#filter_order_id').val();
                        data.amount = $('#filter_amount').val();
                        data.from = $('#from').val();
                        data.to = $('#to').val();
                        data.date_option = $('#date_options').val();
                        data.status = $('#status').val();
                        data.payment_type = $('#payment_type').val();
                        data.invoice_no = $('#filter_invoice_no').val();
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
                    // {
                    //     data: 'merchant',
                    //     name: 'merchant'

                    // },
                    {
                        data: 'partial',
                        name: 'partial'

                    },

                    {
                        data: 'payment_type',
                        name: 'payment_type'
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
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


            // $('#filter_merchant').keyup(function () {
            //     transaction_datatable.draw();
            // });

            $('#filter_invoice_no').keyup(function () {
                transaction_datatable.draw();
            });

            // $('#filter_order_id').keyup(function () {
            //     transaction_datatable.draw();
            // });

            $('#filter_amount').keyup(function () {
                transaction_datatable.draw();
            });

            $('#status').change(function () {
                transaction_datatable.draw();
            });

            $('#payment_type').change(function () {
                transaction_datatable.draw();
            });

            $('#from').change(function () {
                transaction_datatable.draw();
                $('#date_options').val('');
            });


            $('#to').change(function () {
                transaction_datatable.draw();
                $('#date_options').val('');
            });

            $('#date_options').change(function () {
                var from_date = $('#date_options option:selected').attr('value_from');
                var to_date = $('#date_options option:selected').attr('value_to');
                $('#from').val(from_date);
                $('#to').val(to_date);
                transaction_datatable.draw();
            });

            //Date Pickers
            $('#from').datepicker({
                format: 'mm-dd-yyyy'
            });

            $('#to').datepicker({
                format: 'mm-dd-yyyy'
            });

        });
    </script>
@endsection
