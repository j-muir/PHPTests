"use strict";

// Class Definition
var KTMainDashboard = function() {
    var _page;
    var _subpage;
    var _header;

    $('#select2_prestationsassociees').select2({
        placeholder: 'Prestations associées',
        multiple: true
    });

    var _initMenu = function() {
        _header.addClass('active');
        _page.addClass('active');
        _subpage.addClass('menu-item-active');
    };

    var _initTable = function() {
        var tableTypeTravaux = $('#kt_datatable_type_travaux');

        tableTypeTravaux.DataTable({
            responsive: true,
            paging: true,
            language: {
                url: './assets/json/dataTable_french.json'
            },
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2]
                    },
                    orientation: 'landscape'
                }
            ],
            columnDefs: [
                {
                }
            ]
        });
    }

    var _gereResource = function() {
        var validationAdd;
        var addMod;
        var id;
        var typeParametre;

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
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );


        $(".add").click(function(){
            addMod = true;
            typeParametre = $(this).attr('data-type');
            $('#kt_form_1').trigger("reset");
            validationAdd.resetForm();
            $("#select2_prestationsassociees").val(null).trigger("change");
            $("#modalTitle").html('Ajout d\''+$(this).attr('data-affiche'));
            $("#saveModal").text('Ajouter');
        });

        $(".mod").click(function(){
            addMod = false;
            typeParametre = $(this).attr('data-type');
            $("#modalTitle").html('Modification d\''+$(this).attr('data-affiche'));
            $("#saveModal").text('Modifier');
            id = $(this).attr('data-id');
            var url;
            switch(typeParametre){
                case 'type_travaux':
                    url = "./assets/ajax/parametres/getTypeTravaux.php";
                    break
                default:
                    url = "./assets/ajax/parametres/getParametre.php";
                    break;
            }
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    "id": id,
                    "typeParametre": typeParametre
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function(k, v){
                        if(k == 'travauxisolation'){
                            if(v == 1){
                                $("#"+k).prop('checked', true);
                            }else{
                                $("#"+k).prop('checked', false);
                            }
                        }
                        if (k == 'idrefprestation' && (v !== null || v !== '')) {
                            $('#select2_prestationsassociees').val(v);
                            $('#select2_prestationsassociees').trigger('change');
                        }
                        $("#"+k).val(v);
                    });

                    $("#staticBackdrop").modal();
                }
            });
        });

        $('#saveModal').on('click', function (e) {
            e.preventDefault();
            $(this).hide();
            let url;
            let data;
            switch(typeParametre){
                case 'type_travaux':
                    url = "./assets/ajax/parametres/addTypeTravaux.php";
                    data = {
                        "data": $('#kt_form_1').serialize(),
                        "listeIdPrestations": $('#select2_prestationsassociees').val(),
                        "listeRefPrestations": $('#select2_prestationsassociees option:selected').text()
                    };
                    break
                default:
                    url = "./assets/ajax/parametres/addParametre.php";
                    data= {
                        "data": $('#kt_form_1').serialize(),
                        "typeParametre": typeParametre
                    };
                    break;
            }
            if(addMod) {
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function (html) {
                                if (html == true) {
                                    location.reload();
                                }
                            }
                        });
                    }else{
                        $('#saveModal').show();
                    }
                });
            }else{
                switch(typeParametre){
                    case 'type_travaux':
                        url = "./assets/ajax/parametres/modTypeTravaux.php";
                        data = {
                            "data": $('#kt_form_1').serialize(),
                            "id": id,
                            "listeIdPrestations": $('#select2_prestationsassociees').val(),
                            "listeRefPrestations": $('#select2_prestationsassociees option:selected').text()
                        };
                        break
                    default:
                        url = "./assets/ajax/parametres/modParametre.php";
                        data= {
                            "data": $('#kt_form_1').serialize(),
                            "typeParametre": typeParametre,
                            "id": id
                        };
                        break;
                }
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: data,
                            success: function (html) {
                                if (html == true) {
                                    location.reload();
                                }
                            }
                        });
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
            _subpage = $('.parametresApplication');
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
