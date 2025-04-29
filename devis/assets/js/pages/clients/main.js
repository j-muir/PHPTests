"use strict";

// Class Definition
var KTMainDashboard = function() {
    var _page;
    var _subpage;
    var _header;

    $(".professionnel").hide();

    $('#codenumtel').select2({
        placeholder: 'Indicatif téléphonique',
    });

    $('#codenumportable').select2({
        placeholder: 'Indicatif téléphonique',
    });

    $('#type').select2({
        placeholder: 'Type de client',
    });

    $('#civilite').select2({
        placeholder: 'Civilité',
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
                        columns: [ 0, 1, 2 ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2 ]
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
        var addMod;
        var id;
        var idCommande;
        var validationAdd;

        validationAdd = FormValidation.formValidation(
            document.getElementById('kt_form_client'),
            {
                fields: {
                    societe: {
                        validators: {
                            notEmpty: {
                                enabled: false,
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    nom: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    prenom: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    ville: {
                        validators: {
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    codepostal: {
                        validators: {
                            integer: {
                                message: 'Le code postal ne doit contenir que des chiffres',
                            },
                            notEmpty: {
                                message: 'Champ obligatoire'
                            }
                        }
                    },
                    email: {
                        validators: {
                            emailAddress: {
                                message: 'L\'adresse renseignée n\'est pas une adresse email valide'
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

        $("#type").on('change', function() {
            var type = $("#type").val();
            switch (type) {
                case "Particulier":
                    $(".professionnel").hide();
                    validationAdd.disableValidator('societe');
                    break;
                case "Professionnel":
                    $(".professionnel").show();
                    validationAdd.enableValidator('societe');
                    break;
            }
        });
        $('input[type=file]').css('color', 'transparent');

        $("#addClients").click(function(){
            addMod = true;

            $("#staticBackdropClient .modal-dialog").removeClass('modal-xl').addClass('modal-lg');
            $('#deleteClient').hide();
            $(".historiqueCommande").hide();
            $(".historiqueDemande").hide();
            $(".taillecolonne").addClass('col-lg-12').removeClass('col-lg-6');
            $('#kt_form_client').trigger("reset");
            validationAdd.resetForm();
            $("#modalTitleClient").html('Ajout d\'un client/prospect');
            $("#modalTitleClient").attr('data-modifier', 'false');
            $("#saveModalClient").text('Ajouter');
            $('#kt_datatable_commande').hide();
            $("#staticBackdropClient").modal('show');
        });


        $(".modClient").click(function(){
            $('#deleteClient').show();
            addMod = false;
            $(".historiqueCommande").show();
            $(".historiqueDemande").show();
            $("#staticBackdropClient .modal-dialog").addClass('modal-xl').removeClass('modal-lg');
            $(".taillecolonne").addClass('col-lg-6').removeClass('col-lg-12');
            $("#modalTitleClient").html('Modification d\'un client/prospect');
            $("#modalTitleClient").attr('data-modifier', 'true');
            $("#saveModalClient").text('Modifier');
            id = $(this).attr('data-id');
            $("#staticBackdropClient").attr('data-id', id);
            $('#kt_datatable_commande').show();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/clients/getClient.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    var type;
                    var civilite;
                    var commandes;
                    $('.select2-selection').css('height', '30px');
                    $.each(data, function(k, v){
                        $("#"+k).val(v);

                        if(k == 'codenumtel') {
                            if ($('#'+k).find("option[value='" + v + "']").length) {
                                $('#'+k).val(v).trigger('change');
                            } else {
                                if ($('#'+k).find("option[value='" + '+33' + "']").length) {
                                    $('#' + k).val('+33').trigger('change');
                                }
                            }
                        }
                        if(k == 'codenumportable') {
                            if ($('#'+k).find("option[value='" + v + "']").length) {
                                $('#'+k).val(v).trigger('change');
                            } else {
                                if ($('#'+k).find("option[value='" + '+33' + "']").length) {
                                    $('#' + k).val('+33').trigger('change');
                                }
                            }
                        }

                        if (k == 'numtel' || k == 'numportable'){
                            $("#"+k).val(formateTelephone(v));
                        }

                        if (k == 'type' && v != 0) {
                            type = v;
                        }

                        if (k == 'civilite') {
                            civilite = v;
                        }

                        if(k == 'commandeshtml'){
                            commandes = v;
                        }
                    });

                    if(type !== "") {
                        $("#type").val(type).trigger('change');
                    }

                    if(civilite !== "0") {
                        $("#civilite").val(civilite).trigger('change');
                    }else {
                        $("#civilite").val("Aucun").trigger('change');
                    }

                    if (commandes != undefined && commandes != null && commandes != ""){
                        $('#commandes').html(commandes);
                        $('#deleteClient').prop('disabled', true);
                    }else{
                        commandes = '<tr><td class="text-center" colSpan="4">Aucun devis passé.</td></tr>';
                        $('#commandes').html(commandes);
                        $('#deleteClient').prop('disabled', false);
                    }

                    $("#staticBackdropClient").modal();
                }
            });
        });

        $('#saveModalClient').on('click', function (e) {
            e.preventDefault();
            $(this).hide();

            var form = $("#kt_form_client");
            var formData = (window.FormData) ? new FormData(form[0]) : null;
            var data = (formData !== null) ? formData : form.serialize();

            if(addMod) {
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        let these = $(this);
                        these.hide();
                        id =  $("#staticBackdropClient").attr('data-id');
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/clients/addClient.php",
                            data: {
                                "data": $("#kt_form_client").serialize()
                            },
                            dataType: 'json',
                            success: function (html) {
                                location.reload();
                            }
                        });
                    }else{
                        $('#saveModalClient').show();
                    }
                });
            }else{
                formData.append('id', id);
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/clients/modClient.php",
                            data: {
                                "data": $("#kt_form_client").serialize(),
                                "id": id
                            },
                            success: function (html) {
                                location.reload();
                            }
                        });
                    }else{
                        $('#saveModalClient').show();
                    }
                });
            }
        });

        /* LA COMMANDE */
        $('#staticBackdropCommande .modal-body input').prop('disabled', true);
        $('#staticBackdropCommande .modal-body button').prop('disabled', true);
        $('#staticBackdropCommande .modal-body select').prop('disabled', true);
        $('#staticBackdropCommande .modal-body textarea').prop('disabled', true);
        $('#staticBackdropCommande #info').summernote('disable');
        $('#staticBackdropCommande .listePrestations ').attr("style", "pointer-events: none;");
        $('#staticBackdropCommande .etatCommande').attr("style", "pointer-events: none;");
        $("#staticBackdropCommande #saveModalCommande").text('Modifier').prop('disabled', true);
        $("#staticBackdropCommande #cancelModal").text('Fermer');
        $("#staticBackdropCommande #annulerCommande").hide();

        $("body").on('dblclick', '.commandesClient', function(){
            addMod = false;
            $("#select2_clients").val(null).trigger('change');
            $('.etatCommande').show();
            $("#modalTitleCommande").html('Affichage d\'une commande');
            $("#saveModalCommande").hide();
            idCommande = $(this).attr('data-id');
            getCommande(idCommande);
        });

        let listePrestations;
        let totalHT;
        let totalRemise;
        let totalNet;
        let totalRemisePourcent;
        let totalTTC;
        let nomclient;
        let adresseclient;
        let totalTVA;
        let info;

        function getCommande(idCommande) {
            listePrestations = [];
            totalHT = 0;
            totalRemise = 0;
            totalRemisePourcent = 0;
            totalNet = 0;
            totalTTC = 0;
            $('#changerEtatCommandeConfirmer').hide();
            $('#changerEtatCommandeAnnuler').hide();
            $(".listePrestations").html('');
            $(".encaisseFacture").hide();
            $("#encaisseFacturation").html('');
            $.ajax({
                type: "POST",
                url: "./assets/ajax/commandes/getCommande.php",
                data: {
                    "id": idCommande
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function(k, v){
                        if(k == 'historique'){
                            gereHistorique(v);
                        }

                        if(k == 'idclient'){
                            $("#select2_clients").val(v).trigger('change');
                            $.ajax({
                                type: "POST",
                                url: "./assets/ajax/clients/getClient.php",
                                data: {
                                    "id": v
                                },
                                dataType: 'json',
                                success: function (data) {
                                    nomclient = data.prenom + ' ' + data.nom;
                                    adresseclient = data.adresse + ' ' + data.codepostal + ' ' + data.ville;
                                }
                            });
                        }

                        if(k == 'totalHT'){
                            totalHT = parseFloat(v);
                            $("."+k).html(formateChiffreEuroSpan(v));
                        }

                        if(k == 'totalNet'){
                            totalNet = parseFloat(v);
                            $("."+k).html(formateChiffreEuroSpan(v));
                        }

                        if(k == 'totalTTC'){
                            totalTTC = parseFloat(v);
                            $("."+k).html(formateChiffreEuroSpan(v));
                        }

                        if(k == 'remise'){
                            totalRemise = parseFloat(v);
                        }

                        if(k == 'remisePourcent'){
                            totalRemisePourcent = parseFloat(v);
                        }

                        if(k == 'totalTVA'){
                            totalTVA = parseFloat(v);
                            $("."+k).html(formateChiffreEuroSpan(v));
                        }

                        if(k == 'listePrestation'){
                            listePrestations = JSON.parse(v);
                            initialiseListePrestation(listePrestations);
                        }

                        if(k == 'adressetravaux'){
                            if(v == 1){
                                $("input[name='adresseTravaux']").prop('checked', true);
                                $(".lesChampsTravaux").prop('disabled', true);
                            }else{
                                $("input[name='adresseTravaux']").prop('checked', false);
                                $(".lesChampsTravaux").prop('disabled', false);
                            }
                        }

                        if(k == 'modepaiement'){
                            if(v == 'Crédit'){
                                $(".paiementcredit").show();
                            }else{
                                $(".paiementcredit").hide();
                            }
                            $('#modepaiementfact').val(v);
                        }

                        if (k == 'solde'){
                            $('.solde').val(v);
                        }

                        if (k == 'numero'){
                            $('#numcomfact').val(v);
                        }

                        if (k == 'travauxaexecuter'){
                            $('#objetfact').val(v);
                        }

                        $("#"+k).val(v);

                        if(k == 'info'){
                            info = v.replaceAll('<br />', '\n');
                            $("#info").val(info);
                            $("#info").summernote("code", v);
                        }
                    });

                    $(".etatCommande").html(data.etathtml);
                    calculMontantTTC(listePrestations);
                    $("#staticBackdropCommande").modal({keyboard: false});
                }
            });
        }

        function initialiseListePrestation(listePrestations){
            $(".listePrestations").html('');
            $.each(listePrestations, function(k, v){

                if(v.type == 'prestation'){
                    addPrestationToHTML(k, v.id, v.code, v.montant, v.designation, v.quantite, v.tva, v.unite, formateChiffreEuroSpan(v.montanttotalprestation), v.categorie);
                }else{
                    addPrestationLigneToHTML(k, v.id, v.code, v.designation);
                }

            });
        }

        function addPrestationToHTML(cle, idPrestation, codePrestation, montantPrestation, designationPrestation, quantite, tvaPrestation, unitePrestation, montanttotalprestation, categorie){
            designationPrestation = designationPrestation.replaceAll('<br />', '\n');
            let designation = designationPrestation;
            let tailleBR = designation.match(/[^\n]*\n[^\n]*/gi);
            let leLength = 0;
            if(tailleBR !== null){
                leLength = tailleBR.length;
            }

            let combienBR = leLength + designation.split('\r\n').length - 1 ;
            designation = designation.replaceAll('<br />', '\n');

            let height = combienBR * 15;
            if(height == 0 || height == 15){
                height = 30;
            }
            $(".listePrestations").append('<tr class="lignePrestation" data-catagorie="'+categorie+'" data-id="'+idPrestation+'" data-cle="'+cle+'"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="'+codePrestation+'" class="form-control modCode" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:1060px;"><textarea style="height:'+height+'px" class="form-control modDesignation" data-cle="'+cle+'">'+designationPrestation+'</textarea></td><td style="vertical-align: middle; width: 60px;"><input style="width:50px;" type="number" min="1" step="1" value="'+quantite+'" class="form-control modQte" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:41px;">€/'+unitePrestation+'</td><td style="vertical-align: middle; width:60px;"><input style="width:50px;" type="number" min="0" step="0.1" value="'+montantPrestation+'" class="form-control modMontant" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:70px;"><select class="tvaPrestation form-control" data-cle="'+cle+'"><option value="5.5">5.5%</option><option value="10">10%</option><option value="20">20%</option></select></td><td class="montanttotalprestation" data-cle="' + cle + '" style="text-align:right; vertical-align: middle; width:41px;">'+montanttotalprestation+'</td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="'+cle+'" class="deletePrestation">X</td></tr>');
            $(".tvaPrestation[data-cle='"+cle+"']").val(tvaPrestation);

            if($('.tvaPrestation[data-cle="'+cle+'"] option[value="' + tvaPrestation + '"]').length === 0) {
                $(".tvaPrestation[data-cle='"+cle+"']").val($(".tvaPrestation[data-cle='"+cle+"'] option:first").val());
            }
        }

        function addPrestationLigneToHTML(cle, idPrestation, codePrestation, designationPrestation){
            designationPrestation = designationPrestation.replaceAll('<br />', '\n');
            $(".listePrestations").append('<tr class="lignePrestation" data-id="'+idPrestation+'" data-cle="'+cle+'"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="'+codePrestation+'" class="form-control modCode" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:1060px;" colspan="6"><textarea class="form-control modDesignation" data-cle="'+cle+'">'+designationPrestation+'</textarea></td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="'+cle+'" class="deletePrestation">X</td></tr>');
        }

        function formateChiffreEuroSpan(valeur){
            if(valeur !== undefined && valeur !== "") {
                valeur = valeur.toString().replace(' ', '');
                return new Intl.NumberFormat('fr-FR', {
                    style: 'currency',
                    currency: 'EUR'
                }).format(valeur);
            }
        }

        function calculMontantTTC(listePrestations){
            $(".totalTVA").html(formateChiffreEuroSpan(0));
            var calcul = {};
            $.each(listePrestations, function(k, v){
                if(v.type == 'prestation') {
                    let tva = v.tva;
                    tva = tva.replace(',', '.');

                    if (calcul.hasOwnProperty(tva)) {
                        calcul[tva] = parseFloat(calcul[tva]) + (parseFloat(v.montant) * parseFloat(v.quantite));
                    } else {
                        calcul[tva] = parseFloat(v.montant) * parseFloat(v.quantite);
                    }
                }
            });

            var montantTaxe = 0;
            $.each(calcul, function(k, v){
                if(totalRemise == 0) {
                    var sousTotal = parseFloat(v) * (parseFloat(k) / 100);
                }else{
                    var pourcentageRemise = totalRemise / totalHT;
                    $("#totalRemisePourcent").val(pourcentageRemise * 100);
                    totalRemisePourcent = pourcentageRemise;
                    var sousTotal = (parseFloat(v) - (parseFloat(v) * parseFloat(pourcentageRemise))) * (parseFloat(k) / 100);
                    totalRemisePourcent = pourcentageRemise * 100;
                }

                montantTaxe += sousTotal;
                $('.totalTVA[data-tva="'+k+'"]').html(formateChiffreEuroSpan(sousTotal));
            });

            totalTVA = montantTaxe;
            totalTTC = totalTVA + totalNet;
            $(".totalTTC").html(formateChiffreEuroSpan(totalTTC));

            return totalTTC;
        }

        function gereHistorique(listeHistorique){
            $(".tableHistorique").html('');
            var historique = "";
            $.each(listeHistorique, function(kH, vH){
                historique = '<tr><td style="font-size:14px !important;">'+vH.date+' - '+vH.message+'</td></tr>' + historique;
            });
            $(".tableHistorique").html(historique);
        }

        $('#numtel').on("keyup", function() {
            this.value = formateTelephone(this.value);
        });

        $('#numtel').on("change", function() {
            this.value = formateTelephone(this.value);
        });

        $('#numportable').on("keyup", function() {
            this.value = formateTelephone(this.value);
        });

        $('#numportable').on("change", function() {
            this.value = formateTelephone(this.value);
        });

        function formateTelephone(value){
            value = value.replace(/ /g,'');
            value = value.replace(/\D/g,'');
            return value.replace(/\B(?=(\d{2})+(?!\d))/g, " ");
        }
    };

    // Public Functions
    return {
        // public functions
        init: function() {
            _page = $('.personne a');
            _subpage = $('.clients');
            _header = $('#kt_header_tab_2');

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
