@extends('layouts.master')
@section('content')
<!-- change password -->
<div class="container-fuild">
    <nav aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">{{ trans('lables.bread-crumb-home') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ trans('lables.change-password') }}</li>
            </ol>
        </div>
    </nav>
</div>

<!-- page Content -->
<section class="page-area pro-content">
    <div class="container">
        <div class="row justify-content-center">


            <div class="col-12 col-sm-12 col-md-6">

                <div class="col-12">
                    <div class="heading">
                        <h2>
                            {{ trans('lables.change-password') }}
                        </h2>
                        <hr>
                    </div>
                    <div class="tab-content" id="registerTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <div class="registration-process">
                                <form id="forgetForm">

                                    <div class="from-group mb-3">
                                        
                                        <div class="input-group col-12">
                                            <input type="password" class="form-control" id="reset_password_input" placeholder="{{ trans('lables.change-password-new-password') }}">
                                        </div>
                                        <div class="input-group col-12">
                                            <small class="password errors d-none" style="color:red"></small>
                                        </div>

                                        
                                        <div class="input-group col-12">
                                            <input type="password" class="form-control mt-4" id="reset_confirm_password_input"
                                                    placeholder="{{ trans('lables.change-password-confirm-password') }}">
                                        </div>
                                        <div class="input-group col-12">
                                            <small class="confirm_password errors d-none" style="color:red"></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <button type="button" id="reset_password" class="btn btn-secondary">{{ trans('lables.change-password') }}</button>

                                    </div>
                                </form>
                            </div>

                        </div>


                    </div>
                </div>
            </div>

        </div>

    </div>
</section>
@endsection
@section('script')
<script>
    var forget_id = "{{ isset($_GET['token']) ? $_GET['token'] : '' }}";

    $('#reset_password').click(function() {
        password = $('#reset_password_input').val();
        confirm_password = $('#reset_confirm_password_input').val();
        
        resetPassword(password,confirm_password);
    })


    function resetPassword(password,confirm_password) {
        var url = "{{ url('') }}" + '/api/client/reset_password';

        $.ajax({
            type: 'post',
            url: url,
            data: {
                password: password,
                confirm_password:confirm_password,
                forget_id: forget_id
            },
            headers: {
                'Authorization': 'Bearer ' + customerToken,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                clientid: "{{ isset(getSetting()['client_id']) ? getSetting()['client_id'] : '' }}",
                clientsecret: "{{ isset(getSetting()['client_secret']) ? getSetting()['client_secret'] : '' }}",
            },
            beforeSend: function() {},
            success: function(data) {
                if (data.status == 'Success') {
                    $('#reset_password_input').val();
                    $('#reset_confirm_password_input').val();
                    toastr.success(data.message);
                } else if (data.status == 'Error') {
                    toastr.error('{{ trans('response.some_thing_went_wrong') }}');
                }
            },
            error: function(data) {
                if (data.status == 422) {
                    $.each(data.responseJSON.errors, function(index, value) {
                        $("#forgetForm").find("." + index).html(value)
                        $("#forgetForm").find("." + index).removeClass('d-none');
                        if(index == "forget_id"){
                            toastr.error('token has been expired');

                        }
                    });
                }

            },
        });
    }
</script>
@endsection