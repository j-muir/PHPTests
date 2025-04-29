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
        var datatable = table.DataTable({
            order: [[1, "desc"]],
            responsive: true,
            paging: true,
            iDisplayLength: 100,
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ],
            language: {
                url: './assets/json/dataTable_french.json'
            },
            columnDefs: []
        });

        $('#kt_datatable thead tr').clone(true).appendTo('#kt_datatable thead');
        $('#kt_datatable thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');

            $('input', this).on('keyup change', function () {
                if (datatable.column(i).search() !== this.value) {
                    datatable
                        .column(i)
                        .search(this.value)
                        .draw();
                }
            });
        });
    };

    // Public Functions
    return {
        // public functions
        init: function () {
            _page = $('.accueil a');
            _subpage = $('.demandesDevisees');
            _header = $('#kt_header_tab_1');

            _initMenu();
            _initTable();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function () {
    KTMainDashboard.init();
});
