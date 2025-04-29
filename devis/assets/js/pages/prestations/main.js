"use strict";

// Class Definition
var KTMainDashboard = function() {
    var _page;
    var _subpage;
    var _header;

    $('#unites').select2({
        placeholder: 'Unité',
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
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                    }
                }
            ],
            language: {
                url: './assets/json/dataTable_french.json'
            },
            columnDefs: [
            ]
        });

        $('#kt_datatable thead tr').clone(true).appendTo( '#kt_datatable thead' );
        $('#kt_datatable thead tr:eq(1) th').each( function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="Rechercher par ' + title + '" />');

            $('input', this).on('keyup change', function () {
                if (datatable.column(i).search() !== this.value) {
                    datatable
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });

        $('#kt_datatable_search_status').on('change', function() {
            datatable.search($(this).val().toLowerCase(), 'Status');
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
                    reference: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    designationSimple: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    prixHT: {
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

        $('input[type=file]').css('color', 'transparent');

        $("#addPrestations").click(function(){
            addMod = true;

            $('#kt_form_1').trigger("reset");
            validationAdd.resetForm();
            $("#modalTitle").html('Ajout d\'une prestation');
            $("#saveModal").text('Ajouter');
            $("#tva_5_5").prop('checked', false);
            $("#tva_10").prop('checked', false);
        });

        $(".modPrestation").click(function(){
            addMod = false;
            $("#modalTitle").html('Modification d\'une prestation');
            $("#saveModal").text('Modifier');
            $("#tva_5_5").prop('checked', false);
            $("#tva_10").prop('checked', false);
            id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: "./assets/ajax/prestations/getPrestation.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    var unite;
                    $('.select2-selection').css('height', '30px');
                    $.each(data, function(k, v){
                        if (k == 'tva'){
                            if (v.includes("0")){
                                $("#tva_0").prop('checked', true);
                            }

                            if (v.includes("5.5")){
                                $("#tva_5_5").prop('checked', true);
                            }

                            if (v.includes("10")){
                                $("#tva_10").prop('checked', true);
                            }

                            if (v.includes("20")){
                                $("#tva_20").prop('checked', true);
                            }
                        }else if (k == 'ficherenseignement'){
                            if(v == 1) {
                                $("#ficherenseignement").prop('checked', true);
                            }else{
                                $("#ficherenseignement").prop('checked', false);
                            }
                        }else {
                            $("#"+k).val(v);
                        }

                        if (k == 'unite') {
                            unite = v;
                        }
                    });



                    $("#unite").val(unite).trigger('change');

                    $("#staticBackdrop").modal();
                }
            });
        });

        $("input[name='tva']").click(function(){
            calculMontantHT();
        });

        $("#prixTTC").keyup(function(){
            calculMontantHT();
        });

        function calculMontantHT(){
            var montant = parseFloat($("#prixTTC").val());
            var tva = 0;
            if($("#tva_10").prop('checked')){
                tva = 10;
            }else if($("#tva_20").prop('checked')){
                tva = 20;
            }else if($("#tva_5_5").prop('checked')){
                tva = 5.5;
            }
            var montantHT = parseFloat(montant) - ((parseFloat(montant) * parseFloat(tva)) / 100);
            $("#prixHT").val(montantHT.toFixed(2));
        }

        $('#saveModal').on('click', function (e) {
            e.preventDefault();
            $(this).hide();

            var form = $("#kt_form_1");
            var formData = (window.FormData) ? new FormData(form[0]) : null;
            $("#prixHT").prop('disabled', false);

            if(addMod) {
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/prestations/addPrestation.php",
                            data: {
                                "data": $("#kt_form_1").serialize()
                            },
                            dataType: 'json',
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
                formData.append('id', id);
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/prestations/modPrestation.php",
                            data: {
                                "data": $("#kt_form_1").serialize(),
                                "id": id
                            },
                            dataType: 'json',
                            success: function (html) {
                                if (html == true) {
                                    location.reload();
                                } else {
                                    $('#saveModal').show();
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
            _subpage = $('.prestations');
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
