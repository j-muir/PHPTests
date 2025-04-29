"use strict";

// Class Definition
var KTMainDashboardModalClient = function() {

    var id = 0;

    var _gereModalClient = function() {
        $('#saveModalDeleteClient').on('click', function (e){
            e.preventDefault();
            id =  $("#staticBackdropClient").attr('data-id');
            $.ajax({
                type: "POST",
                url: "./assets/ajax/clients/deleteClient.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status){
                        $("#infosToastBody").text(data.message);
                        $("#liveToastInformations").toast("show");
                        location.reload();
                    }else{
                        $("#erreursToastBody").text(data.message);
                        $("#liveToastErreurs").toast("show");
                    }
                }
            });
        });

        $('#deleteClient').on('click', function (e){
            e.preventDefault();
            $("#staticBackdropDeleteClient").modal('show');
        });

        $("button[data-number=4]").on('click', function(){
            $('#staticBackdropDeleteClient').modal('hide');
        });

        // Click sur annuler client
        $('#closeClientModal').on('click', function (e) {
            e.preventDefault();
            $('#staticBackdropClient').modal('hide');
        });

        // Click sur la croix client
        $("button[data-number=1]").on('click', function(){
            $('#staticBackdropClient').modal('hide');
        });
    };

    // Public Functions
    return {
        // public functions
        init: function() {
            _gereModalClient();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTMainDashboardModalClient.init();
});
