"use strict";

// Class Definition
var KTMainDashboard = function () {
    var _page;
    var _subpage;
    var _header;
    var datatable;
    var idFicheMod = 0;

    var _initMenu = function () {
        _header.addClass('active');
        _page.addClass('active');
        _subpage.addClass('menu-item-active');
    };

    var _initTable = function () {
        $('#select2_prestations').select2({
            placeholder: 'Choisissez une prestation'
        });

        // begin first table
        var table = $('#kt_datatable');
        datatable = table.DataTable({
            "ajax": './assets/ajax/fiches/getFichesDatatable.php',
            "columns": [
                {"data": 'numero'},
                {"data": 'date'},
                {"data": 'qui'},
                {"data": 'infos'},
                {"data": 'devis'},
                {"data": 'avalider'},
                {"data": 'mail'},
                {"data": 'papier'},
                {"data": 'refuse'},
                {"data": 'commande'}
            ],
            "createdRow": function (row, data, index) {
                $(row).addClass('modFiche');
            },
            initComplete: function (settings, json) {
                if(idFicheMod !== 0){
                    $("tr[data-id='"+idFicheMod+"']").css('background-color', 'red');
                }
            },
            order: [[0, "desc"]],
            responsive: true,
            paging: true,
            iDisplayLength: 10,
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1]
                    }
                }
            ],
            language: {
                url: './assets/json/dataTable_french.json'
            },
            columnDefs: [
                {
                    targets: [4, 5, 6, 7, 8, 9],
                    render: function (data, type, full, meta) {
                        var status = {
                            2: {'couleur': 'green', 'border': 'green'},
                            1: {'couleur': 'red', 'border': 'red'},
                            0: {'couleur': 'gray', 'border': 'gray'}
                        };

                        if (typeof status[data] === 'undefined') {
                            return data;
                        }

                        return '<div style="border:1px solid '+status[data].border+';width:15px;height:15px; background-color:'+status[data].couleur+';"></div>';
                    }
                }
            ]
        });

        $('#kt_datatable thead tr').clone(true).appendTo('#kt_datatable thead');
        $('#kt_datatable thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            if(title.toLowerCase() === 'n°' || title.toLowerCase() === 'date' || title.toLowerCase() === 'infos') {
                $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');

                $('input', this).on('keyup change', function () {
                    if (datatable.column(i).search() !== this.value) {
                        datatable
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }else{
                $(this).html('');
            }
        });
    };

    var _initForm = function () {
        const typingDelay = 500;
        clearForm();
        disabledForm();

        $(".addDemande").click(function(){
            clearForm();
            disabledForm();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/fiches/addFiche.php",
                dataType: 'json',
                success: function (data) {
                    enableForm();
                    idFicheMod = data.idFicheAdded;
                    $("#numero").val(data.numeroFicheAdded);
                    $("#datedemande").val(data.dateDemandeFicheAdded);
                    $("#dateaenvoyer").val(data.datePourFicheAdded);
                    $(".infoFiche").val(data.infoFicheAdded);
                    $(".effaceFiche").prop('disabled', false);
                    datatable.ajax.reload(function (json) {
                        $('tr[id="'+idFicheMod+'"]').css('background-color', '#0087cc42');
                    }, false);
                    $(".divDetailFiche").show();
                    $(".btnAddFiche").hide();
                }
            });
        });

        $("#kt_form_demande").on('change', 'input[type="checkbox"]:not(".prestationcomplementaire"), input[type="datetime-local"]:not(".prestationcomplementaire"), input[type="date"]:not(".prestationcomplementaire"), select', function(){
            var these = $(this);
            var elementMod = $(this).attr('data-ceb');
            var typeSelector = this.tagName.toLowerCase();
            var valueSelector = '';
            if (typeSelector === 'input'){
                switch (this.getAttribute('type')) {
                    case 'text':
                    case 'number':
                    case 'email':
                    case 'tel':
                    case 'date':
                    case 'datetime-local':
                        valueSelector = these.val();
                        break;
                    case 'checkbox':
                        let isChecked = 0;
                        if (these.prop('checked') === true) {
                            isChecked = 1;
                        }
                        valueSelector = isChecked;
                        break;
                    default:
                        break;
                }
            } else if (typeSelector === 'select' || typeSelector === 'textarea') {
                valueSelector = $(this).val();
            }

            if(elementMod === 'mois_visite'){
                $("#datevisite").val('');
                $("#heurevisite").val('');
                $("#option").prop('checked', false).prop('disabled', true);
            }else if(elementMod === 'date_visite'){
                $("#mois_visite").val('');
                $("#option").prop('disabled', false);
            }

            clearTimeout(these.data('typingTimer'));
            const timer = setTimeout(function() {
                userStoppedTyping(elementMod, valueSelector, idFicheMod);
            }, typingDelay);
            these.data('typingTimer', timer);
        });

        $("#kt_form_demande").on('keyup', 'input[type="text"]:not(".prestationcomplementaire"), textarea', function(){
            var these = $(this);
            var elementMod = $(this).attr('data-ceb');
            var typeSelector = this.tagName.toLowerCase();
            var valueSelector = '';
            if (typeSelector === 'input'){
                switch (this.getAttribute('type')) {
                    case 'text':
                    case 'number':
                    case 'email':
                    case 'tel':
                    case 'date':
                    case 'datetime-local':
                        valueSelector = these.val();
                        break;
                    case 'checkbox':
                        let isChecked = 0;
                        if (these.prop('checked') === true) {
                            isChecked = 1;
                        }
                        valueSelector = isChecked;
                        break;
                    default:
                        break;
                }
            } else if (typeSelector === 'select' || typeSelector === 'textarea') {
                valueSelector = $(this).val();
            }

            if(elementMod === 'mois_visite'){
                $("#datevisite").val('');
                $("#heurevisite").val('');
            }else if(elementMod === 'date_visite'){
                $("#mois_visite").val('');
            }

            clearTimeout(these.data('typingTimer'));
            const timer = setTimeout(function() {
                userStoppedTyping(elementMod, valueSelector, idFicheMod);
            }, typingDelay);
            these.data('typingTimer', timer);
        });

        function userStoppedTyping(elementModF, valueSelectorF, idFicheModF) {
            makeAjaxCall(elementModF, valueSelectorF, idFicheModF)
            .done(function(response) {
            })
            .fail(function() {
            });
        }

        function makeAjaxCall(elementModF, valueSelectorF, idFicheModF) {
            return $.ajax({
               type: "POST",
               url: "./assets/ajax/fiches/modFiche.php",
               data: {
                   "elementMod": elementModF,
                   "value": valueSelectorF,
                   "idFiche": idFicheMod
               },
               dataType: 'json',
               success: function (data) {
                   datatable.ajax.reload(function (json) {
                        $('tr[id="'+idFicheMod+'"]').css('background-color', '#0087cc42');
                    }, false);
                   signalEnregistrement();
               },
               error: function(data){
                    signalErreur();
               }
           });
        }

        $("#kt_form_demande").on('change', '.prestationcomplementaire', function(){
            var valueSelector = {};
            $(".prestationcomplementaire").each(function(k, v){
                if($(this).prop('checked')){
                    valueSelector[$(this).attr('data-id')] = 1;
                }
            });

            $.ajax({
                type: "POST",
                url: "./assets/ajax/fiches/modPrestationFiche.php",
                data: {
                    "value": valueSelector,
                    "idFiche": idFicheMod
                },
                dataType: 'json',
                success: function (data) {
                    datatable.ajax.reload(function (json) {
                        $('tr[id="'+idFicheMod+'"]').css('background-color', '#0087cc42');
                    }, false);
                    signalEnregistrement();
                }
            });
        });

        $("#kt_datatable").on('click', '.modFiche', function(){
            var these = $(this);
            clearForm();
            $("#kt_datatable tr").css('background-color', '');
            these.css('background-color', '#0087cc42');
            idFicheMod = $(this).attr('id');
            enableForm();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/global/getBlocage.php",
                data: {
                    "id": idFicheMod,
                    "type": 'fiche'
                },
                dataType: 'json',
                success: function (data) {
                    var dataBlocage = data;
                    $.ajax({
                        type: "POST",
                        url: "./assets/ajax/fiches/getDetailFiche.php",
                        data: {
                            "id": idFicheMod
                        },
                        dataType: 'json',
                        success: function (data) {
                            $.each(data, function (k, v) {
                                if(k !== 'prestationssuplementaires') {
                                    let selector = document.querySelector('#' + k);
                                    if (selector) {
                                        if (selector.tagName.toLowerCase() === 'input') {
                                            switch (selector.getAttribute('type')) {
                                                case 'text':
                                                case 'number':
                                                case 'email':
                                                case 'tel':
                                                case 'date':
                                                case 'datetime-local':
                                                    selector.value = v;
                                                    break;
                                                case 'checkbox':
                                                    let isChecked = false;
                                                    if (v !== 0) {
                                                        isChecked = true;
                                                    }
                                                    selector.checked = isChecked;
                                                    break;
                                                default:
                                                    break;
                                            }
                                        } else if (selector.tagName.toLowerCase() === 'select') {
                                            $('#' + k).val(v);
                                        } else if (selector.tagName.toLowerCase() === 'textarea') {
                                            selector.value = v;
                                        } else if (selector.tagName.toLowerCase() === 'span' || selector.tagName.toLowerCase() === 'html' || selector.tagName.toLowerCase() === 'small') {
                                            selector.innerHTML = v;
                                        }
                                    }
                                }else{
                                    $.each(v, function(kP, vP){
                                        let isChecked = false;
                                        if (vP !== 0) {
                                            isChecked = true;
                                        }

                                        $(".prestationcomplementaire[data-id='"+kP+"']").prop('checked', isChecked);
                                    });
                                }
                            });

                            $(".effaceFiche").prop('disabled', false);

                            if(dataBlocage.status === true){
                                disabledForm();
                                Swal.fire({
                                    text: "La fiche est actuellement en cours de modification par "+dataBlocage.login+'. Vous ne pouvez donc pas modifier cette fiche mais vous pouvez la consulter.',
                                    icon: "danger",
                                    buttonsStyling: false,
                                    showCancelButton: false,
                                    confirmButtonText: "J'ai compris",
                                    customClass: {
                                        confirmButton: "btn btn-danger",
                                    }
                                }).then(function (result) {

                                });
                            }else{
                                enableForm();
                                $.ajax({
                                    type: "POST",
                                    url: "./assets/ajax/global/blocage.php",
                                    data: {
                                        "data": idFicheMod,
                                        "table": 'fiche'
                                    },
                                    dataType: 'json',
                                    success: function (datab) {

                                    }
                                });
                            }

                            $(".divDetailFiche").show();
                            $(".btnAddFiche").hide();
                        }
                    });
                },
                error: function(data){
                     signalErreur();
                }
            });
        });

        $(".effaceFiche").click(function(){
            var these = $(this);
            Swal.fire({
                text: "Êtes-vous sûr de vouloir supprimer la fiche ?",
                icon: "danger",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Oui, je supprime",
                cancelButtonText: "Non, j'annule",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "./assets/ajax/fiches/effaceFiche.php",
                        data: {
                            "idFiche": idFicheMod
                        },
                        dataType: 'json',
                        success: function (data) {
                            clearForm();
                            disabledForm();
                            datatable.ajax.reload(function (json) {
                                $('tr[id="'+idFicheMod+'"]').css('background-color', '#0087cc42');
                            }, false);
                            $(".divDetailFiche").hide();
                            $(".btnAddFiche").show();
                        }
                    });
                }
            });
        });

        function signalEnregistrement(){
            $('.divEnregistrementReussi').show();
            setTimeout(function() {
                $('.divEnregistrementReussi').hide();
            }, 1000);
        }

        function signalErreur(){
            $('.divEnregistrementErreur').show();
            setTimeout(function() {
                $('.divEnregistrementErreur').hide();
            }, 1000);
        }

        function disabledForm(){
            $("#kt_form_demande input[type='text'], #kt_form_demande input[type='date'], #kt_form_demande input[type='datetime-local'], #kt_form_demande input[type='month'], textarea").prop('disabled', true);
            $("#kt_form_demande input[type='checkbox']").prop('disabled', true);
            $("#kt_form_demande select").prop('disabled', true);
            $(".effaceFiche").prop('disabled', true);
        }

        function enableForm(){
            $("#kt_form_demande input[type='text'], #kt_form_demande input[type='date'], #kt_form_demande input[type='datetime-local'], #kt_form_demande input[type='month'], textarea").prop('disabled', false);
            $("#kt_form_demande input[type='checkbox']").prop('disabled', false);
            $("#kt_form_demande select").prop('disabled', false);
            $("#numero").prop('disabled', true);
        }

        function clearForm(){
            idFicheMod = 0;
            $("#kt_form_demande")[0].reset();
            $("#kt_form_demande input[type='text'], #kt_form_demande input[type='date'], #kt_form_demande input[type='datetime-local'], #kt_form_demande input[type='month']").val('');
            $("#infoFiche").html('');
            $("#kt_form_demande input[type='checkbox']").prop('checked', false);
            $("#kt_form_demande select").prop('selectedIndex', 0);
        }
    }

    var _initUtilities = function(){
        function refreshSession() {
            $.ajax({
                url: './assets/ajax/global/refreshSession.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                },
                error: function(xhr, status, error) {
                    console.error('Erreur : ', error);
                }
            });
        }

        setInterval(refreshSession, 300000);

        $('#numtel').on("keyup change", function() {
            this.value = formateTelephone(this.value);
        });

        function generateHourList(startHour, endHour, intervalMinutes) {
            const select = document.getElementById('heurevisite');
            const startTime = new Date();
            startTime.setHours(startHour, 0, 0, 0);

            const endTime = new Date();
            endTime.setHours(endHour, 0, 0, 0);

            const option = document.createElement('option');
            option.value = ``;
            option.text = `-`;
            select.appendChild(option);

            while (startTime <= endTime) {
                const option = document.createElement('option');
                const hour = String(startTime.getHours()).padStart(2, '0');
                const minute = String(startTime.getMinutes()).padStart(2, '0');
                option.value = `${hour}:${minute}`;
                option.text = `${hour}:${minute}`;
                select.appendChild(option);
                startTime.setMinutes(startTime.getMinutes() + intervalMinutes);
            }
        }

        generateHourList(8, 17, 30);

        function formateTelephone(value){
            value = value.replace(/ /g,'');
            value = value.replace(/\D/g,'');
            return value.replace(/\B(?=(\d{2})+(?!\d))/g, " ");
        }
    }

    // Public Functions
    return {
        // public functions
        init: function () {
            _page = $('.accueil a');
            _subpage = $('.fichesrenseignement');
            _header = $('#kt_header_tab_1');

            _initMenu();
            _initTable();
            _initForm();
            _initUtilities();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function () {
    KTMainDashboard.init();
});
