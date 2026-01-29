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
            <div class="col-sm-12 col-md-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="pull-right" style="float: right;">
                        <a href="{{ route('admin.merchants.index') }}"><button type="button" class="btn btn-primary">Back</button></a>
                    </div>
                    <h4 class="mb-4">Add A Merchant</h4>
                    <form action="{{ route('admin.merchants.add') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">{!! $errors->first('name') !!}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">{!! $errors->first('email') !!}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telephone" class="col-sm-4 col-form-label">Telephone</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}">
                                @if ($errors->has('telephone'))
                                    <span class="help-block">{!! $errors->first('telephone') !!}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <span class="help-block">{!! $errors->first('address') !!}</span>
                                @endif
                            </div>
                        </div>

                        {{--New Field--}}
                        <div class="row mb-3">
                            <label for="merchantUrl" class="col-sm-4 col-form-label">Shop URL</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="merchantUrl" name="merchantUrl" value="{{ old('merchantUrl') }}">
                                @if ($errors->has('merchantUrl'))
                                    <span class="help-block">{!! $errors->first('merchantUrl') !!}</span>
                                @endif
                            </div>
                        </div>
                        {{--End New Field--}}

                        <div class="row mb-3">
                            <label for="payment_method" class="col-sm-4 col-form-label">Payment Methods</label>
                            <div class="col-sm-5">
                                <input type="checkbox" name="credit_card"> &nbsp;
                                <label for="telephone" class="col-sm-4 col-form-label">Credit Card</label> <br>
                                <input type="checkbox" name="paypal">&nbsp;
                                <label for="paypal" class="col-sm-4 col-form-label">Paypal</label> <br>
                                <input type="checkbox" name="user_credit">&nbsp;
                                <label for="user_credit" class="col-sm-4 col-form-label">User Credit</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="logo" class="col-sm-4 col-form-label">LOGO</label>
                            <div class="col-sm-5">
                                <img  src="" id="imgPreview"
                                alt="No Featured Image Added" style="width: 500px; height: 250px; ">
                            <input onchange="readURL(this)" id="uploadFile" accept="image/*"
                                name="logo" type="file">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-4 col-form-label">Password:</label>
                            <div class="col-sm-5">
                                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="confirm-password" class="col-sm-4 col-form-label">Confirm Password:</label>
                            <div class="col-sm-5">
                                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  class="col-sm-4 col-form-label"></label>
                            <button type="submit" class="btn  col-sm-5 btn-primary">Add</button>
                        </div>


                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Form End -->
@endsection

@section('js')
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imgPreview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
