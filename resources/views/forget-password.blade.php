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
                                {{ trans('lables.forget-password') }}
                            </h2>
                            <hr>
                        </div>
                        <div class="tab-content" id="registerTabContent">
                            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                                <div class="registration-process">
                                    <form id="forgetForm">
                                        <div class="from-group mb-3">
                                            <div class="col-12"> <label for="inlineFormInputGroup">{{ trans('lables.forget-password-email') }}</label>
                                            </div>
                                            <div class="input-group col-12">

                                                <input type="email" class="form-control" id="forget_email"
                                                    placeholder="{{ trans('lables.forget-password-email') }}">
                                                <br />
                                                

                                            </div>
                                            <div class="input-group col-12">
                                            <small class="email errors d-none" style="color:red"></small>
                                        </div>
                                        <div class="col-12 col-sm-12">
                                            <button type="button" class="btn btn-secondary" id="forget_password">{{ trans('lables.forget-password-verify') }}</button>

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

    $('#forget_password').click(function(){
        email = $('#forget_email').val();
        forgetPassword(email);
    })


    function forgetPassword(email) {
            var  url = "{{ url('') }}" + '/api/client/forget_password';

            $.ajax({
                type: 'post',
                url: url,
                data:{email:email},
                headers: {
                    'Authorization': 'Bearer ' + customerToken,
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    clientid: "{{ isset(getSetting()['client_id']) ? getSetting()['client_id'] : '' }}",
                    clientsecret: "{{ isset(getSetting()['client_secret']) ? getSetting()['client_secret'] : '' }}",
                },
                beforeSend: function() {},
                success: function(data) {
                    if (data.status == 'Success') {
                        toastr.success(data.message);
                        $('#forget_email').val();

                    } else if (data.status == 'Error') {
                        toastr.error('{{ trans('response.some_thing_went_wrong') }}');
                    }
                },
                error: function(data) {
                    if(data.status == 422){
                        $.each( data.responseJSON.errors, function( index, value ){
                            $("#forgetForm").find("."+index).html(value)
                            $("#forgetForm").find("."+index).removeClass('d-none');
                        });
                    }

                },
            });
        }

</script>
@endsection
