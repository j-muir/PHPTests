jQuery(document).ready(function () {
    $("#secteurGlobal, #secteurGlobaltopBar").change(function(){
        var val = $(this).val();
        $.ajax({
            type: "POST",
            url: "./assets/ajax/global/changeSecteur.php",
            data: {
                "val": val
            },
            success: function (html) {
                location.reload();
            }
        });
    });

    $("#millesimeGlobal").change(function(){
        var val = $(this).val();
        $.ajax({
            type: "POST",
            url: "./assets/ajax/global/changeMillesime.php",
            data: {
                "val": val
            },
            success: function (html) {
                location.reload();
            }
        });
    });
});