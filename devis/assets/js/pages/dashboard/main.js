"use strict";

// Class Definition
var KTMainDashboard = function() {
    var _page;
    var _subpage;
    var _header;

    var _initMenu = function() {
        _header.addClass('active');
        _page.addClass('active');
        _subpage.addClass('menu-item-active');

        $('#kt_select2_dateAccueil').select2({
            placeholder: 'Choisissez la date'
        });
    };

    var _initTable = function() {

    };

    var _gereResource = function() {

        $('#kt_select2_dateAccueil').on('change', function(e) {
            var exercice = $(this).val();

            $.ajax({
                type: "POST",
                url: "./assets/ajax/general/changeExercice.php",
                data: {
                    "data": exercice
                },
                dataType: 'html',
                success: function (data) {
                    location.reload();
                }
            });
        });
    };

    return {
        // public functions
        init: function() {
            _page = $('.accueil a');
            _subpage = $('.dashboard');
            _header = $('#kt_header_tab_1');

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
