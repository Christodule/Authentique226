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
                                                <input type="password" class="form-control " id="current_password_input" placeholder="{{ trans('lables.change-password-current-password') }}">
                                            </div>
                                            <div class="input-group col-12">
                                                <small class="current_password errors d-none" style="color:red"></small>
                                            </div>

                                            <div class="input-group col-12">
                                                <input type="password" class="form-control mt-4" id="reset_password_input" placeholder="{{ trans('lables.change-password-new-password') }}">
                                            </div>
                                            <div class="input-group col-12">
                                                <small class="new_password errors d-none" style="color:red"></small>
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
    loggedIn = $.trim(localStorage.getItem("customerLoggedin"));
    if (loggedIn != '1') {
        window.location.href = "{{ url('/') }}";
    }

    cartSession = $.trim(localStorage.getItem("cartSession"));
    if (cartSession == null || cartSession == 'null') {
        cartSession = '';
    }
    loggedIn = $.trim(localStorage.getItem("customerLoggedin"));
    customerToken = $.trim(localStorage.getItem("customerToken"));
    customerId = $.trim(localStorage.getItem("customerId"));
    
    
    $('#reset_password').click(function() {
        current_password = $('#current_password_input').val();
        new_password = $('#reset_password_input').val();
        confirm_password = $('#reset_confirm_password_input').val();
        
        resetPassword(current_password,new_password,confirm_password);
    })


    function resetPassword(current_password,new_password,confirm_password) {
        var url = "{{ url('') }}" + '/api/client/change_password';

        $.ajax({
            type: 'post',
            url: url,
            data: {
                current_password: current_password,
                new_password: new_password,
                confirm_password:confirm_password
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
                    });
                }

            },
        });
    }
</script>
@endsection
