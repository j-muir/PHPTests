<div style="padding-right:50px;" class="topbar-item">
    <div id="kt_quick_user_toggle_delatopbar" style="cursor:pointer;text-align:right; padding-right: 0rem; margin-right: 0rem !important;" class="btn-hover-transparent-white btn-lg mr-6" id="kt_quick_secteur_toggle">
        <span style="color:white;">
            <?php

//            $arrayExercices = getAllExercices($connexion);
//            foreach($arrayExercices as $keyExercice => $valExercice){
//                if($valExercice['annee'] == $_SESSION['anneeExercice']){
//                    echo $valExercice['nom'];
//                }
//            }

            ?>
        </span>
<!--        <span style="color:white;">-->
<!--            |-->
<!--        </span>-->
<!--        <span style="color:white;" class="anomalieTopBar">-->
<!--            Anomalies-->
<!--        </span>-->
    </div>
</div>

<div class="topbar-item">
    <div class="btn btn-icon btn-hover-transparent-white w-sm-auto d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
        <div class="d-flex flex-column text-right pr-sm-3">
            <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-sm-inline"><?php echo $_SESSION['user']['prenom']; ?></span>
            <span class="text-white font-weight-bolder font-size-sm d-none d-sm-inline"><?php echo $_SESSION['user']['nom']; ?></span>
        </div>
        <span class="symbol symbol-35">
            <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30"><?php echo $_SESSION['user']['prenom'][0]; ?></span>
        </span>
    </div>
</div>

<script src="assets/plugins/global/plugins.bundle.js"></script>
<script>
    $('.topbar-item').click( function() {
        checkAnomalie();
    });

    function checkAnomalie(){
        /*$.ajax({
            type: "GET",
            url: "./assets/ajax/commandes/getAnomalieCommande.php",
            dataType: 'json',
            success: function (data) {
                $(".listeAnomalie").html('');
                var anomalieCommandes = parseInt(Object.keys(data).length);
                var ch = "";

                ch = getChaineProbleme(data, ch, 'Commandes', 'red');

                if(ch == ""){
                    ch = '<div class="mt-5 col-lg-12"><span>Aucune anomalie</span></div>';
                }

                var total = anomalieCommandes;

                $(".anomalieTopBar").html('Anomalies <span class="label pulse pulse-danger mr-10"><span class="position-relative">'+total+'</span><span class="pulse-ring"></span></span>');

                $(".listeAnomalieSideBar").html(ch);

                $(".listeAnomalieSideBar").on('click', '.goToCommande', function(){
                    var id = $(this).attr('data-id');
                    window.location = './admin/commandes.php?q='+id;
                });
            }
        });*/
    }

    /*function getChaineProbleme(data, ch, titre, typeAlert){
        var dejaMis = false;
        $.each(data, function(k, v){
            if(!dejaMis){
                ch += '<div class="col-lg-12"><span style="color:'+typeAlert+';"><b><u>'+ titre +'</u></b></span></div>';
                dejaMis = true;
            }

            ch += '<div class="mt-5 col-lg-12"><span data-id="' + k + '" class="goToCommande" style="cursor:pointer;color:' + typeAlert + ';"><b>' + v.numero + ' - ' + v.listeprestations +'</b><br />'+v.message+'</span></div>';

        });

        return ch;
    }*/

    setInterval(function (){
        $.ajax({
            type: "GET",
            url: "./assets/ajax/global/refreshSession.php"
        });
    }, 600000);

    checkAnomalie();
</script>