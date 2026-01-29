@extends('admin.layouts.master')

@section('content')
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-md-12">
                <div class="bg-light rounded h-100 p-4">
                    <div class="pull-right" style="float: right;">
                        <a href="{{ route('admin.merchants.index') }}">
                            <button type="button" class="btn btn-primary">Back</button>
                        </a>
                    </div>
                    <h4 class="mb-4">Edit Merchant # &nbsp;{{ $merchant->name }}</h4>

                    <form action="{{ route('admin.merchants.update', ['merchant' => $merchant]) }}" method="POST"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row mb-3">
                            <label for="name" class="col-sm-4 col-form-label">Name</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ !empty(old('name')) ? old('name') : $merchant->name }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">{!! $errors->first('name') !!}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="email" class="col-sm-4 col-form-label">Email</label>
                            <div class="col-sm-5">
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ !empty(old('email')) ? old('email') : $merchant->email }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">{!! $errors->first('email') !!}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="telephone" class="col-sm-4 col-form-label">Telephone</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="telephone" name="telephone"
                                       value="{{ !empty(old('telephone')) ? old('telephone') : $merchant->telephone }}">
                                @if ($errors->has('telephone'))
                                    <span class="help-block">{!! $errors->first('telephone') !!}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="address" class="col-sm-4 col-form-label">Address</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{ !empty(old('address')) ? old('address') : $merchant->address }}">
                                @if ($errors->has('address'))
                                    <span class="help-block">{!! $errors->first('address') !!}</span>
                                @endif
                            </div>
                        </div>

                        {{--New Field--}}
                        <div class="row mb-3">
                            <label for="merchantUrl" class="col-sm-4 col-form-label">URL</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="merchantUrl" name="merchantUrl"
                                       value="{{ !empty(old('merchantUrl')) ? old('merchantUrl') : $merchant->merchantUrl }}">
                                @if ($errors->has('merchantUrl'))
                                    <span class="help-block">{!! $errors->first('merchantUrl') !!}</span>
                                @endif
                            </div>
                        </div>
                        {{--End New Field--}}

                        <div class="row mb-3">
                            <label for="sercret_id" class="col-sm-4 col-form-label">Secret Id</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="secret_id" name="secret_id"
                                       value="{{ !empty(old('secret_id')) ? old('secret_id') : $merchant->secret_id }}" readonly>
                            </div>
                            <button type="button" id="secret_id_btn" class="btn col-sm-1 btn-success">Change
                            </button>
                            <label id="secret_id_change" style="color:green"></label>
                        </div>

                        <div class="row mb-3">
                            <label for="payment_method" class="col-sm-4 col-form-label">Payment Methods</label>
                            <div class="col-sm-5">
                                <input type="checkbox" name="credit_card" {{ ($merchant->credit_card == 1) ? "checked" : '' }}> &nbsp;
                                <label for="telephone" class="col-sm-4 col-form-label">Credit Card</label> <br>
                                <input type="checkbox" name="paypal" {{ ($merchant->paypal == 1) ? "checked" : '' }}>&nbsp;
                                <label for="paypal" class="col-sm-4 col-form-label">Paypal</label> <br>
                                <input type="checkbox" name="user_credit" {{ ($merchant->user_credit == 1) ? "checked" : '' }}>&nbsp;
                                <label for="user_credit" class="col-sm-4 col-form-label">User Credit</label>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="logo" class="col-sm-4 col-form-label">LOGO</label>
                            <div class="col-sm-5">
                                <img src="{{ URL::asset('merchant_logos') . '/' . $merchant->logo }}"
                                     id="imgPreview" alt="No Featured Image Added" style="width: 300px;">
                                <input onchange="readURL(this)" id="uploadFile" accept="image/*" name="logo"
                                       type="file">

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="password" class="col-sm-4 col-form-label">Password:</label>
                            <div class="col-sm-5">
                                <input placeholder="Password" class="form-control" name="password" type="password" value="" id="password">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="confirm-password" class="col-sm-4 col-form-label">Confirm Password:</label>
                            <div class="col-sm-5">
                                <input placeholder="Confirm Password" class="form-control" name="confirm-password" type="password" value="" id="confirm_password">
                                <p></p>
                                <span id='message'></span>
                            </div>
                            
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-4 col-form-label"></label>
                            <button type="submit" class="btn  col-sm-5 btn-primary">Edit</button>
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
    $('#password, #confirm_password').on('keyup', function () {
    if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Password Matching').css('color', 'green');
    } else 
        $('#message').html('Password Not Matching').css('color', 'red');
    });
        function readURL(input) {

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imgPreview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        $('#secret_id_btn').click(function () {
            var name = $('#name').val();
            var result = '';
            $.ajax({
                url: '/admin/change-secret-id',
                method: 'POST',
                data:
                    {
                        name: name,
                        "_token": "{{ csrf_token() }}",

                    },
                success: function(result){
                    $('input[name=secret_id]').val(result);
                    $('#secret_id_change').text("Secret ID is changed");
                },

            })
        })
    </script>
@endsection
