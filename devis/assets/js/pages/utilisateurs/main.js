"use strict";

// Class Definition
var KTMainDashboard = function() {
    var _page;
    var _subpage;
    var _header;

    $('#codenumtel').select2({
        placeholder: 'Indicatif téléphonique',
    });

    $('#codenumportable').select2({
        placeholder: 'Indicatif téléphonique',
    });

    $('#typeutilisateur').select2({
        placeholder: 'Type utilisateur',
    });

    var _initMenu = function() {
        _header.addClass('active');
        _page.addClass('active');
        _subpage.addClass('menu-item-active');
    };

    var _initTable = function() {
        var table = $('#kt_datatable');

        // begin first table
        var datatable = table.DataTable({
            responsive: true,
            paging: true,
            iDisplayLength: 100,
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4 ]
                    }
                }
            ],
            language: {
                url: './assets/json/dataTable_french.json'
            },
            columnDefs: [
            ]
        });
    };

    var _gereResource = function() {
        var validationAdd;
        var addMod;
        var id;

        validationAdd = FormValidation.formValidation(
            document.getElementById('kt_form_1'),
            {
                fields: {
                    nom: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    prenom: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            },
                            emailAddress: {
                                message: 'L\'adresse renseignée n\'est pas une adresse email valide'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                enabled: true,
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    confirmPassword: {
                        validators: {
                            notEmpty: {
                                enabled: true,
                                message: 'Champ obligatoire'
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

        $('input[type=file]').css('color', 'transparent');

        $("#addUtilisateurs").click(function(){
            addMod = true;
            validationAdd.enableValidator('password').enableValidator('confirmPassword');

            $(".erreurLogin").hide();
            $('#kt_form_1').trigger("reset");
            validationAdd.resetForm();
            $("#modalTitle").html('Ajout d\'un utilisateur');
            $("#saveModal").text('Ajouter');
            $(".text-muted-password").html('*Veuillez renseigner un mot de passe');
            $(".text-muted-confirmPassword").html('*Veuillez confirmer le mot de passe');
        });

        $(".modUtilisateur").click(function(){
            addMod = false;
            validationAdd.disableValidator('password').disableValidator('confirmPassword');

            $(".erreurLogin").hide();
            $("#modalTitle").html('Modification d\'un utilisateur');
            $("#saveModal").text('Modifier');
            $(".text-muted-password").html('Laissez vide si vous ne souhaitez pas modifier le mot de passe');
            $(".text-muted-confirmPassword").html('Veuillez confirmer le mot de passe');
            id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: "./assets/ajax/utilisateurs/getUtilisateur.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    var typeUtilisateur;
                    $('.select2-selection').css('height', '30px');
                    $.each(data, function(k, v){
                        $("#"+k).val(v);

                        if(k == 'codenumtel') {
                            if ($('#'+k).find("option[value='" + v + "']").length) {
                                $('#'+k).val(v).trigger('change');
                            } else {
                                if ($('#'+k).find("option[value='" + '+33' + "']").length) {
                                    $('#' + k).val('+33').trigger('change');
                                }
                            }
                        }
                        if(k == 'codenumportable') {
                            if ($('#'+k).find("option[value='" + v + "']").length) {
                                $('#'+k).val(v).trigger('change');
                            } else {
                                if ($('#'+k).find("option[value='" + '+33' + "']").length) {
                                    $('#' + k).val('+33').trigger('change');
                                }
                            }
                        }
                        if (k == 'typeUtilisateur'){
                            typeUtilisateur = v;
                        }
                    });
                    $("#typeutilisateur").val(typeUtilisateur).trigger('change');

                    $("#staticBackdrop").modal();
                }
            });
        });

        $("#confirmPassword").keyup(function(){
            $(".erreurConfirmMdp").hide();
            if($("#password").val() != $(this).val()) {
                $(".erreurConfirmMdp").show();
            }
        });

        $('#saveModal').on('click', function (e) {
            e.preventDefault();
            $(this).hide();

            var form = $("#kt_form_1");
            var formData = (window.FormData) ? new FormData(form[0]) : null;
            var data = (formData !== null) ? formData : form.serialize();

            if(addMod) {
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $(".erreurMdp").hide();
                        $(".erreurLogin").hide();
                        $(".erreurConfirmMdp").hide();
                        if($("#password").val() != "") {
                            if($("#password").val() == $("#confirmPassword").val()) {
                                $.ajax({
                                    type: "POST",
                                    url: "./assets/ajax/utilisateurs/addUtilisateur.php",
                                    data: data,
                                    processData: false,
                                    contentType: false,
                                    success: function (html) {
                                        if (html == true) {
                                            location.reload();
                                        } else {
                                            $('#saveModal').show();
                                            $(".erreurLogin").show();
                                        }
                                    }
                                });
                            }else{
                                $('#saveModal').show();
                                $(".erreurConfirmMdp").show();
                            }
                        }else{
                            $('#saveModal').show();
                            $(".erreurMdp").show();
                        }
                    }else{
                        $('#saveModal').show();
                    }
                });
            }else{
                formData.append('id', id);
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $(".erreurMdp").hide();
                        $(".erreurLogin").hide();
                        $(".erreurConfirmMdp").hide();
                        if($("#password").val() == "" || ($("#password").val() != "" && $("#password").val() == $("#confirmPassword").val())) {
                            $.ajax({
                                type: "POST",
                                url: "./assets/ajax/utilisateurs/modUtilisateur.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (html) {
                                    if (html == true) {
                                        location.reload();
                                    } else {
                                        $('#saveModal').show();
                                        $(".erreurLogin").show();
                                    }
                                }
                            });
                        }else{
                            $('#saveModal').show();
                            $(".erreurConfirmMdp").show();
                        }
                    }else{
                        $('#saveModal').show();
                    }
                });
            }
        });
    };

    // Public Functions
    return {
        // public functions
        init: function() {
            _page = $('.parametres a');
            _subpage = $('.utilisateurs');
            _header = $('#kt_header_tab_3');

            _initMenu();
            _initTable();
            _gereResource();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTMainDashboard.init();
});
