"use strict";

// Class Definition
var KTMainDashboardModal = function() {

    var _gereModal = function() {
        var validationAddCommande;
        var validationAdd;
        var addMod;
        var addModClient;
        var id;
        var interfaceCourante = '';
        var etat;
        var idClient = 0;
        var listePrestations = [];
        var totalHT = 0;
        var totalRemise = 0;
        var totalRemisePourcent = 0;
        var totalNet = 0;
        var totalTTC = 0;
        var totalTVA = 0;
        var leSortable = false;
        var info;
        var adresseclient = "";
        var adresseclienttab = [];
        var nomclient = "";

        var idPrestation = 0;
        var codePrestation = "";
        var montantPrestation = 0;
        var tvaPrestation = 0;
        var designationPrestation = "";
        var designationCPrestation = "";
        var unitePrestation = "";
        var montanttotalprestation = 0;
        var idDivers = 50000;

        var nonmodifiable = $("#staticBackdropCommande").attr('data-modifiable');

        if (!nonmodifiable){
            $('#staticBackdropCommande .modal-body input').prop('disabled', true);
            $('#staticBackdropCommande .modal-body button').prop('disabled', true);
            $('#staticBackdropCommande .modal-body select').prop('disabled', true);
            $('#staticBackdropCommande .modal-body textarea').prop('disabled', true);
            $('#staticBackdropCommande #info').summernote('disable');
            $('#staticBackdropCommande .listePrestations ').attr("style", "pointer-events: none;");
            $('#staticBackdropCommande .etatCommande').attr("style", "pointer-events: none;");
            $("#staticBackdropCommande #saveModalCommande").text('Modifier').prop('disabled', true).hide();
            $("#staticBackdropCommande .modClient").hide();
            $("#staticBackdropCommande #cancelModal").text('Fermer');
            $("#staticBackdropCommande #annulerCommande").hide();
        }

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

        $('#typepaiementencaissement').select2({
            placeholder: 'Type de paiement',
        });

        $('#info').summernote({
            toolbar: [
                [ 'font', [ 'bold', 'italic', 'underline', 'clear'] ],
                [ 'fontsize', [ 'fontsize' ] ],
                [ 'color', [ 'color' ] ],
                [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ]
            ],
            popover: {
                image: [],
                link: [],
                air: []
            },
            tabsize: 2,
            tooltip: false,
            disableResizeEditor: true
        });

        $('#kt_select2_dateCommandes').select2({
            placeholder: 'Choisissez la date'
        });

        validationAddCommande = FormValidation.formValidation(
            document.getElementById('kt_form_1'),
            {
                fields: {
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        $('#select2_clients').select2({
            placeholder: 'Choisissez un client',
            templateResult: function (data) {
                if(data.text != 'Aucun' && data.text != 'Searching…' && data.text != 'Choisissez un client' && !nonmodifiable) {
                    var $option = $("<span></span>");
                    var $preview = $("<span data-id='" + data.id + "' class='modClient'> (Modifier)</span>");
                    $preview.on('mouseup', function (evt) {
                        evt.stopPropagation();
                    });

                    $preview.on('click', function (evt) {
                        addModClient = false;

                        $('#deleteClient').show();
                        $("#staticBackdropClient #modalTitleClient").html('Modification d\'un client');
                        $("#modalTitleClient").attr('data-modifier', 'true');
                        $("#staticBackdropClient #saveModalClient").text('Enregistrer et fermer');
                        $('#kt_datatable_commande').show();
                        $('.codeclientapi').show();
                        $('.addclientevoliz').show();
                        idClient = $(this).attr('data-id');
                        $("#staticBackdropClient").attr('data-id', idClient);

                        $('#kt_form_client').trigger("reset");

                        getClient(idClient);
                        $("#staticBackdropClient").modal({keyboard: false});
                        $('#select2_clients').select2('close');
                    });

                    $option.text(data.text);
                    $option.append($preview);

                    return $option;
                }else{
                    var $option = $("<span></span>");
                    $option.text(data.text);

                    return $option;
                }
            },
            templateSelection: function (data) {
                if(data.text != 'Aucun' && data.text != 'Searching…' && data.text != 'Choisissez un client' && !nonmodifiable) {
                    var $option = $("<span></span>");
                    var $preview = $("<span style='cursor:pointer;' data-id='" + data.id + "' class='modClient'> (Modifier)</span>");
                    $preview.on('mouseup', function (evt) {
                        evt.stopPropagation();
                    });

                    $preview.on('click', function (evt) {
                        addModClient = false;

                        $('#deleteClient').show();
                        $("#staticBackdropClient #modalTitleClient").html('Modification d\'un client');
                        $("#modalTitleClient").attr('data-modifier', 'true');
                        $("#staticBackdropClient #saveModalClient").text('Enregistrer et fermer');
                        $('#kt_datatable_commande').show();
                        $('.codeclientapi').show();
                        $('.addclientevoliz').show();
                        idClient = $(this).attr('data-id');
                        $("#staticBackdropClient").attr('data-id', idClient);

                        $('#kt_form_client').trigger("reset");

                        getClient(idClient);

                        $("#staticBackdropClient").modal({keyboard: false});
                        $('#select2_clients').select2('close');
                    });

                    $option.text(data.text);
                    $option.append($preview);

                    return $option;
                }else{
                    var $option = $("<span></span>");
                    $option.text(data.text);

                    return $option;
                }
            }
        });

        $('#select2_clients').on('change', function(e) {
            e.preventDefault();

            idClient = $(this).val();
            if (idClient != null && idClient != '0' && idClient != '' && idClient != undefined) {
                $.ajax({
                    type: "POST",
                    url: "./assets/ajax/clients/getClient.php",
                    data: {
                        "id": idClient
                    },
                    dataType: 'json',
                    success: function (data) {
                        nomclient = data.prenom + ' ' + data.nom;
                        adresseclient = data.adresse + ' ' + data.codepostal + ' ' + data.ville;
                        adresseclienttab = data.adresseClient;
                        if ($("#adresseTravaux").prop('checked')) {
                            $("#ruetravaux").val(adresseclienttab.adresse);
                            $("#cptravaux").val(adresseclienttab.codepostal);
                            $("#villetravaux").val(adresseclienttab.ville);
                        } else {
                            $("#ruetravaux").val('');
                            $("#cptravaux").val('');
                            $("#villetravaux").val('');
                        }
                    }
                });
            }
        });

        $('#select2_prestations').select2({
            placeholder: 'Choisissez une prestation'
        });

        $('#select2_prestations').on('select2:select', function (e) {
            var data = e.params.data;
            var prestation = data.id;

            $.ajax({
                type: "POST",
                url: "./assets/ajax/general/getPrestationById.php",
                data: {
                    "id": prestation
                },
                dataType: 'json',
                success: function (data) {
                    idPrestation = prestation;
                    codePrestation = data.code;
                    montantPrestation = data.montant;
                    tvaPrestation = data.tva;
                    designationPrestation = data.designationSimple;
                    designationCPrestation = data.designationComplementaire;
                    if(data.designationComplementaire === null){
                        designationCPrestation = "";
                    }
                    unitePrestation = data.unite;
                }
            });
        });

        $("#addCommandes").click(function(){
            addMod = true;

            $('#staticBackdropCommande .modal-body input').prop('disabled', false);
            $('#staticBackdropCommande .modal-body button').prop('disabled', false);
            $('#staticBackdropCommande .modal-body select').prop('disabled', false);
            $('#staticBackdropCommande .modal-body textarea').prop('disabled', false);
            $('#staticBackdropCommande #info').summernote('');
            $('#staticBackdropCommande .listePrestations ').attr("style", "");
            $('#staticBackdropCommande .etatCommande').attr("style", "");
            $("#staticBackdropCommande #saveModalCommande").text('Modifier').prop('disabled', false).show();
            $("#staticBackdropCommande #cancelModal").text('Annuler');
            $("#staticBackdropCommande #annulerCommande").show();

            $(".listePrestations").html('');
            listePrestations = [];
            totalHT = 0;
            totalRemise = 0;
            totalRemisePourcent = 0;
            totalNet = 0;
            totalTTC = 0;

            $("#info").summernote("code", "");
            $("#select2_prestations").val('0').trigger('change');
            $("#select2_clients").val('0').trigger('change');
            $(".totalTVA").html('0&nbsp;€');
            $(".totalHT").html('0&nbsp;€');
            $(".totalTTC").html('0&nbsp;€');
            $(".totalNet").html('0&nbsp;€');
            $("#totalRemise").val('');
            $("#totalRemisePourcent").val('');
            $(".tableHistorique").html('');

            $('#kt_form_1').trigger("reset");
            $("#adresseTravaux").prop('checked', true);
            $(".lesChampsTravaux").prop('disabled', true);
            $('#changerEtatCommandeConfirmer').hide();
            $('#changerEtatCommandeAnnuler').hide();
            $('.etatCommande').hide();
            $(".paiementcredit").hide();
            $("#annulerCommande").hide();
            $("#modalTitleCommande").html('Ajout d\'un devis');
            $("#saveModalCommande").text('Ajouter');
            $(".ongletmenu .nav-item").show();
            $(".ongletmenu .nav-link").removeClass('active');
            $(".onglets .tab-pane").removeClass('active');
            $(".ongletmenu .nav-item:nth-child(3)").hide();
            $(".ongletmenu .nav-item:nth-child(4)").hide();
            $(".ongletmenu .nav-item:nth-child(5)").hide();
            $(".ongletmenu .nav-item:nth-child(6)").hide();
            $("#informations-tab").addClass('active');
            $("#informations").addClass('active').addClass('show');
            $('.paiementplusieursfois').hide();
        });

        $(".modCommande").click(function(){
            addMod = false;
            interfaceCourante = $(this).attr('data-interface');

            if (interfaceCourante == undefined || interfaceCourante == null){
                interfaceCourante = '';
            }

            $("#select2_clients").val('0').trigger('change');
            $('.etatCommande').show();
            $("#modalTitleCommande").html('Modification d\'un devis');

            $("#saveModalCommande").text('Modifier');
            if (!nonmodifiable){
                $("#annulerCommande").show();
            }

            id = $(this).attr('data-id');
            $(".ongletmenu .nav-item").show();
            $(".ongletmenu .nav-link").removeClass('active');
            $(".onglets .tab-pane").removeClass('active');
            $("#informations-tab").addClass('active');
            $("#informations").addClass('active').addClass('show');
            $('.paiementplusieursfois').show();
            getCommande(id);
        });

        $("body").on('click', '.infoscommande', function(){
            addMod = false;
            $("#select2_clients").val('0').trigger('change');
            $('.etatCommande').show();
            $("#modalTitleCommande").html('Aperçu d\'une commande');
            $("#staticBackdropCommande .modClient").hide();
            $("#saveModalCommande").hide();
            id = $(this).closest('tr.ligneplanification').attr('data-idcommande');
            getCommande(id);
        });

        $("#facturation-tab").click(function(){
            $.ajax({
                type: "POST",
                url: "./assets/ajax/clients/getClient.php",
                data: {
                    "id": $("#select2_clients").val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.nom == null){
                        data.nom = "";
                    }
                    if (data.prenom == null){
                        data.prenom = "";
                    }
                    if (data.adresse == null){
                        data.adresse = "";
                    }
                    if (data.codepostal == null){
                        data.codepostal = "";
                    }
                    if (data.ville == null){
                        data.ville = "";
                    }

                    nomclient = data.prenom + ' ' + data.nom;
                    adresseclient = data.adresse + ' ' + data.codepostal + ' ' + data.ville;

                    $('#clientfact').val(nomclient.trim());
                    $('#adresseclientfact').val(adresseclient.trim());
                }
            });

            $('#staticBackdropCommande .modal-body input').prop('disabled', false);
            $('#staticBackdropCommande .modal-body button').prop('disabled', false);
            $('#staticBackdropCommande .modal-body select').prop('disabled', false);
            $('#staticBackdropCommande .modal-body textarea').prop('disabled', false);

            var form = $("#kt_form_1");
            var formData = (window.FormData) ? new FormData(form[0]) : null;
            var data = (formData !== null) ? formData : form.serialize();

            formData.append('listePrestation', JSON.stringify(listePrestations));
            formData.append('totalHT', totalHT);
            formData.append('totalNet', totalNet);
            formData.append('totalRemise', totalRemise);
            formData.append('totalRemisePourcent', totalRemisePourcent);
            formData.append('totalTVA', totalTVA);
            formData.append('totalTTC', totalTTC);

            if(addMod) {
                validationAddCommande.validate().then(function (status) {
                    if (status == 'Valid') {
                        if ($('#numero').val() == "" || $('#travauxaexecuter').val() == ""){
                            $("#erreursToastBody").text("Veuillez renseigner le numéro de commande et les travaux à exécuter de la commande.");
                            $("#liveToastErreurs").toast("show");
                        } else{
                            $.ajax({
                                type: "POST",
                                url: "./assets/ajax/commandes/addCommande.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (html) {
                                }
                            });
                        }
                    }
                });
            }else{
                formData.append('id', id);
                validationAddCommande.validate().then(function (status) {
                    if (status == 'Valid') {
                        if ($('#numero').val() == "" || $('#travauxaexecuter').val() == ""){
                            $("#erreursToastBody").text("Veuillez renseigner le numéro de commande et les travaux à exécuter de la commande.");
                            $("#liveToastErreurs").toast("show");
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "./assets/ajax/commandes/modCommande.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (html) {
                                    if(!onpeutFaireLaModification) {
                                        $('#staticBackdropCommande .modal-body input').prop('disabled', true);
                                        $('#staticBackdropCommande .modal-body button').prop('disabled', true);
                                        $('#staticBackdropCommande .modal-body select').prop('disabled', true);
                                        $('#staticBackdropCommande .modal-body textarea').prop('disabled', true);
                                    }

                                    $(".encaissementFacture input, .encaissementFacture button, .encaissementFacture select, .encaissementFacture textarea").prop('disabled', false);
                                    $("#dateFacturation").prop('disabled', false);
                                    $(".addFacture").prop('disabled', false);
                                }
                            });
                        }
                    }
                });
            }
        });

        var travauxaexecuter = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '/assets/json/travauxaexecuterfixe.php'
        });

        $('#travauxaexecuter').typeahead({
                hint: true,
                highlight: true, /* Enable substring highlighting */
                minLength: 1 /* Specify minimum characters required for showing suggestions */
            },
            {
                name: 'travauxaexecuter',
                source: travauxaexecuter
            });

        $('#saveModalCommande').on('click', function (e) {
            e.preventDefault();
            $(this).hide();

            var form = $("#kt_form_1");
            var formData = (window.FormData) ? new FormData(form[0]) : null;
            var data = (formData !== null) ? formData : form.serialize();

            formData.append('listePrestation', JSON.stringify(listePrestations));
            formData.append('totalHT', totalHT);
            formData.append('totalNet', totalNet);
            formData.append('totalRemise', totalRemise);
            formData.append('totalRemisePourcent', totalRemisePourcent);
            formData.append('totalTVA', totalTVA);
            formData.append('totalTTC', totalTTC);

            if(addMod) {
                validationAddCommande.validate().then(function (status) {
                    if (status == 'Valid') {
                        if ($('#numero').val() == "" || $('#travauxaexecuter').val() == ""){
                            $("#erreursToastBody").text("Veuillez renseigner le numéro de commande et les travaux à exécuter de la commande.");
                            $("#liveToastErreurs").toast("show");
                            $('#saveModalCommande').show();
                        } else{
                            $.ajax({
                                type: "POST",
                                url: "./assets/ajax/commandes/addCommande.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (html) {
                                    if (html == true) {
                                        location.reload();
                                    } else {
                                        $(".erreurLogin").show();
                                    }
                                }
                            });
                        }
                    }else{
                        $('#saveModalCommande').show();
                    }
                });
            }else{
                formData.append('id', id);
                validationAddCommande.validate().then(function (status) {
                    if (status == 'Valid') {
                        if ($('#numero').val() == "" || $('#travauxaexecuter').val() == ""){
                            $("#erreursToastBody").text("Veuillez renseigner le numéro de commande et les travaux à exécuter de la commande.");
                            $("#liveToastErreurs").toast("show");
                            $('#saveModalCommande').show();
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "./assets/ajax/commandes/modCommande.php",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (html) {
                                    if (html == true) {
                                        location.reload();
                                    } else {
                                        $('#saveModalCommande').show();
                                        $(".erreurLogin").show();
                                    }
                                    $('#changerEtatCommandeConfirmer').hide();
                                    $('#changerEtatCommandeAnnuler').hide();
                                }
                            });
                        }
                    }else{
                        $('#saveModalCommande').show();
                    }
                });
            }
        });

        $("#adresseTravaux").change(function(){
            if($(this).prop('checked')){
                $("#ruetravaux").val(adresseclienttab.adresse);
                $("#cptravaux").val(adresseclienttab.codepostal);
                $("#villetravaux").val(adresseclienttab.ville);
                $(".lesChampsTravaux").prop('disabled', true);
            } else {
                $("#ruetravaux").val('');
                $("#cptravaux").val('');
                $("#villetravaux").val('');
            }
        });

        $("#totalRemise").keyup(function(){
            if($(this).val() == ""){
                totalRemise = 0;
                $("#totalRemisePourcent").val(0);
            }else{
                totalRemise = formatePrice($(this).val());
                $("#totalRemise").val(totalRemise);
            }

            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
        });

        $("#totalRemisePourcent").keyup(function(){
            if($(this).val() == ""){
                totalRemisePourcent = 0;
                $("#totalRemise").val(0);
            }else{
                totalRemisePourcent = formatePrice($(this).val());
                $("#totalRemisePourcent").val(totalRemisePourcent);
            }

            totalNet = calculMontantNetPourcent(totalHT, totalRemisePourcent);
            totalTTC = calculMontantTTC(listePrestations, totalRemisePourcent);
        });

        $("#modepaiement").change(function(){
            if($(this).val() == 'Crédit') {
                $(".paiementcredit").show();
            }else{
                $(".paiementcredit").hide();
            }
        });

        $(".listePrestations").on('keyup', '.modQte', function(){
            var laCle = $(this).attr('data-cle');
            var qte = $(this).val();
            modQte(listePrestations, laCle, qte);
            montanttotalprestation = modMontantTotalPrestation(listePrestations, laCle);
            totalHT = calculMontantTotalHT(listePrestations);
            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
        });

        $(".listePrestations").on('keyup', '.modDesignation', function(){
            var laCle = $(this).attr('data-cle');
            var designation = $(this).val();
            modDesignation(listePrestations, laCle, designation);
        });

        $(".listePrestations").on('keyup', '.modCode', function(){
            var laCle = $(this).attr('data-cle');
            var code = $(this).val();
            modCode(listePrestations, laCle, code);
        });

        $(".listePrestations").on('keyup', '.modMontant', function(){
            var laCle = $(this).attr('data-cle');
            var montant = $(this).val();
            modMontant(listePrestations, laCle, montant);
            montanttotalprestation = modMontantTotalPrestation(listePrestations, laCle);
            totalHT = calculMontantTotalHT(listePrestations);
            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
        });

        $(".addPrestation").click(function(){
            var qte = 1;
            addPrestationToList(listePrestations, 'prestation', qte, false);
            totalHT = calculMontantTotalHT(listePrestations);
            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
            videPrestationMemoire();
        });

        $(".addPrestationVide").click(function(){
            idDivers++;
            idPrestation = idDivers;
            codePrestation = "DIVERS";
            montantPrestation = "";
            tvaPrestation = "";
            designationPrestation = "";
            designationCPrestation = "";
            unitePrestation = "";
            addPrestationToList(listePrestations, 'ligne', 1, false);
            videPrestationMemoire();
        });

        $(".listePrestations").on('click', '.deletePrestation', function(){
            var cleQuonSupprime = $(this).attr('data-cle');
            removePrestationToList(listePrestations, cleQuonSupprime);
            totalHT = calculMontantTotalHT(listePrestations);
            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
        });

        $(".listePrestations").on('change', '.unitePrestation', function(){
            var cleQuonModifie = $(this).attr('data-cle');
            changeUnitePrestation(listePrestations, cleQuonModifie, $(this).val());
        });

        $(".listePrestations").on('change', '.tvaPrestation', function(){
            var cleQuonModifie = $(this).attr('data-cle');
            changeTVAPrestation(listePrestations, cleQuonModifie, $(this).val());
            totalHT = calculMontantTotalHT(listePrestations);
            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
        });

        $("#staticBackdropCommande").on('click', '.boutonEtat', function (e) {
            e.preventDefault();
            etat = $(this).attr('data-etat');
            $('#changerEtatCommandeConfirmer').show();
            $('#changerEtatCommandeAnnuler').show();
        });

        $("#changerEtatCommandeConfirmer").on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/commandes/modEtatCommande.php",
                data: {
                    id: id,
                    etat: etat
                },
                success: function () {
                    $("#boutonTerminee").removeAttr( "class" );
                    $("#boutonPayee").removeAttr( "class" );
                    switch (etat){
                        case "Facturée":
                            $("#boutonTerminee").addClass( "boutonEtat bg-warning font-weight-bold" );
                            $("#boutonPayee").addClass( "boutonEtat bg-secondary opacity-50" );
                            break;
                        case "Payée" :
                            $("#boutonTerminee").addClass( "boutonEtat bg-warning font-weight-bold" );
                            $("#boutonPayee").addClass( "boutonEtat bg-danger font-weight-bold" );
                            break;
                        case "En cours":
                            $("#boutonTerminee").addClass( "boutonEtat bg-secondary opacity-50" );
                            $("#boutonPayee").addClass( "boutonEtat bg-secondary opacity-50" );
                            break;
                    }
                    $('#changerEtatCommandeConfirmer').hide();
                    $('#changerEtatCommandeAnnuler').hide();
                }
            });
        });

        $('#changerEtatCommandeAnnuler').on('click', function (e) {
            e.preventDefault();
            $('#changerEtatCommandeConfirmer').hide();
            $('#changerEtatCommandeAnnuler').hide();
        });

        $(".encaisseFacture").click(function(e){
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/commandes/modEtatCommande.php",
                data: {
                    id: id,
                    etat: 'Payée'
                },
                success: function (html) {
                    $("#encaisseFacturation").html('Encaissée le '+html)

                    $('#staticBackdropCommande .modal-body input').prop('disabled', true);
                    $('#staticBackdropCommande .modal-body button').prop('disabled', true);
                    $('#staticBackdropCommande .modal-body select').prop('disabled', true);
                    $('#staticBackdropCommande .modal-body textarea').prop('disabled', true);
                    $('#staticBackdropCommande #info').summernote('disable');
                    $('#staticBackdropCommande .listePrestations ').attr("style", "pointer-events: none;");
                    $('#staticBackdropCommande .etatCommande').attr("style", "pointer-events: none;");
                    $("#staticBackdropCommande #saveModalCommande").text('Modifier').prop('disabled', true).hide();
                    $("#staticBackdropCommande #cancelModal").text('Fermer');
                    $("#staticBackdropCommande #annulerCommande").hide();
                    $("#staticBackdropCommande .modClient").hide();
                }
            });
        })

        function videPrestationMemoire(){
            idPrestation = "";
            codePrestation = "";
            montantPrestation = "";
            tvaPrestation = "";
            designationPrestation = "";
            designationCPrestation = "";
            unitePrestation = "";
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

        function modMontant(listePrestations, cle, montant){
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    if(montant == ""){
                        montant = 0;
                    }

                    listePrestations[k].montant = parseFloat(montant);
                }
            });
        }

        function modQte(listePrestations, cle, qte){
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    if(qte == ""){
                        qte = 0;
                    }

                    listePrestations[k].quantite = qte;
                }
            });
        }

        function modMontantTotalPrestation(listePrestations, cle){
            let qte;
            let montant;
            let montanttotal;
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    qte = parseFloat(listePrestations[k].quantite);
                    montant = parseFloat(listePrestations[k].montant);
                    if (qte == '' || qte == null || qte == 0){
                        montanttotal = 0;
                    }else{
                        montanttotal = qte * montant;
                    }
                    listePrestations[k].montanttotalprestation = montanttotal;

                    $('.montanttotalprestation[data-cle="'+k+'"]').html(formateChiffreEuroSpan(listePrestations[k].montanttotalprestation));
                }
            });
            return montanttotal;
        }

        function modDesignation(listePrestations, cle, designation){
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    listePrestations[k].designation = designation;
                }
            });
        }

        function modCode(listePrestations, cle, code){
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    listePrestations[k].code = code;
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

        $('.listePrestations').sortable();
        $('.listePrestations').on("sortstop", function (event, ui) {
            leSortable = true;
            var categorieTemp = "";
            var listeTemp = [];

            $.each(listePrestations, function (k, v) {
                listeTemp[v.id] = v;
            });

            listePrestations = [];
            var elementsTries = $(this).sortable("toArray", {attribute: 'data-id'});

            for (var i = 0; i < elementsTries.length; i++) {
                if(elementsTries[i] != ""){
                    listePrestations.push(listeTemp[elementsTries[i]]);
                }
            }

            $(".listePrestations").html('');
            var html = '';
            var isSelect5;
            var isSelect10;
            var isSelect20;
            var isSelectu;
            var isSelectml;
            var isSelectm2;
            $.each(listePrestations, function (cle, v) {
                isSelect5 = "";
                isSelect10 = "";
                isSelect20 = "";
                if (v.tva == 10) {
                    isSelect10 = 'selected';
                }

                if(v.tva == 20){
                    isSelect20 = 'selected';
                }

                if(v.tva == 5.5){
                    isSelect5 = 'selected';
                }

                isSelectu = "";
                isSelectml = "";
                isSelectm2 = "";
                if (v.unite == 'u') {
                    isSelectu = 'selected';
                }

                if(v.unite == "ml"){
                    isSelectml = 'selected';
                }

                if(v.unite == "m2"){
                    isSelectm2 = 'selected';
                }

                let designation = v.designation;
                designation = designation.replaceAll('\r\n', '\n');
                designation = designation.replaceAll('\r', '\n');
                designation = designation.replaceAll('<br>', '\n');
                designation = designation.replaceAll('<br/>', '\n');
                designation = designation.replaceAll('<br />', '\n');
                let count = designation.split('\n').length;

                let height = (count * 15) + 10;
                if(height < 30) {
                    height = 30;
                }

                if(v.type == 'prestation') {
                    html += '<tr class="lignePrestation" data-id="' + v.id + '" data-cle="' + cle + '"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="' + v.code + '" class="form-control modCode" data-cle="' + cle + '"></td><td style="vertical-align: middle; width:1000px;"><textarea rows="'+count+'" style="" class="form-control modDesignation" data-cle="' + cle + '">' + designation + '</textarea></td><td style="width:60px; vertical-align: middle;"><input style="width:50px;" type="number" min="1" step="1" value="' + v.quantite + '" class="form-control modQte" data-cle="' + cle + '"></td><td style="vertical-align: middle; width:60px;"><input style="width:50px;" type="number" min="0" step="0.1" value="' + v.montant + '" class="form-control modMontant" data-cle="' + cle + '"></td><td style="vertical-align: middle; width:41px;">€/</td><td style="vertical-align: middle; width:60px;"><select class="unitePrestation form-control" data-cle="'+cle+'"><option ' + isSelectu + ' value="u">u</option><option ' + isSelectml + ' value="ml">ml</option><option ' + isSelectm2 + ' value="m2">m2</option></select></td><td style="vertical-align: middle; width:70px;"><select class="tvaPrestation form-control" data-cle="' + cle + '"><option ' + isSelect5 + ' value="5.5">5.5%</option><option ' + isSelect10 + ' value="10">10%</option><option ' + isSelect20 + ' value="20">20%</option></select></td><td class="montanttotalprestation" data-cle="' + cle + '" style="text-align:right; vertical-align: middle; width:41px;">' + formateChiffreEuroSpan(v.montanttotalprestation) + '</td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="' + cle + '" class="deletePrestation">X</td></tr>';
                }else{
                    html += '<tr class="lignePrestation" data-id="' + v.id + '" data-cle="' + cle + '"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="' + v.code + '" class="form-control modCode" data-cle="' + cle + '"></td><td style="vertical-align: middle; width:1000px;" colspan="7"><textarea rows="'+count+'" style="" class="form-control modDesignation" data-cle="' + cle + '">' + designation + '</textarea></td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="' + cle + '" class="deletePrestation">X</td></tr>';
                }
            });

            $(".listePrestations").html(html);
        });

        var myDropzone = $('#kt_dropzone_3').dropzone({
            url: "/ajax/addDocument.php", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 10, // MB
            addRemoveLinks: false,
            dictInvalidFileType: "Extension non autorisée.",
            acceptedFiles: "image/*",
            init: function() {

            },
            accept: function(file, done) {

            }
        });

        function calculMontantTTC(listePrestations, pourcentageRemise = ""){
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
                    if (pourcentageRemise == "") {
                        pourcentageRemise = totalRemise / totalHT;
                        pourcentageRemise = Math.round((pourcentageRemise * 100) * 100) / 100;
                    }

                    $("#totalRemisePourcent").val(pourcentageRemise);
                    totalRemisePourcent = pourcentageRemise;

                    var sousTotal = ((parseFloat(v) - (parseFloat(v) * parseFloat(pourcentageRemise) / 100)) * (parseFloat(k) / 100));

                    if(sousTotal.toString().split(".").length > 1) {
                        let nbdecimali = sousTotal.toString().split(".")[1].length;

                        if (nbdecimali > 2) {
                            sousTotal = sousTotal.toFixed(5) * 100;
                            sousTotal = Math.ceil(sousTotal);
                            sousTotal = sousTotal / 100;
                        }
                    }
                }

                montantTaxe += sousTotal;
                $('.totalTVA[data-tva="'+k+'"]').html(formateChiffreEuroSpan(sousTotal));
            });

            totalTVA = montantTaxe;
            totalTTC = totalTVA + totalNet;
            $(".totalTTC").html(formateChiffreEuroSpan(totalTTC));

            return totalTTC;
        }

        function calculMontantNet(totalHT, remise){
            var leTotal = totalHT - remise;
            $(".totalNet").html(formateChiffreEuroSpan(leTotal));

            return leTotal;
        }

        function calculMontantNetPourcent(totalHT, remise){
            var leMontantDeLaRemise = (totalHT * remise) / 100;
            leMontantDeLaRemise = Math.round(leMontantDeLaRemise * 100) / 100;
            $("#totalRemise").val(leMontantDeLaRemise);
            totalRemise = leMontantDeLaRemise;
            var leTotal = totalHT - leMontantDeLaRemise;
            $(".totalNet").html(formateChiffreEuroSpan(leTotal));

            return leTotal;
        }

        function calculMontantTotalHT(listePrestations){
            var leTotal = 0;
            $.each(listePrestations, function(k, v){
                if(v.type == 'prestation') {
                    leTotal += parseFloat(v.quantite) * parseFloat(v.montant);
                }
            });

            $(".totalHT").html(formateChiffreEuroSpan(leTotal));

            return leTotal;
        }

        function changeUnitePrestation(listePrestations, cle, unite){
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    listePrestations[k].unite = unite;
                }
            });
        }

        function changeTVAPrestation(listePrestations, cle, tva){
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    listePrestations[k].tva = tva;
                }
            });
        }

        function removePrestationToList(listePrestations, cle){
            var trouve = 0;
            $.each(listePrestations, function(k, v){
                if(k == cle){
                    trouve = k;
                }
            });

            listePrestations.splice(trouve, 1);
            initialiseListePrestation(listePrestations);
        }

        function addPrestationToHTML(cle, idPrestation, codePrestation, montantPrestation, designationPrestation, quantite, tvaPrestation, unitePrestation, montanttotalprestation, categorie){
            designationPrestation = designationPrestation.replaceAll('<br />', '\n');
            let designation = designationPrestation;
            designation = designation.replaceAll('\r\n', '\n');
            designation = designation.replaceAll('\r', '\n');
            designation = designation.replaceAll('<br>', '\n');
            designation = designation.replaceAll('<br/>', '\n');
            designation = designation.replaceAll('<br />', '\n');
            let count = designation.split('\n').length;

            $(".listePrestations").append('<tr class="lignePrestation" data-catagorie="'+categorie+'" data-id="'+idPrestation+'" data-cle="'+cle+'"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="'+codePrestation+'" class="form-control modCode" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:1000px;"><textarea rows="'+count+'" style="" class="form-control modDesignation" data-cle="'+cle+'">'+designationPrestation+'</textarea></td><td style="vertical-align: middle; width: 60px;"><input style="width:50px;" type="number" min="1" step="1" value="'+quantite+'" class="form-control modQte" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:60px;"><input style="width:50px;" type="number" min="0" step="0.1" value="'+montantPrestation+'" class="form-control modMontant" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:41px;">€/</td><td style="vertical-align: middle; width:60px;"><select class="unitePrestation form-control" data-cle="'+cle+'"><option value="u">u</option><option value="ml">ml</option><option value="m2">m2</option></select></td><td style="vertical-align: middle; width:70px;"><select class="tvaPrestation form-control" data-cle="'+cle+'"><option value="5.5">5.5%</option><option value="10">10%</option><option value="20">20%</option></select></td><td class="montanttotalprestation" data-cle="' + cle + '" style="text-align:right; vertical-align: middle; width:41px;">'+montanttotalprestation+'</td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="'+cle+'" class="deletePrestation">X</td></tr>');
            $(".tvaPrestation[data-cle='"+cle+"']").val(tvaPrestation);
            $(".unitePrestation[data-cle='"+cle+"']").val(unitePrestation);

            if($('.tvaPrestation[data-cle="'+cle+'"] option[value="' + tvaPrestation + '"]').length === 0) {
                $(".tvaPrestation[data-cle='"+cle+"']").val($(".tvaPrestation[data-cle='"+cle+"'] option:first").val());
            }

            if($('.unitePrestation[data-cle="'+cle+'"] option[value="' + unitePrestation + '"]').length === 0) {
                $(".unitePrestation[data-cle='"+cle+"']").val($(".unitePrestation[data-cle='"+cle+"'] option:first").val());
            }
        }

        function addPrestationLigneToHTML(cle, idPrestation, codePrestation, designationPrestation){
            designationPrestation = designationPrestation.replaceAll('\r\n', '\n');
            designationPrestation = designationPrestation.replaceAll('\r', '\n');
            designationPrestation = designationPrestation.replaceAll('<br>', '\n');
            designationPrestation = designationPrestation.replaceAll('<br/>', '\n');
            designationPrestation = designationPrestation.replaceAll('<br />', '\n');
            let count = designationPrestation.split('\n').length;

            $(".listePrestations").append('<tr class="lignePrestation" data-id="'+idPrestation+'" data-cle="'+cle+'"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="'+codePrestation+'" class="form-control modCode" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:1000px;" colspan="7"><textarea rows="'+count+'" class="form-control modDesignation" data-cle="'+cle+'">'+designationPrestation+'</textarea></td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="'+cle+'" class="deletePrestation">X</td></tr>');
        }

        function addPrestationToList(listePrestations, type, quantite, open){
            if(codePrestation != "" && quantite != "") {
                if(type == 'prestation') {
                    if(tvaPrestation == 0){
                        var tva = "5.5";
                    }else{
                        var tvaSPLIT = tvaPrestation.split('|');
                        var tva = tvaSPLIT[0];
                    }

                    if (quantite == '' || quantite == null || quantite == 0 || type == 'ligne') {
                        montanttotalprestation = 0;
                    } else {
                        montanttotalprestation = parseFloat(quantite) * parseFloat(montantPrestation);
                    }

                    let laDesignation = designationPrestation + '<br />'+designationCPrestation;
                    if(designationCPrestation == ""){
                        laDesignation = designationPrestation;
                    }

                    var Array = {
                        id: idPrestation,
                        code: codePrestation,
                        montant: montantPrestation,
                        montanttotalprestation: montanttotalprestation,
                        designation: laDesignation,
                        quantite: quantite,
                        tva: tva,
                        unite: unitePrestation,
                        type: type
                    };
                }else{
                    let laDesignation = designationPrestation + '<br />'+designationCPrestation;
                    if(designationCPrestation == ""){
                        laDesignation = designationPrestation;
                    }

                    var Array = {
                        id: idPrestation,
                        code: codePrestation,
                        montant: "",
                        montanttotalprestation: "",
                        designation: laDesignation,
                        quantite: 0,
                        tva: "",
                        unite: "",
                        type: type
                    };
                }

                listePrestations.push(Array);
                initialiseListePrestation(listePrestations);
                $("#select2_prestations").val('0').trigger('change');
                if(open){
                    $("#select2_prestations").select2('open');
                }
            }
        }

        // CLIENTS
        $('input[type=file]').css('color', 'transparent');

        $(".addClient").click(function(e){
            e.preventDefault();

            addModClient = true;
            $('#deleteClient').hide();
            $('#kt_form_client').trigger("reset");
            $("#select2_clients").val('0').trigger('change');
            $("#modalTitleClient").html('Ajout d\'un client');
            $("#modalTitleClient").attr('data-modifier', 'false');
            $("#saveModalClient").text('Ajouter').show();
            $('#kt_datatable_commande').hide();
            $('.codeclientapi').hide();
            $('.addclientevoliz').hide();

            $('#staticBackdropClient').modal('show');
        });

        function getClient(idClient){
            $.ajax({
                type: "POST",
                url: "./assets/ajax/clients/getClient.php",
                data: {
                    "id": idClient
                },
                dataType: 'json',
                success: function (data) {
                    var type;
                    var civilite;
                    var commandes;
                    $('.select2-selection').css('height', '30px');
                    $.each(data, function (k, v) {
                        $("#" + k).val(v);

                        if (k == 'codenumtel') {
                            if ($('#' + k).find("option[value='" + v + "']").length) {
                                $('#' + k).val(v).trigger('change');
                            } else {
                                if ($('#' + k).find("option[value='" + '+33' + "']").length) {
                                    $('#' + k).val('+33').trigger('change');
                                }
                            }
                        }
                        if (k == 'codenumportable') {
                            if ($('#' + k).find("option[value='" + v + "']").length) {
                                $('#' + k).val(v).trigger('change');
                            } else {
                                if ($('#' + k).find("option[value='" + '+33' + "']").length) {
                                    $('#' + k).val('+33').trigger('change');
                                }
                            }
                        }

                        if (k == 'numtel' || k == 'numportable') {
                            $("#" + k).val(formateTelephone(v));
                        }

                        if (k == 'type' && v != 0) {
                            type = v;
                        }

                        if (k == 'civilite' && v != 0) {
                            civilite = v;
                        }

                        if (k == 'commandeshtml') {
                            commandes = v;
                        }

                        if (k == 'idclientapi') {
                            $('#codeclientapi').attr('data-idclientapi', v);
                        }

                        if (k == 'idcontactclientapi') {
                            $('#codeclientapi').attr('data-idcontactclientapi', v);
                        }
                    });

                    if (type !== "") {
                        $("#type").val(type).trigger('change');
                    }

                    if (civilite !== "0") {
                        $("#civilite").val(civilite).trigger('change');
                    } else {
                        $("#civilite").val("Aucun").trigger('change');
                    }

                    if (commandes != undefined && commandes != null && commandes != "") {
                        $('#commandes').html(commandes);
                        $('#deleteClient').prop('disabled', true);
                    } else {
                        commandes = '<tr><td class="text-center" colSpan="4">Aucune commande passée.</td></tr>';
                        $('#commandes').html(commandes);
                        $('#deleteClient').prop('disabled', false);
                    }
                }
            });
        }

        $('#saveModalClient').on('click', function (e) {
            e.preventDefault();
            $(this).hide();

            var form = $("#kt_form_client");
            var formData = (window.FormData) ? new FormData(form[0]) : null;
            var data = (formData !== null) ? formData : form.serialize();

            if(addModClient) {
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/clients/addClient.php",
                            data: {
                                "data": $("#kt_form_client").serialize()
                            },
                            dataType: 'json',
                            success: function (html) {
                                var newOption = new Option(html.nom+' '+html.prenom, html.id);
                                $('#select2_clients').append(newOption).trigger('change');
                                $('#select2_clients').val(html.id);

                                $("#staticBackdropClient").modal('hide');
                                $('#saveModalClient').show();
                                validationAdd.resetForm();
                            }
                        });
                    }else{
                        $('#saveModalClient').show();
                    }
                });
            }else{
                formData.append('id', idClient);
                validationAdd.validate().then(function (status) {
                    if (status == 'Valid') {
                        let idClientapi = $("#codeclientapi").attr('data-idclientapi');
                        let idContactClientapi = $("#codeclientapi").attr('data-idcontactclientapi');
                        let codeClientapi = $("#codeclientapi").val();

                        if (idClientapi == null || idClientapi == undefined || idClientapi == ''){
                            idClientapi = '';
                            codeClientapi = '';
                        }

                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/clients/modClient.php",
                            data: {
                                "data": $("#kt_form_client").serialize(),
                                "id": idClient,
                                "idclientapi": idClientapi,
                                "idcontactclientapi": idContactClientapi,
                                "codeclientapi": codeClientapi
                            },
                            dataType: 'json',
                            success: function (html) {
                                var modOption = new Option(html.nom+' '+html.prenom, html.id);
                                if ($('#select2_clients').find("option[value='" + html.id + "']").length) {
                                    $('#select2_clients option[value="' + html.id + '"]').remove();
                                }

                                modOption.selected = true;
                                $('#select2_clients').append(modOption).trigger('change');

                                $("#staticBackdropClient").modal('hide');
                                $('#saveModalClient').show();
                                validationAdd.resetForm();
                            }
                        });
                    }else{
                        $('#saveModalClient').show();
                    }
                });
            }
        });

        if($("#idCommandeFrom").val() !== "0"){
            addMod = false;
            $("#select2_clients").val('0').trigger('change');
            $("#select2_commercial").val('0').trigger('change');
            $("#select2_commercial2").val('0').trigger('change');
            $("#select2_technicien").val('0').trigger('change');
            $("#select2_technicien2").val('0').trigger('change');
            $("#select2_typevente").val('1').trigger('change');
            $("#select2_recommandation").val('0').trigger('change');
            $('.etatCommande').show();
            $("#modalTitleCommande").html('Modification d\'une commande');
            $("#saveModalCommande").text('Modifier');
            // $("#quantite").val('1');
            $('#autrestypetravaux').hide();
            $('#autrestypetravaux').val('');
            id = $("#idCommandeFrom").val();
            getCommande(id);
        }

        var onpeutFaireLaModification = false;
        function getCommande(id) {
            listePrestations = [];
            totalHT = 0;
            totalRemise = 0;
            totalRemisePourcent = 0;
            totalNet = 0;
            totalTTC = 0;
            $('#changerEtatCommandeConfirmer').hide();
            $('#changerEtatCommandeAnnuler').hide();
            $(".listePrestations").html('');
            $("#texteFacturation").html('');
            $(".encaisseFacture").hide();
            $(".encaissementFacture").hide();
            $("#encaisseFacturation").html('');
            $("#staticBackdropCommande .modClient").hide();

            if (!nonmodifiable) {
                $('#staticBackdropCommande .modal-body input').prop('disabled', false);
                $('#staticBackdropCommande .modal-body button').prop('disabled', false);
                $('#staticBackdropCommande .modal-body select').prop('disabled', false);
                $('#staticBackdropCommande .modal-body textarea').prop('disabled', false);
                $('#staticBackdropCommande #info').summernote('');
                $('#staticBackdropCommande .listePrestations ').attr("style", "");
                $('#staticBackdropCommande .etatCommande').attr("style", "");
                $("#staticBackdropCommande #saveModalCommande").text('Modifier').prop('disabled', false).show();
                $("#staticBackdropCommande .modClient").show();
                $("#staticBackdropCommande #cancelModal").text('Annuler');
                $("#staticBackdropCommande #annulerCommande").show();
                onpeutFaireLaModification = true;
            }

            $.ajax({
                type: "POST",
                url: "./assets/ajax/commandes/getCommande.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function (k, v) {
                        if (k == 'historique') {
                            gereHistorique(v);
                        }

                        if (k == 'idclient') {
                            $("#select2_clients").val(v).trigger('change');
                        }

                        if (k == "adressetravaux") {
                            idClient = data.idclient;
                            if (idClient != null && idClient != '0' && idClient != '' && idClient != undefined) {
                                $.ajax({
                                    type: "POST",
                                    url: "./assets/ajax/clients/getClient.php",
                                    data: {
                                        "id": idClient
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        nomclient = data.prenom + ' ' + data.nom;
                                        adresseclient = data.adresse + ' ' + data.codepostal + ' ' + data.ville;
                                        adresseclienttab = data.adresseClient;

                                        if (!nonmodifiable) {
                                            if (v == 1) {
                                                $("input[name='adresseTravaux']").prop('checked', true).trigger('change');
                                                $(".lesChampsTravaux").prop('disabled', true);
                                            } else {
                                                $("input[name='adresseTravaux']").prop('checked', false).trigger('change');
                                                $(".lesChampsTravaux").prop('disabled', false);
                                            }
                                        } else {
                                            $(".lesChampsTravaux").prop('disabled', true);
                                        }
                                    }
                                });
                            }
                        }

                        if (k == 'totalHT') {
                            totalHT = parseFloat(v);
                            $("." + k).html(formateChiffreEuroSpan(v));
                        }

                        if (k == 'totalNet') {
                            totalNet = parseFloat(v);
                            $("." + k).html(formateChiffreEuroSpan(v));
                        }

                        if (k == 'totalTTC') {
                            totalTTC = parseFloat(v);
                            $("." + k).html(formateChiffreEuroSpan(v));
                        }

                        if (k == 'totalRemise') {
                            totalRemise = parseFloat(v);
                        }

                        if (k == 'totalRemisePourcent') {
                            totalRemisePourcent = parseFloat(v);
                        }

                        if (k == 'totalTVA') {
                            totalTVA = parseFloat(v);
                            $("." + k).html(formateChiffreEuroSpan(v));
                        }

                        if (k == 'listePrestation') {
                            listePrestations = JSON.parse(v);
                            initialiseListePrestation(listePrestations);
                        }

                        if (k == 'modepaiement') {
                            if (v == 'Crédit') {
                                $(".paiementcredit").show();
                            } else {
                                $(".paiementcredit").hide();
                            }
                            $('#modepaiementfact').val(v);
                        }

                        if (k == 'numero') {
                            $('#numcomfact').val(v);
                        }

                        if (k == 'solde'){
                            $('.solde').val(v);
                            if (parseFloat(v) > 0){
                                $('.solde').removeClass('bg-success');
                                $('.solde').addClass('bg-danger');
                            }else{
                                $('.solde').removeClass('bg-danger');
                                $('.solde').addClass('bg-success');
                            }
                        }

                        if (k == 'travauxaexecuter') {
                            $('#objetfact').val(v);
                        }

                        $("#" + k).val(v);

                        if (k == 'info') {
                            info = v.replaceAll('<br />', '\n');
                            $("#info").val(info);
                            $("#info").summernote("code", v);
                        }

                        if (k == 'encaissementshtml') {
                            if (parseFloat(data.solde) <= 0) {
                                $('.encaisseFacture').show();
                            }else{
                                $('.encaisseFacture').hide();
                            }
                            $('#addtabencaissements').empty();
                            $('#addtabencaissements').html(v);
                        }

                    });

                    if (data.dateEnvoye !== "01/01/1970 01:00:00" && data.dateEnvoye !== null) {
                        $('#staticBackdropCommande .modal-body input').prop('disabled', true);
                        $('#staticBackdropCommande .modal-body button').prop('disabled', true);
                        $('#staticBackdropCommande .modal-body select').prop('disabled', true);
                        $('#staticBackdropCommande .modal-body textarea').prop('disabled', true);
                        $('#staticBackdropCommande #info').summernote('disable');
                        $('#staticBackdropCommande .listePrestations ').attr("style", "pointer-events: none;");
                        $('#staticBackdropCommande .etatCommande').attr("style", "pointer-events: none;");
                        $("#staticBackdropCommande #saveModalCommande").text('Modifier').prop('disabled', true).hide();
                        $("#staticBackdropCommande #cancelModal").text('Fermer');
                        $("#staticBackdropCommande #annulerCommande").hide();
                        $("#staticBackdropCommande .modClient").hide();
                        onpeutFaireLaModification = false;

                        if (!nonmodifiable) {
                            $('#saveModalCommande').prop('disabled', false);
                            onpeutFaireLaModification = true;
                        }
                    }

                    $(".etatCommande").html(data.etathtml);
                    calculMontantTTC(listePrestations);
                    $("#staticBackdropCommande").modal({keyboard: false});
                }
            });
        }

        function gereHistorique(listeHistorique){
            $(".tableHistorique").html('');
            var historique = "";
            $.each(listeHistorique, function(kH, vH){
                historique = '<tr><td style="font-size:14px !important;">'+vH.date+' - '+vH.message+'</td></tr>' + historique;
            });
            $(".tableHistorique").html(historique);
        }

        $('#kt_select2_dateCommandes').on('change', function(e) {
            var exercice = $(this).val();

            $.ajax({
                type: "POST",
                url: "./assets/ajax/general/changeExercice.php",
                data: {
                    "data": exercice
                },
                dataType: 'html',
                success: function (data) {
                    let url = window.location.href;

                    if(url.split('admin/commandes.php').length - 1 > 0){
                        window.location.href = '/admin/commandes.php';
                    }else if(url.split('commercial/commandes.php').length - 1 > 0) {
                        window.location.href = '/commercial/commandes.php';
                    }else{
                        location.reload();
                    }
                }
            });
        });

        $('#numtel').on("keyup", function() {
            this.value = formateTelephone(this.value);
        });

        $('#numportable').on("keyup", function() {
            this.value = formateTelephone(this.value);
        });

        function formateTelephone(value){
            value = value.replace(/ /g,'');
            value = value.replace(/\D/g,'');
            return value.replace(/\B(?=(\d{2})+(?!\d))/g, " ");
        }

        // Click sur Annuler la commande
        $('#annulerCommande').on('click', function (e){
            e.preventDefault();
            $('#commentaireAnnulation').val('');
            $('#staticBackdropAnnulerCommande').modal('show');
        });

        // Click sur annuler
        $('#annulationCommandeAnnuler').on('click', function (e) {
            e.preventDefault();
            $('#staticBackdropAnnulerCommande').modal('hide');
        });

        // Click sur la croix
        $("button[data-number=2]").on('click', function(){
            $('#staticBackdropAnnulerCommande').modal('hide');
        });

        // Click sur valider
        $('#annulationCommandeConfirmer').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "./assets/ajax/commandes/annulationCommande.php",
                data: {
                    "id" : id,
                    "commentaire" : $('#commentaireAnnulation').val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        $('#staticBackdropAnnulerCommande').modal('hide');
                        location.reload();
                    }else{
                        $("#erreursToastBody").text(data.erreur);
                        $("#liveToastErreurs").toast("show");
                    }
                }
            });
        });

        // Fermer la modale
        $('#annulerselectclientapi').on('click', function (e) {
            e.preventDefault();
            $('#staticBackdropapiclient').modal('hide');
        });

        $("button[data-number=3]").on('click', function(){
            $('#staticBackdropapiclient').modal('hide');
        });

        $(".addFacture").on('click', function (e){
            var these = $(this);
            these.hide();
            $(".spinneraddfacture").show();

            let onEnvoi = true;
            $.each(listePrestations, function(k, v){
                if(v.tva == "0"){
                    onEnvoi = false;
                }
            });

            if(onEnvoi) {
                $.ajax({
                    type: "POST",
                    url: "./assets/ajax/api/addBrouillonFacture.php",
                    data: {
                        "idcommande": id,
                        "dateFacturation": $("#dateFacturation").val()
                    },
                    dataType: 'json',
                    success: function (jsonres) {
                        if (jsonres.texteFacture == 'Erreur') {
                            $("#infosToastBody").text("Erreur création de la facture. Client inexistant, contact client non récupéré ou facture déjà créée dans evoliz.");
                            $("#liveToastInformations").toast("show");
                            $(".spinneraddfacture").hide();
                            these.show();
                        } else {
                            $("#infosToastBody").text("Facture créée dans evoliz (N° de facture externe : " + jsonres.numfactureexterne + ").");
                            $("#liveToastInformations").toast("show");
                            $(".spinneraddfacture").hide();
                            these.show();
                            $("#texteFacturation").html(jsonres.texteFacture);
                            // $(".encaisseFacture").show();
                            $(".encaissementFacture").show();
                        }
                    }
                });
            }else{
                $("#infosToastBody").text("Erreur création de la facture. Les TVA ne doivent pas être à 0.");
                $("#liveToastInformations").toast("show");

                $(".spinneraddfacture").hide();
                these.show();
            }
        })

        $(".addencaissement").on('click', function (e){
            let dateencaissement = $('#dateencaissement').val();
            let typepaiement = $('#typepaiementencaissement').val();
            let montantencaissement = $('#montantencaissement').val();

            if (dateencaissement == '' || typepaiement == '' || montantencaissement == ''){
                $("#erreursToastBody").text("Veuillez renseigner la date d'encaissement, le type de paiement et le montant encaissé.");
                $("#liveToastErreurs").toast("show");
            }else{
                addEncaissementToBdd(dateencaissement, typepaiement, montantencaissement);
            }
        });

        function addEncaissementToBdd(dateencaissement, typepaiement, montantencaissement){
            $.ajax({
                type: "POST",
                url: "./assets/ajax/encaissements/addEncaissement.php",
                data: {
                    "dateencaissement": $('#dateencaissement').val(),
                    "typepaiementencaissement": $('#typepaiementencaissement').val(),
                    "montantencaissement": $('#montantencaissement').val(),
                    "numerocommande": $('#numero').val(),
                    'idcommande': id,
                    "solde": $('.solde').val()
                },
                dataType: 'json',
                success: function (data) {
                    if (data.status == true) {
                        addEncaissementToList(data.dateencaissement, typepaiement, montantencaissement);
                        resetChampsEncaissement();
                        $("#infosToastBody").text("L'encaissement a été ajouté.");
                        $("#liveToastInformations").toast("show");

                        if (data.solde <= 0){
                            $('.encaisseFacture').show();
                            $('.solde').removeClass('bg-danger');
                            $('.solde').addClass('bg-success');
                        } else {
                            $('.solde').removeClass('bg-success');
                            $('.solde').addClass('bg-danger');
                        }

                        $('.solde').val(data.solde);
                    } else {
                        $("#erreursToastBody").text("Une erreur est survenue.");
                        $("#liveToastErreurs").toast("show");
                    }
                }
            });
        }

        function addEncaissementToList(dateencaissement, typepaiement, montantencaissement){
            $('#addaucunencaissement').remove();
            $('#addtabencaissements').append(
                '<tr>' +
                '<td class="dateencaissementcell">' + dateencaissement + '</td>' +
                '<td class="typepaiementcell">' + typepaiement + '</td>' +
                '<td class="montantencaissementcell">' + formateChiffreEuroSpan(montantencaissement) + '</td>' +
                '</tr>'
            );
        }

        function resetChampsEncaissement(){
            $('.fieldsencaissement').val('');
            $('#typepaiementencaissement').val('Avoir').trigger('change');
        }

        function formatePrice(value){
            value = value.replace(/[^\d.,]/g, '');
            value = value.replace(',', '.');
            if (value == '.') {
                value = '0.';
            }
            let valuesplit = value.split('.');
            // Si on a plus de 1 point
            if ((valuesplit.length - 1) > 1) {
                value = valuesplit[0] + '.' + valuesplit[1];
            }

            if (value.indexOf(".") >= 0 && value.slice(-1) != '.' && value.slice(-2) != '.0') {
                value = Math.round(value * 100) / 100;
            }
            return value;
        }
    };

    // Public Functions
    return {
        // public functions
        init: function() {
            _gereModal();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    KTMainDashboardModal.init();
});
