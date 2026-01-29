@extends('admin.layouts.master')

@section('content')
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-md-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="pull-right" style="float: right;">
                        <a href="{{ route('admin.merchants.edit',  ['merchant' => $merchant]) }}">
                            <button type="button" class="btn btn-success">Edit</button>
                        </a>
                        <a href="{{ route('admin.merchants.index') }}">
                            <button type="button" class="btn btn-primary">Back</button>
                        </a>
                    </div>
                    <table class="table ">
                        <tr>
                            <td><b>Name</b></td>
                            <td>{{ $merchant->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Email</b></td>
                            <td>{{ $merchant->email }}</td>
                        </tr>
                        <tr>
                            <td><b>Telephone</b></td>
                            <td>{{ $merchant->telephone }}</td>
                        </tr>
                        <tr>
                            <td><b>Address</b></td>
                            <td>{{ $merchant->address }}</td>
                        </tr>
                        <tr>
                            <td><b>URL</b></td>
                            <td>{{ $merchant->merchantUrl }}</td>
                        </tr>
                        <tr>
                            <td><b>Merchant Code</b></td>
                            <td>{{ $merchant->merchant_code }}</td>
                        </tr>
                        <tr>
                            <td><b>Secret ID</b></td>
                            <td>{{ $merchant->secret_id }}</td>
                        </tr>
                        <tr>
                            <td><b>Store Name</b></td>
                            <td>{{ $merchant->store_name }}</td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Form End -->
@endsection
