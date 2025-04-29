"use strict";

// Class Definition
var KTLogin = function() {
    var _login;
    var _handleSignInForm = function() {
        $("#qrcode").focus();

        var qrcode = $("#qrcode").val();
        if(qrcode !== '') {
            $.ajax({
                type: "POST",
                url: "./assets/ajax/login/loginqrcode.php",
                data: {
                    "qrcode": qrcode
                },
                dataType: 'json',
                success: function (html) {
                    if (html.status == true) {
                        if (html.typeutilisateur == '1') {
                            window.location = "./admin/index.php";
                        } else if (html.typeutilisateur == 2) {
                            window.location = "./admin/fichesrenseignement.php";
                        } else {
                            window.location = "./admin/index.php";
                        }
                    }
                }
            });
        }

        $("#qrcode").change(function(){
            var qrcode = $(this).val();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/login/loginqrcode.php",
                data: {
                    "qrcode": qrcode
                },
                dataType: 'json',
                success: function (html) {
                    if(html.status == true){
                        if(html.typeutilisateur == '1') {
                            window.location="./admin/index.php";
                        } else if(html.typeutilisateur == 2){
                            window.location="./admin/fichesrenseignement.php";
                        }
                        else{
                            window.location="./admin/index.php";
                        }
                    }
                }
            });
        });
    }

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
