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

    };

    var _gereResource = function () {

    };

    // Public Functions
    return {
        // public functions
        init: function () {
            _page = $('.accueil a');
            _subpage = $('.factures');
            _header = $('#kt_header_tab_1');

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
