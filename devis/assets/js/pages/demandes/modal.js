"use strict";

// Class Definition
var KTModal = function () {

    var _gereResource = function () {
        $('#select2_clients').select2({
            placeholder: 'Clients',
        });

        var addMod;
        var id;
        var validationAdd;
        var isModifiable = $('#staticBackdropDemande').attr('data-is-modifiable');

        validationAdd = FormValidation.formValidation(
            document.getElementById('kt_form_demande'),
            {
                fields: {
                    date_demande: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    date_a_envoyer: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    type_demande: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
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
                    ville: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    codepostal: {
                        validators: {
                            integer: {
                                message: 'Le code postal ne doit contenir que des chiffres',
                            },
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    email: {
                        validators: {
                            emailAddress: {
                                message: 'L\'adresse renseignée n\'est pas une adresse email valide'
                            }
                        }
                    },
                    date_visite: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    nombre_participant: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    nombre_accompagnateur: {
                        validators: {
                            notEmpty: {
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

        $(".modDemande").on('click', function () {
            addMod = false;

            resetModaleDemande();

            if (isModifiable) {
                $("#modalTitleDemande").html('Modification d\'une demande');
            } else {
                $("#modalTitleDemande").html('Aperçu d\'une demande');
            }

            $("#saveModalDemande").text('Modifier');
            id = $(this).attr('data-id');

            $.ajax({
                type: "POST",
                url: "./assets/ajax/demandes/getDemande.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (k, v) {
                        let selector = document.querySelector('#' + k);
                        if (selector) {
                            if (selector.tagName.toLowerCase() == 'input') {
                                switch (selector.getAttribute('type')) {
                                    case 'text':
                                    case 'email':
                                    case 'tel':
                                    case 'date':
                                    case 'datetime-local':
                                    case 'number':
                                        selector.value = v;
                                        break;
                                    case 'checkbox':
                                        let isChecked = false;
                                        if (v != 0) {
                                            isChecked = true;
                                        }
                                        selector.checked = isChecked;
                                        break;
                                    case 'radio':
                                        let radio = document.querySelector('input[name=' + k + '][value="' + v + '"]');
                                        radio.checked = true;
                                        break;
                                    default:
                                        break;
                                }
                            } else if (selector.tagName.toLowerCase() == 'select') {
                                $('#' + k).val(v).trigger('change');
                            } else if (selector.tagName.toLowerCase() == 'textarea') {
                                selector.value = v;
                            } else if (selector.tagName.toLowerCase() == 'div') {
                                selector.innerHTML = v;
                            } else if (selector.tagName.toLowerCase() == 'span') {
                                selector.innerHTML = v;
                            }
                        } else if (k == 'clients') {
                            if (v != '0' && v != '' && v != null) {
                                $('#select2_clients').val(v).trigger('change');
                            }
                        }
                    });

                    if ($('#select2_clients').val() != '' && $('#select2_clients').val() != null) {
                        $('#searchInfosClient').trigger('click');
                    }

                    $("#staticBackdropDemande").modal();
                }
            });
        });

        $("#nouveau_prospect").on('change', function () {
            $('#select2_clients').val(null).trigger('change');
            // Si c'est checked alors on créé un client
            if ($(this).prop('checked')) {
                $('.ancien_client').prop('disabled', true);
                $('.champs_client').prop('disabled', false);
            } else {
                $('.ancien_client').prop('disabled', false);
                $('.champs_client').prop('disabled', true);
            }
        });

        $("#type_demande").on('change', function () {
            if ($(this).val() == 'Autres') {
                $('.autres_type_demande').removeClass('d-none');
            } else {
                $('#autres_type_demande').val('');
                $('.autres_type_demande').addClass('d-none');
            }
        });

        $("#specificite_groupe").on('change', function () {
            if ($(this).val() == 'Autres') {
                $('.autres_specificite_groupe').removeClass('d-none');
            } else {
                $('#autres_specificite_groupe').val('');
                $('.autres_specificite_groupe').addClass('d-none');
            }
        });

        $("#searchInfosClient").on('click', function () {
            let idClient = $('#select2_clients').val();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/clients/getClient.php",
                data: {
                    "id": idClient
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (k, v) {
                        let selector = document.querySelector('#' + k);
                        if (selector) {
                            if (selector.tagName.toLowerCase() == 'input') {
                                switch (selector.getAttribute('type')) {
                                    case 'text':
                                    case 'email':
                                    case 'tel':
                                    case 'date':
                                    case 'datetime-local':
                                    case 'number':
                                        selector.value = v;
                                        break;
                                    case 'checkbox':
                                        let isChecked = false;
                                        if (v != 0) {
                                            isChecked = true;
                                        }
                                        selector.checked = isChecked;
                                        break;
                                    case 'radio':
                                        let radio = document.querySelector('input[name=' + k + '][value="' + v + '"]');
                                        radio.checked = true;
                                        break;
                                    default:
                                        break;
                                }
                            } else if (selector.tagName.toLowerCase() == 'select') {
                                $('#' + k).val(v).trigger('change');
                            } else if (selector.tagName.toLowerCase() == 'textarea') {
                                selector.value = v;
                            } else if (selector.tagName.toLowerCase() == 'div') {
                                selector.innerHTML = v;
                            } else if (selector.tagName.toLowerCase() == 'span') {
                                selector.innerHTML = v;
                            }
                        }
                    });
                }
            });
        });

        $("#addDemande").on('click', function (e) {
            e.preventDefault();
            addMod = true;

            resetModaleDemande();

            $("#modalTitleDemande").html('Ajout d\'une demande');
            $("#saveModalDemande").text('Ajouter');
            $("#staticBackdropDemande").modal('show');
        });

        $('#saveModalDemande').on('click', function (e) {
            e.preventDefault();

            if (isModifiable) {
                let these = $(this);
                these.hide();

                var form = $("#kt_form_demande");
                var formData = (window.FormData) ? new FormData(form[0]) : null;
                var data = (formData !== null) ? formData : form.serialize();

                var clientOK = false;
                var autres_type_demandeOK = false;
                var autres_specificite_groupeOK = false;

                if ($('#nouveau_prospect').prop('checked')) {
                    if ($('#nom').val() != '' && $('#prenom').val() != '' && $('#codepostal').val() != '' && $('#ville').val() != '') {
                        clientOK = true;
                    }
                } else {
                    if ($('#select2_clients').val() != '' && $('#select2_clients').val() != null) {
                        clientOK = true;
                    }
                }

                if ($('#type_demande').val() != 'autres' || ($('#type_demande').val() == 'autres' && $('#autres_type_demande').val() != '')) {
                    autres_type_demandeOK = true;
                }

                if ($('#specificite_groupe').val() != 'autres' || ($('#specificite_groupe').val() == 'autres' && $('#autres_specificite_groupe').val() != '')) {
                    autres_specificite_groupeOK = true;
                }

                if (addMod) {
                    if (clientOK) {
                        if (autres_type_demandeOK && autres_specificite_groupeOK) {
                            validationAdd.validate().then(function (status) {
                                if (status == 'Valid') {
                                    $.ajax({
                                        type: "POST",
                                        url: "./assets/ajax/demandes/addDemande.php",
                                        data: data,
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success: function (data) {
                                            // location.reload();
                                        }
                                    });
                                } else {
                                    these.show();
                                    toastr.error('Merci de vérifier votre saisie !');
                                }
                            });
                        } else {
                            these.show();
                            toastr.error('Merci de remplir le(s) champ(s) "*Préciser" !');
                        }
                    } else {
                        these.show();
                        toastr.error('Prospect invalide !');
                    }
                } else {
                    formData.append('id', id);
                    if (clientOK) {
                        if (autres_type_demandeOK && autres_specificite_groupeOK) {
                            validationAdd.validate().then(function (status) {
                                if (status == 'Valid') {
                                    $.ajax({
                                        type: "POST",
                                        url: "./assets/ajax/demandes/modDemande.php",
                                        data: data,
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success: function (data) {
                                            // location.reload();
                                        }
                                    });
                                } else {
                                    these.show();
                                    toastr.error('Merci de vérifier votre saisie !');
                                }
                            });
                        } else {
                            these.show();
                            toastr.error('Merci de remplir le(s) champ(s) "*Préciser" !');
                        }
                    } else {
                        these.show();
                        toastr.error('Prospect invalide !');
                    }
                }
            }
        });

        $("button[data-number=5]").on('click', function (e) {
            e.preventDefault();
            $('#staticBackdropDemande').modal('hide');
        });

        function resetModaleDemande() {
            $('#kt_form_demande').trigger("reset");
            validationAdd.resetForm();
            $('#nouveau_prospect').prop('checked', false).trigger('change');
            $('#guidage_benevole').prop('checked', false);
            $('#guide_professionnel').prop('checked', false);
            $('#accueil_pmr').prop('checked', false);
            $('#type_demande').val('0').trigger('change');
            $('#specificite_groupe').val('0').trigger('change');

            if (isModifiable) {
                $('#staticBackdropDemande input').prop('disabled', false);
                $('#staticBackdropDemande select').prop('disabled', false);
                $('#staticBackdropDemande button').prop('disabled', false);
                $('#nouveau_prospect').prop('checked', false).trigger('change');
            } else {
                $('#staticBackdropDemande input').prop('disabled', true);
                $('#staticBackdropDemande select').prop('disabled', true);
                $('#staticBackdropDemande button:not([data-number="5"])').prop('disabled', true);
            }
        }
    }

    // Public Functions
    return {
        // public functions
        init: function () {
            _gereResource();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function () {
    KTModal.init();
});
