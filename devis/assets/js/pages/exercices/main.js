"use strict";

// Class Definition
var KTMainDashboard = function () {
    var _page;
    var _subpage;
    var _header;

    var _initMenu = function () {
        _header.addClass('active');
        _page.addClass('active');
        _subpage.addClass('menu-item-active');
    };

    var _initTable = function () {
        var table = $('#kt_datatable');

        // begin first table
        table.DataTable({
            order: [2, 'asc'],
            responsive: true,
            paging: true,
            language: {
                url: './assets/json/dataTable_french.json'
            },
            columnDefs: [
                {
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var status = {
                            1: {'title': 'Actif', 'class': ' label-light-success'},
                            0: {'title': 'Inactif', 'class': ' label-light-danger'}
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline" style="cursor:pointer">' + status[data].title + '</span>';
                    }
                }
            ]
        });
    };

    var _gereResource = function () {
        var validationAdd;
        var addMod;
        var id;

        validationAdd = FormValidation.formValidation(
            document.getElementById('kt_form_1'),
            {
                fields: {
                    nomexercice: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    annee: {
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

        $("#addExercice").click(function () {
            addMod = true;
            $('#kt_form_1').trigger("reset");
            $("#modalTitle").html('Ajout d\'un exercice');
            $("#saveModal").text('Ajouter');
        });

        $(".modExercice").click(function () {
            addMod = false;
            $("#modalTitle").html('Modification d\'un exercice');
            $("#saveModal").text('Valider');
            id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: "./assets/ajax/exercices/getExercice.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (k, v) {
                        $("#" + k).val(v)
                    });

                    $("#staticBackdrop").modal();
                }
            });
        });

        $('#saveModal').on('click', function (e) {
            e.preventDefault();
            $(this).hide();
            var form = $("#kt_form_1");
            var formData = (window.FormData) ? new FormData(form[0]) : null;
            var data = (formData !== null) ? formData : form.serialize();
            
            if (addMod) {
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/exercices/addExercice.php",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (html) {
                                if (html == true) {
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        $('#saveModal').show();
                        $('#saveModal').css('display', 'block');
                    }
                });
            } else {
                formData.append('id', id)
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/exercices/modExercice.php",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (html) {
                                if (html == true) {
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        $('#saveModal').show();
                        $('#saveModal').css('display', 'block');
                    }
                });
            }
        });

        $('.changeExerciceActif').click(function () {
            var id = $(this).attr('data-id');
            $("#modalChangeExercice").modal();

            $('#saveModalChangeExercice').click(function () {
                $.ajax({
                    type: "POST",
                    url: "./assets/ajax/exercices/changeExercice.php",
                    data: {
                        "id": id
                    },
                    success: function (html) {
                        if (html == true) {
                            location.href = "./index.php";
                        }
                    }
                });
            })
        });
    };

    // Public Functions
    return {
        // public functions
        init: function () {
            _page = $('.parametres a');
            _subpage = $('.exercices');
            _header = $('#kt_header_tab_3');

            _initMenu();
            _initTable();
            _gereResource();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function () {
    KTMainDashboard.init();
});
