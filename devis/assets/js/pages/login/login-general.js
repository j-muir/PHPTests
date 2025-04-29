"use strict";

// Class Definition
var KTLogin = function() {
    var _login;

    var _showForm = function(form) {
        var cls = 'login-' + form + '-on';
        var form = 'kt_login_' + form + '_form';

        _login.removeClass('login-forgot-on');
        _login.removeClass('login-signin-on');

        _login.addClass(cls);

        KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
    }

    var _handleSignInForm = function() {
        var validation;

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_signin_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Le champ email est obligatoire'
							}
						}
					},
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
                    $.ajax({
                        type: "POST",
                        url: "./assets/ajax/login/login.php",
                        data: {
                            "email":$("input[name='email']").val(),
                            "password":$("input[name='password']").val()
                        },
                        dataType:'json',
                        success: function(html){
                        	if(html.status == true){
                                if(html.typeutilisateur == '1') {
                                    window.location="./admin/index.php";
                                } else if(html.typeutilisateur == 2){
                                    window.location="./admin/fichesrenseignement.php";
                                }
                                else{
                                    window.location="./admin/index.php";
                                }
                            }else{
                                swal.fire({
                                    text: "Erreur sur l'adresse email ou le mot de passe.",
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
                        }
                    });
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

        // Handle forgot button
        $('#kt_login_forgot').on('click', function (e) {
            e.preventDefault();
            _showForm('forgot');
        });
    }

    var _handleForgotForm = function(e) {
        var validation;

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_forgot_form'),
			{
				fields: {
					emailforgot: {
						validators: {
							notEmpty: {
								message: 'Le champ email est obligatoire'
							},
                            emailAddress: {
								message: 'Merci de renseigner une adresse email valide'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

        // Handle submit button
        $('#kt_login_forgot_submit').on('click', function (e) {
            e.preventDefault();

            validation.validate().then(function(status) {
		        if (status == 'Valid') {
                    $.ajax({
                        type: "POST",
                        url: "./assets/ajax/login/forgotPassword.php",
                        data: {
                            "email":$("input[name='emailforgot']").val()
                        },
                        success: function(html){
                            $("#kt_login_forgot_form").hide();
                            $(".envoiForgotPassword").show();
                        }
                    });
					
                    KTUtil.scrollTop();
				} else {
					swal.fire({
		                text: "L'adresse email renseignée n'est pas une adresse email valide",
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

        // Handle cancel button
        $('#kt_login_forgot_cancel').on('click', function (e) {
            e.preventDefault();

            _showForm('signin');
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            _login = $('#kt_login');

            _handleSignInForm();
            _handleForgotForm();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTLogin.init();
});
