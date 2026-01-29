@extends('admin.layouts.master')
@section('css')
    <style>
        .help-block {
            color: red;
        }

    </style>
@endsection
@section('content')
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
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
            <div class="col-sm-12 col-md-12">
                <div class="bg-light rounded h-100 p-4">

                    <h4 class="mb-4">Settings</h4>
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-paypal-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-paypal" type="button" role="tab" aria-controls="nav-paypal"
                                    aria-selected="true">Paypal
                            </button>
                            <button class="nav-link" id="nav-credit_card-tab" data-bs-toggle="tab"
                                    data-bs-target="#nav-credit_card" type="button" role="tab"
                                    aria-controls="nav-credit_card"
                                    aria-selected="false">Credit Card
                            </button>

                        </div>
                    </nav>
                    <div class="tab-content pt-3" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-paypal" role="tabpanel"
                             aria-labelledby="nav-paypal-tab">
                            <form action="{{ route('admin.settings.update.paypal') }}" method="POST"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <h6>Sandbox Credentials</h6>
                                <br>
                                <div class="row mb-3">
                                    <label for="paypal_sandbox_client_id" class="col-sm-4 col-form-label">Sandbox Clent ID</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="paypal_sandbox_client_id" name="paypal_sandbox_client_id"
                                               value="{{ isset($setting->paypal_sandbox_client_id) ? $setting->paypal_sandbox_client_id : old('paypal_sandbox_client_id') }}">
                                        @if ($errors->has('paypal_sandbox_client_id'))
                                            <span class="help-block">{!! $errors->first('paypal_sandbox_client_id') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <label for="paypal_sandbox_client_secret" class="col-sm-4 col-form-label">Sandbox Clent Secret</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="paypal_sandbox_client_secret" name="paypal_sandbox_client_secret"
                                               value="{{ isset($setting->paypal_sandbox_client_secret) ? $setting->paypal_sandbox_client_secret : old('paypal_sandbox_client_secret') }}">
                                        @if ($errors->has('paypal_sandbox_client_secret'))
                                            <span class="help-block">{!! $errors->first('paypal_sandbox_client_secret') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <h6>Live Credentials</h6>
                                <br>
                                <div class="row mb-3">
                                    <label for="paypal_live_client_id" class="col-sm-4 col-form-label">Live Clent ID</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="paypal_live_client_id" name="paypal_live_client_id"
                                               value="{{ isset($setting->paypal_live_client_id) ? $setting->paypal_live_client_id : old('paypal_live_client_id') }}">
                                        @if ($errors->has('paypal_live_client_id'))
                                            <span class="help-block">{!! $errors->first('paypal_live_client_id') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <label for="paypal_live_client_secret" class="col-sm-4 col-form-label">Live Clent Secret</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="paypal_live_client_secret" name="paypal_live_client_secret"
                                               value="{{ isset($setting->paypal_live_client_secret) ? $setting->paypal_live_client_secret : old('paypal_live_client_secret') }}">
                                        @if ($errors->has('paypal_live_client_secret'))
                                            <span class="help-block">{!! $errors->first('paypal_live_client_secret') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <br>

                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label"></label>
                                    <button type="submit" class="btn  col-sm-5 btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="nav-credit_card" role="tabpanel"
                             aria-labelledby="nav-credit_card-tab">
                            <form action="{{ route('admin.settings.update.credit') }}" method="POST"
                                  enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <h6>Sandbox Credentials</h6>
                                <br>
                                <div class="row mb-3">
                                    <label for="credit_card_sandbox_merchant_id" class="col-sm-4 col-form-label">Credit Card Sandbox Merchant ID</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="credit_card_sandbox_merchant_id" name="credit_card_sandbox_merchant_id"
                                               value="{{ isset($setting->credit_card_sandbox_merchant_id) ? $setting->credit_card_sandbox_merchant_id : old('credit_card_sandbox_merchant_id') }}">
                                        @if ($errors->has('credit_card_sandbox_merchant_id'))
                                            <span class="help-block">{!! $errors->first('credit_card_sandbox_merchant_id') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="credit_card_sandbox_api_key" class="col-sm-4 col-form-label">Credit Card Sandbox Api Key</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="credit_card_sandbox_api_key" name="credit_card_sandbox_api_key"
                                               value="{{ isset($setting->credit_card_sandbox_api_key) ? $setting->credit_card_sandbox_api_key : old('credit_card_sandbox_api_key') }}">
                                        @if ($errors->has('credit_card_sandbox_api_key'))
                                            <span class="help-block">{!! $errors->first('credit_card_sandbox_api_key') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                 <h6>Live Credentials</h6>
                                <br>
                                <div class="row mb-3">
                                    <label for="credit_card_live_merchant_id" class="col-sm-4 col-form-label">Credit Card Live Merchant ID</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="credit_card_live_merchant_id" name="credit_card_live_merchant_id"
                                               value="{{ isset($setting->credit_card_live_merchant_id) ? $setting->credit_card_live_merchant_id : old('credit_card_live_merchant_id') }}">
                                        @if ($errors->has('credit_card_live_merchant_id'))
                                            <span class="help-block">{!! $errors->first('credit_card_live_merchant_id') !!}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="credit_card_live_api_key" class="col-sm-4 col-form-label">Credit Card Sandbox Api Key</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="credit_card_live_api_key" name="credit_card_live_api_key"
                                               value="{{ isset($setting->credit_card_live_api_key) ? $setting->credit_card_live_api_key : old('credit_card_live_api_key') }}">
                                        @if ($errors->has('credit_card_live_api_key'))
                                            <span class="help-block">{!! $errors->first('credit_card_live_api_key') !!}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label"></label>
                                    <button type="submit" class="btn  col-sm-5 btn-primary">Update</button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    </div>
    <!-- Form End -->
@endsection

