"use strict";

// Class Definition
var KTLogin = function() {
    var _login;

    var _handleSignInForm = function() {
        var validation;
        var checked;
        var checkedI;

        $("#kt_login_signin_submit").hide();
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
            KTUtil.getById('kt_login_signin_form'),
            {
                fields: {
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Le champ mot de passe est obligatoire'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        $('#kt_login_signin_submit').on('click', function (e) {
            e.preventDefault();

            validation.validate().then(function(status) {
                if (status == 'Valid') {
                    $(".erreurConfirmMdp").hide();
                    if(checkStrength($("input[name='password']").val())) {
                        if($("input[name='password']").val() == $("input[name='passwordConfirm']").val()) {
                            $.ajax({
                                type: "POST",
                                url: "./assets/ajax/login/changePassword.php",
                                data: {
                                    "email": $("input[name='email']").val(),
                                    "password": $("input[name='password']").val(),
                                    "cle": $("input[name='cle']").val()
                                },
                                success: function (html) {
                                    if (html === 'ok') {
                                        window.location = "./";
                                    }
                                }
                            });
                        }else{
                            $(".erreurConfirmMdp").show();
                        }
                    }else{
                        $(".erreurMdp").show();
                    }
                } else {
                    swal.fire({
                        text: "Un ou plusieurs champs sont vides.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Je modifie !",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function() {
                        KTUtil.scrollTop();
                    });
                }
            });
        });

        $("input[name='passwordConfirm']").keyup(function(){
            checkedI = checkIdentique($("input[name='password']").val(), $("input[name='passwordConfirm']").val());
            if(checkedI){
                $(".erreurConfirmMdp").hide();
            }else{
                $(".erreurConfirmMdp").show();
            }

            if(checked && checkedI){
                $("#kt_login_signin_submit").show();
            }else{
                $("#kt_login_signin_submit").hide();
            }
        });

        $("input[name='password']").keyup(function() {
            checked = checkStrength($("input[name='password']").val());
            if(checked){
                $(".erreurMdp").hide();
            }else{
                $(".erreurMdp").show();
            }

            if(checked && checkedI){
                $("#kt_login_signin_submit").show();
            }else{
                $("#kt_login_signin_submit").hide();
            }
        });

        function checkIdentique(password, confirmPassword){
            if(password === confirmPassword){
                return true;
            }else{
                return false;
            }
        }

        function checkStrength(password) {
            var strength = 0;
            if (password.length < 8) {
                return false;
            }

            if (password.length >= 8) strength += 1;
            // If password contains both lower and uppercase characters, increase strength value.
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;
            // If it has numbers and characters, increase strength value.
            if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1;
            // If it has two special characters, increase strength value.
            if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;

            if (strength < 4) {
                return false;
            }else{
                return true;
            }
        }
    };

    // Public Functions
    return {
        // public functions
        init: function() {
            _login = $('#kt_login');

            _handleSignInForm();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLogin.init();
});
