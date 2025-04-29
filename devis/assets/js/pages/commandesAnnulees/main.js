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
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [ 0, 1, 2, 3, 4, 5 ]
                    }
                }
            ],
            language: {
                url: './assets/json/dataTable_french.json'
            },
            columnDefs: [
                {
                    targets: [ 5 ],
                    className: 'text-right'
                }
            ]
        });

        $('#kt_datatable thead tr').clone(true).appendTo( '#kt_datatable thead' );
        $('#kt_datatable thead tr:eq(1) th').each( function (i) {
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

    var _gereResource = function() {
        var validationAddCommande;
        var validationAdd;
        var addMod;
        var addModClient;
        var id;
        var etat;
        var idClient = 0;
        var listePrestations = [];
        var typePrestationSelectionne = [];
        var totalHT = 0;
        var totalRemise = 0;
        var totalRemisePourcent = 0;
        var totalNet = 0;
        var totalTTC = 0;
        var totalTVA = 0;
        var leSortable = false;
        var info;

        var idPrestation = 0;
        var codePrestation = "";
        var categoriePrestation = "";
        var montantPrestation = 0;
        var tvaPrestation = 0;
        var designationPrestation = "";
        var designationCPrestation = "";
        var unitePrestation = "";
        var montanttotalprestation = 0;
        var idDivers = 50000;

        var tabTravaux = [];

        var triGrandeFamille = [{0: "I", 1:"V", 2:"Z", 3:"A", 4:"C", 5:"D", 6:"S"}];
        var triFamille = [{"I":{0:"TP", 1:"CP", 2:"CA", 3:"TR", 4:"M", 5:"TE", 6:"PB"}, "V":{0:"TP", 1:"MC", 2:"PS"}, "Z":{0:"TP", 1:"F", 2:"G"}, "A":{0:"S"}, "C":{0:"TP", 1:"P", 2:"I"}, "D":{0: "TP", 1: "T", 2:"F"}, "S":{0:"TP", 1:"F", 2:"P"}}];
        var initialeArray = [{"I":{"TP":"Travaux préparatoires", "CP":"Isolation des combles perdus", "CA":"Isolation des combles aménagés", "TR": "Isolation des combles aménagés", "M":"Isolation des murs", "TE":"Isolation des murs", "PB":"Isolation des plancher bas"}, "V": {"TP":"Travaux préparatoires", "MC": "VMC", "PS": "VPS", "S": "Extracteur d'air"}, "Z": {"TP":"Travaux préparatoires", "F": "Faitage et Arretier", "G": "Gouttière et descente Zinc", "H":"Sous-famille de zinguerie à compléter"}, "A":{"S":"Assaichement des murs par injection"}, "C":{"TP": "Travaux préparatoires", "P": "Pulvérisation", "I": "Injection"}, "D": {"TP": "Travaux préparatoires", "T": "Traitement des tuiles", "F": "Traitement de façade"}, "S": {"TP": "Travaux préparatoire", "F": "Habillage des sous faces PVC aléatoire", "P": "Panne"}}];

        var autrestypetravaux = '';

        $("#annulerCommande").hide();

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
                    codepostal: {
                        validators: {
                            integer: {
                                message: 'Le code postal ne doit contenir que des chiffres',
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

        /*$(".typestravaux").on('click', '.type_prestations', function(){
            var these = $(this);
            $(".type_prestations").prop('disabled', true);

            if($(this).prop('checked')){
                var dataRefDefaut = $(this).attr('data-refdefaut');
                if(dataRefDefaut == ""){
                    var refDefaut = 0;
                    var refDefautATraiter = 0;
                }else{
                    var refDefaut = dataRefDefaut.split('|');
                    var refDefautATraiter = dataRefDefaut.split('|');
                }

                if(refDefaut != 0){
                    // on vérifie que le code n'a pas déjà été mis par une autre prestation
                    $.each(refDefautATraiter, function(kD, vD){
                        $.each(typePrestationSelectionne, function(kP, vP){
                            if(jQuery.inArray(vD, vP.refDefaut) !== -1){
                                refDefautATraiter.splice(kD, 1);
                            }
                        });
                    });

                    $.ajax({
                        type: "POST",
                        url: "./assets/ajax/general/getPrestationByIds.php",
                        data: {
                            "id": refDefautATraiter
                        },
                        dataType: 'json',
                        success: function (data) {
                            var id = these.attr('id');
                            $.each(data, function(kD, vD){
                                idPrestation = kD;
                                codePrestation = vD.code;
                                montantPrestation = vD.montant;
                                tvaPrestation = vD.tva;
                                designationPrestation = vD.designationSimple;
                                designationCPrestation = vD.designationComplementaire;
                                if(vD.designationComplementaire === null){
                                    designationCPrestation = "";
                                }
                                unitePrestation = vD.unite;
                                // categoriePrestation = $(".form-check-label[for='"+id+"']").html();

                                var tvaSPLIT = tvaPrestation.split('|');

                                montanttotalprestation = vD.montant;

                                var Array = {
                                    id: idPrestation,
                                    code: codePrestation,
                                    montant: montantPrestation,
                                    montanttotalprestation: montanttotalprestation,
                                    designation: designationPrestation + '<br />'+designationCPrestation,
                                    quantite: 1,
                                    tva: tvaSPLIT[0],
                                    //categorie: getCategorie(codePrestation),
                                    unite: unitePrestation,
                                    //famille: getFamilleCategorie(codePrestation)
                                };

                                listePrestations.push(Array);
                            });

                            initialiseListePrestation(listePrestations);
                            totalHT = calculMontantTotalHT(listePrestations);
                            totalNet = calculMontantNet(totalHT, totalRemise);
                            totalTTC = calculMontantTTC(listePrestations);
                        }
                    });

                    var Array = {
                        id: $(this).val(),
                        refDefaut: refDefaut
                    };

                    typePrestationSelectionne.push(Array);

                }

                $(".type_prestations").prop('disabled', false);
            }else{
                var trouve = 0;
                $.each(typePrestationSelectionne, function(k, v){
                    if(v.id == these.val()){
                        if(v.refDefaut != 0){
                            $.each(v.refDefaut, function(kD, vD){
                                // on vérifie que le code n'est pas dans un autre type avant de supprimer
                                var onChercheLeCodeAilleurs = false;
                                $.each(typePrestationSelectionne, function(kP, vP){
                                    if(kP !== k){
                                        if(jQuery.inArray(vD, vP.refDefaut) !== -1){
                                            onChercheLeCodeAilleurs = true;
                                        }
                                    }
                                });

                                if(!onChercheLeCodeAilleurs){
                                    var cle = $(".lignePrestation[data-id='"+vD+"']").attr('data-cle');
                                    var trouvee = 0;
                                    $.each(listePrestations, function(kk, vv){
                                        if(kk == cle){
                                            trouvee = kk;
                                        }
                                    });

                                    listePrestations.splice(trouvee, 1);
                                    initialiseListePrestation(listePrestations);
                                }
                            });
                        }

                        trouve = k;
                    }
                });

                typePrestationSelectionne.splice(trouve, 1);
                $(".type_prestations").prop('disabled', false);
                totalHT = calculMontantTotalHT(listePrestations);
                totalNet = calculMontantNet(totalHT, totalRemise);
                totalTTC = calculMontantTTC(listePrestations);
            }
        });*/

        $('#select2_commercial').select2({
            placeholder: 'Choisissez un commercial'
        });
        $('#select2_commercial2').select2({
            placeholder: 'Choisissez un commercial'
        });
        $('#select2_typevente').select2({
            placeholder: 'Choisissez un commercial'
        });

        $('#select2_recommandation').select2({
            placeholder: 'Choisissez une recommandation'
        });

        $('#select2_clients').select2({
            placeholder: 'Choisissez un client',
            templateResult: function (data) {
                var $option = $("<span></span>");
                $option.text(data.text);

                return $option;
            },
            templateSelection: function (data) {
                var $option = $("<span></span>");
                $option.text(data.text);

                return $option;
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

            $(".listePrestations").html('');
            listePrestations = [];
            totalHT = 0;
            totalRemise = 0;
            totalRemisePourcent = 0;
            totalNet = 0;
            totalTTC = 0;

            $("#info").summernote("code", "");
            $("#select2_prestations").val(null).trigger('change');
            $("#select2_clients").val(null).trigger('change');
            $("#select2_commercial").val(null).trigger('change');
            $("#select2_commercial2").val(null).trigger('change');
            $(".totalTVA").html('0&nbsp;€');
            $(".totalHT").html('0&nbsp;€');
            $(".totalTTC").html('0&nbsp;€');
            $(".totalNet").html('0&nbsp;€');
            $("#totalRemise").val('');
            $("#totalRemisePourcent").val('');

            $('#kt_form_1').trigger("reset");
            $("#quantite").val(1);
            $("#adresseTravaux").prop('checked', true);
            $(".lesChampsTravaux").prop('disabled', true);
            $('#changerEtatCommandeConfirmer').hide();
            $('#changerEtatCommandeAnnuler').hide();
            /*$(".typestravaux :checkbox").prop('checked', false);
            $('#autrestypetravaux').hide();
            $('#autrestypetravaux').val('');
            changeListTypePrestations(true);*/
            $('.etatCommande').hide();
            $(".paiementcredit").hide();
            $("#modalTitle").html('Ajout d\'une commande');
            $("#saveModal").text('Ajouter');
        });

        $(".modCommande").click(function(){
            addMod = false;
            $("#select2_clients").val(null).trigger('change');
            $("#select2_commercial").val(null).trigger('change');
            $("#select2_commercial2").val(null).trigger('change');
            $('.etatCommande').show();
            $("#modalTitle").html('Affichage d\'une commande annulée');
            $("#saveModal").text('Modifier');
            $("#quantite").val('1');
            /*$(".typestravaux :checkbox").prop('checked', false);
            $('#autrestypetravaux').hide();
            $('#autrestypetravaux').val('');*/
            id = $(this).attr('data-id');
            getCommande(id);
        });

        $('#saveModal').on('click', function (e) {
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
                    }else{
                        $('#saveModal').show();
                    }
                });
            }else{
                formData.append('id', id);
                validationAddCommande.validate().then(function (status) {
                    if (status == 'Valid') {
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/commandes/modCommande.php",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (html) {
                                if (html == true) {
                                    window.location = './admin/commandes.php';
                                } else {
                                    $('#saveModal').show();
                                    $(".erreurLogin").show();
                                }
                                $('#changerEtatCommandeConfirmer').hide();
                                $('#changerEtatCommandeAnnuler').hide();
                            }
                        });
                    }else{
                        $('#saveModal').show();
                    }
                });
            }
        });

        $("#adresseTravaux").change(function(){
            if($(this).prop('checked')){
                $(".lesChampsTravaux").prop('disabled', true);
                $("#numerotravaux").val('');
                $("#ruetravaux").val('');
                $("#cptravaux").val('');
                $("#villetravaux").val('');
            } else{
                $(".lesChampsTravaux").prop('disabled', false);
            }
        });

        $("#totalRemise").keyup(function(){
            if($(this).val() == ""){
                totalRemise = 0;
            }else{
                totalRemise = parseFloat($(this).val());
            }

            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
        });

        $("#totalRemisePourcent").keyup(function(){
            if($(this).val() == ""){
                totalRemisePourcent = 0;
            }else{
                totalRemisePourcent = parseFloat($(this).val());
            }

            totalNet = calculMontantNetPourcent(totalHT, totalRemisePourcent);
            totalTTC = calculMontantTTC(listePrestations);
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

        $(".listePrestations").on('change', '.modDesignation', function(){
            var laCle = $(this).attr('data-cle');
            var designation = $(this).html();
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
            var qte = $("#quantite").val();
            addPrestationToList(listePrestations, 'prestation', qte, false);
            totalHT = calculMontantTotalHT(listePrestations);
            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
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
            idPrestation = "";
            codePrestation = "";
            montantPrestation = "";
            tvaPrestation = "";
            designationPrestation = "";
            designationCPrestation = "";
            unitePrestation = "";
        });

        $(".listePrestations").on('click', '.deletePrestation', function(){
            var cleQuonSupprime = $(this).attr('data-cle');
            if (listePrestations[cleQuonSupprime].quantite == '0'){
                removePrestationToList(listePrestations, cleQuonSupprime);
                totalHT = calculMontantTotalHT(listePrestations);
                totalNet = calculMontantNet(totalHT, totalRemise);
                totalTTC = calculMontantTTC(listePrestations);
            }else{
                $("#liveToastDeletePrestation").toast("show");
            }
        });

        $(".listePrestations").on('change', '.tvaPrestation', function(){
            var cleQuonModifie = $(this).attr('data-cle');
            changeTVAPrestation(listePrestations, cleQuonModifie, $(this).val());
            totalHT = calculMontantTotalHT(listePrestations);
            totalNet = calculMontantNet(totalHT, totalRemise);
            totalTTC = calculMontantTTC(listePrestations);
        });

        $("#staticBackdrop").on('click', '.boutonEtat', function (e) {
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
                    $("#boutonFacturee").removeAttr( "class" );
                    $("#boutonPayee").removeAttr( "class" );
                    switch (etat){
                        case "Facturée":
                            $("#boutonFacturee").addClass( "boutonEtat bg-warning font-weight-bold" );
                            $("#boutonPayee").addClass( "boutonEtat bg-secondary opacity-50" );
                            break;
                        case "Payée" :
                            $("#boutonFacturee").addClass( "boutonEtat bg-warning font-weight-bold" );
                            $("#boutonPayee").addClass( "boutonEtat bg-danger font-weight-bold" );
                            break;
                        case "En cours":
                            $("#boutonFacturee").addClass( "boutonEtat bg-secondary opacity-50" );
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

        /*function getCategorie(code){
            var valeur = "";
            var initial = code.charAt(0);
            $.each(initialeArray, function(kI, vI){
                $.each(vI, function(kP, vP){
                    if(kP == initial){
                        $.each(vP, function(kK, vK){
                            if(countInstances(code, kK)){
                                valeur = vK;
                            }
                        });
                    }
                });
            });

            return valeur;
        }*/

        /*function getFamilleCategorie(code){
            if(code.charAt(0) == 'I'){
                return 'Isolation';
            }else if(code.charAt(0) == 'Z'){
                return 'Zinguerie';
            }else if(code.charAt(0) == 'V'){
                return 'Ventilation';
            }else if(code.charAt(0) == 'C'){
                return 'Traitement de charpentes';
            }else if(code.charAt(0) == 'D'){
                return 'Traitement de toiture et façade';
            }else if(code.charAt(0) == 'S'){
                return 'Habillage sous façe';
            }else if(code.charAt(0) == 'A'){
                return 'Assechement des murs';
            }else{
                return 'Autres';
            }
        }*/

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
                    qte = parseInt(listePrestations[k].quantite);
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
            //var categorieTemp = "";
            //var familleTemp = "";
            // listePrestations = triListePrestation(listePrestations);
            $.each(listePrestations, function(k, v){
                /*if((familleTemp == "" || familleTemp != v.famille) && v.famille != 0){
                    $(".listePrestations").append('<tr class="disable-sort-item"><td data-catagorie="'+v.famille+'" colspan="8"><strong>'+v.famille+'</strong></td></tr>');
                    familleTemp = v.famille;
                    categorieTemp = "";
                }

                if((categorieTemp == "" || categorieTemp != v.categorie) && v.categorie != 0){
                    $(".listePrestations").append('<tr class="disable-sort-item"><td data-catagorie="'+v.categorie+'" colspan="8"><strong>'+v.categorie+'</strong></td></tr>');
                    categorieTemp = v.categorie;
                }*/

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
            $.each(listePrestations, function (cle, v) {
                /*if((categorieTemp == "" || categorieTemp != v.categorie) && v.categorie != 0){
                    html += '<tr class="disable-sort-item"><td data-catagorie="'+v.categorie+'" colspan="8"><strong>'+v.categorie+'</strong></td></tr>';
                    categorieTemp = v.categorie;
                }*/

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

                let designation = v.designation;
                let combienBR = designation.split('<br />').length - 1 + designation.split('\r\n').length - 1 ;
                designation = designation.replaceAll('<br />', '\n');
                let height = combienBR * 28;
                if(height == 0){
                    height = 28;
                }

                if(v.type == 'prestation') {
                    html += '<tr class="lignePrestation" data-id="' + v.id + '" data-cle="' + cle + '"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="' + v.code + '" class="form-control modCode" data-cle="' + cle + '"></td><td style="vertical-align: middle; width:560px;"><textarea style="height:'+height+'px;" class="form-control modDesignation" data-cle="' + cle + '">' + designation + '</textarea></td><td style="vertical-align: middle; width:60px;"><input style="width:50px;" type="number" min="0" step="0.1" value="' + v.montant + '" class="form-control modMontant" data-cle="' + cle + '"></td><td style="vertical-align: middle; width:41px;">€/' + v.unite + '</td><td style="vertical-align: middle; width:70px;"><select class="tvaPrestation form-control" data-cle="' + cle + '"><option ' + isSelect5 + ' value="5.5">5.5%</option><option ' + isSelect10 + ' value="10">10%</option><option ' + isSelect20 + ' value="20">20%</option></select></td><td style="vertical-align: middle;"><input style="width:50px;" type="number" min="1" step="1" value="' + v.quantite + '" class="form-control modQte" data-cle="' + cle + '"></td><td class="montanttotalprestation" data-cle="' + cle + '" style="vertical-align: middle; width:41px;">' + formateChiffreEuroSpan(v.montanttotalprestation) + '</td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle;" data-cle="' + cle + '" class="deletePrestation">X</td></tr>';
                }else{
                    html += '<tr class="lignePrestation" data-id="' + v.id + '" data-cle="' + cle + '"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="' + v.code + '" class="form-control modCode" data-cle="' + cle + '"></td><td style="vertical-align: middle; width:560px;" colspan="6"><textarea style="height:'+height+'px;" class="form-control modDesignation" data-cle="' + cle + '">' + designation + '</textarea></td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle;" data-cle="' + cle + '" class="deletePrestation">X</td></tr>';
                }
            });

            $(".listePrestations").html(html);

            /*$('.modDesignation').summernote({
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
            });*/
        });

        function calculMontantTTC(listePrestations){
            $(".totalTVA").html(formateChiffreEuroSpan(0));
            var calcul = {};
            $.each(listePrestations, function(k, v){
                if(v.type == 'prestation') {
                    if (calcul.hasOwnProperty(v.tva)) {
                        calcul[v.tva] = parseFloat(calcul[v.tva]) + (parseFloat(v.montant) * parseFloat(v.quantite));
                    } else {
                        calcul[v.tva] = parseFloat(v.montant) * parseFloat(v.quantite);
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

        function calculMontantNet(totalHT, remise){
            var leTotal = totalHT - remise;
            $(".totalNet").html(formateChiffreEuroSpan(leTotal));

            return leTotal;
        }

        function calculMontantNetPourcent(totalHT, remise){
            var leMontantDeLaRemise = (totalHT * remise) / 100;
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
                    leTotal += parseInt(v.quantite) * parseFloat(v.montant);
                }
            });

            $(".totalHT").html(formateChiffreEuroSpan(leTotal));

            return leTotal;
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
            let combienBR = designation.split('<br />').length - 1 + designation.split('\r\n').length - 1 ;
            designation = designation.replaceAll('<br />', '\n');
            let height = combienBR * 28;
            if(height == 0){
                height = 28;
            }
            $(".listePrestations").append('<tr class="lignePrestation" data-id="'+idPrestation+'" data-cle="'+cle+'"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="'+codePrestation+'" class="form-control modCode" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:560px;"><textarea style="height:'+height+'px" class="form-control modDesignation" data-cle="'+cle+'">'+designationPrestation+'</textarea></td><td style="vertical-align: middle; width:60px;"><input style="width:50px;" type="number" min="0" step="0.1" value="'+montantPrestation+'" class="form-control modMontant" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:41px;">€/'+unitePrestation+'</td><td style="vertical-align: middle; width:70px;"><select class="tvaPrestation form-control" data-cle="'+cle+'"><option value="5.5">5.5%</option><option value="10">10%</option><option value="20">20%</option></select></td><td style="vertical-align: middle;"><input style="width:50px;" type="number" min="1" step="1" value="'+quantite+'" class="form-control modQte" data-cle="'+cle+'"></td><td class="montanttotalprestation" data-cle="' + cle + '" style="vertical-align: middle; width:41px;">'+montanttotalprestation+'</td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle;" data-cle="'+cle+'" class="deletePrestation">X</td></tr>');
            $(".tvaPrestation[data-cle='"+cle+"']").val(tvaPrestation);

            if($('.tvaPrestation[data-cle="'+cle+'"] option[value="' + tvaPrestation + '"]').length === 0) {
                $(".tvaPrestation[data-cle='"+cle+"']").val($(".tvaPrestation[data-cle='"+cle+"'] option:first").val());
            }

            /*$('.modDesignation[data-cle="'+cle+'"]').summernote({
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
            });*/
        }

        function addPrestationLigneToHTML(cle, idPrestation, codePrestation, designationPrestation){
            designationPrestation = designationPrestation.replaceAll('<br />', '\n');
            $(".listePrestations").append('<tr class="lignePrestation" data-id="'+idPrestation+'" data-cle="'+cle+'"><td style="vertical-align: middle; width:90px;"><input style="width:80px;" type="text" value="'+codePrestation+'" class="form-control modCode" data-cle="'+cle+'"></td><td style="vertical-align: middle; width:560px;" colspan="6"><textarea class="form-control modDesignation" data-cle="'+cle+'">'+designationPrestation+'</textarea></td><td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle;" data-cle="'+cle+'" class="deletePrestation">X</td></tr>');

            /*$('.modDesignation[data-cle="'+cle+'"]').summernote({
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
            });*/
        }

        function addPrestationToList(listePrestations, type, quantite, open){
            if(codePrestation != "" && quantite != "") {
                if(type == 'prestation') {
                    var tvaSPLIT = tvaPrestation.split('|');
                    if (quantite == '' || quantite == null || quantite == 0 || type == 'ligne') {
                        montanttotalprestation = 0;
                    } else {
                        montanttotalprestation = parseInt(quantite) * parseFloat(montantPrestation);
                    }

                    var Array = {
                        id: idPrestation,
                        code: codePrestation,
                        montant: montantPrestation,
                        montanttotalprestation: montanttotalprestation,
                        designation: designationPrestation + '<br />'+designationCPrestation,
                        //categorie: getCategorie(codePrestation),
                        quantite: quantite,
                        tva: tvaSPLIT[0],
                        unite: unitePrestation,
                        type: type
                        //famille: getFamilleCategorie(codePrestation)
                    };
                }else{
                    var Array = {
                        id: idPrestation,
                        code: codePrestation,
                        montant: "",
                        montanttotalprestation: "",
                        designation: designationPrestation + '<br />'+designationCPrestation,
                        //categorie: getCategorie(codePrestation),
                        quantite: 0,
                        tva: "",
                        unite: "",
                        type: type
                        //famille: getFamilleCategorie(codePrestation)
                    };
                }

                listePrestations.push(Array);
                initialiseListePrestation(listePrestations);

                $("#quantite").val('1');
                $("#select2_prestations").val(null).trigger('change');
                if(open){
                    $("#select2_prestations").select2('open');
                }
            }
        }

        // CLIENTS
        $('input[type=file]').css('color', 'transparent');

        $(".addClient").click(function(){
            addModClient = true;

            $('#kt_form_client').trigger("reset");
            $("#select2_clients").val(null).trigger('change');
            $("#modalTitleClient").html('Ajout d\'un client');
            $("#modalTitleClient").attr('data-modifier', 'false');
            $("#saveModalClient").text('Ajouter').show();
        });

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

                        if (k == 'civilite' && v != 0) {
                            civilite = v;
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

                                $("#staticBackdropClient").modal('toggle');
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
                        $.ajax({
                            type: "POST",
                            url: "./assets/ajax/clients/modClient.php",
                            data: {
                                "data": $("#kt_form_client").serialize(),
                                "id": idClient
                            },
                            dataType: 'json',
                            success: function (html) {
                                var modOption = new Option(html.prenom+' '+html.nom, html.id);
                                if ($('#select2_clients').find("option[value='" + html.id + "']").length) {
                                    $('#select2_clients option[value="' + html.id + '"]').remove();
                                }

                                modOption.selected = true;
                                $('#select2_clients').append(modOption).trigger('change');

                                $("#staticBackdropClient").modal('toggle');
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
            $("#select2_clients").val(null).trigger('change');
            $("#select2_commercial").val(null).trigger('change');
            $("#select2_commercial2").val(null).trigger('change');
            $('.etatCommande').show();
            $("#modalTitle").html('Modification d\'une commande');
            $("#saveModal").text('Modifier');
            $("#quantite").val('1');
            $('#autrestypetravaux').hide();
            $('#autrestypetravaux').val('');
            id = $("#idCommandeFrom").val();
            getCommande(id);
        }

        function getCommande(id){
            listePrestations = [];
            totalHT = 0;
            totalRemise = 0;
            totalRemisePourcent = 0;
            totalNet = 0;
            totalTTC = 0;
            $('#changerEtatCommandeConfirmer').hide();
            $('#changerEtatCommandeAnnuler').hide();
            $(".listePrestations").html('');
            /*$(".typestravaux :checkbox").prop('checked', false);
            $('#autrestypetravaux').hide();
            $('#autrestypetravaux').val('');*/
            $.ajax({
                type: "POST",
                url: "./assets/ajax/commandes/getCommande.php",
                data: {
                    "id": id
                },
                dataType: 'json',
                success: function (data) {
                    $.each(data, function(k, v){
                        /*if (k == 'typetravauxisolation'){
                            if(v == 1){
                                $("#"+k).prop('checked', true);
                            }else{
                                $("#"+k).prop('checked', false);
                            }
                            changeListTypePrestations();
                        }*/

                        if(k == 'historique'){
                            gereHistorique(v);
                        }

                        if(k == 'idclient'){
                            $("#select2_clients").val(v).trigger('change');
                        }
                        if(k == 'idcommercial'){
                            $("#select2_commercial").val(v).trigger('change');
                        }
                        if(k == 'idcommercial2'){
                            $("#select2_commercial2").val(v).trigger('change');
                        }

                        if (k == 'idtechnicien') {
                            if (v != '0' && v != ''){
                                $("#select2_technicien").val(v).trigger('change');
                            }
                        }
                        if (k == 'idtechnicien2') {
                            if (v != '0' && v != ''){
                                $("#select2_technicien2").val(v).trigger('change');
                            }
                        }
                        if (k == 'typevente') {
                            $("#select2_typevente").val(v).trigger('change');
                        }
                        if (k == 'recommandation') {
                            $("#select2_recommandation").val(v).trigger('change');
                        }

                        if(k == 'sol' || k == 'charpente'){
                            $("input[name='"+k+"'][value='"+v+"']").prop('checked', true);
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

                        /*if(k == 'typetravaux'){
                            tabTravaux = v.split('|');
                            initialiseCheckboxTypeTravaux();
                        }*/

                        /*if(k == 'autrestypetravaux'){
                            autrestypetravaux = v;
                            if ($("#typetravaux6").prop('checked')){
                                $('#autrestypetravaux').show();
                                $('#autrestypetravaux').val(v);
                            }else{
                                $('#autrestypetravaux').hide();
                                $('#autrestypetravaux').val('');
                            }
                        }*/

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
                        }

                        if (k == 'solde'){
                            $('.solde').val(v);
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
                    $("#staticBackdrop").modal({keyboard: false});
                }
            });
        }

        function gereHistorique(listeHistorique){
            $(".tableHistorique").html('');
            var historique = "";
            $.each(listeHistorique, function(kH, vH){
                historique += '<tr><td style="font-size:14px !important;">'+vH.date+' - '+vH.message+'</td></tr>';
            });
            $(".tableHistorique").html(historique);
        }

        /*$('#typetravauxisolation').on('click', function(e){
            changeListTypePrestations(true);
        });*/

        /*function changeListTypePrestations(clean = false){
            var typeTravaux;
            if($("#typetravauxisolation").is(':checked')){
                typeTravaux = '1';
            }else{
                typeTravaux = '0';
            }

            $('#autrestypetravaux').hide();
            $('#autrestypetravaux').val('');
            $('.typestravaux').empty();

            $.ajax({
                type: "POST",
                url: "./assets/ajax/commandes/changeListTypeTravaux.php",
                data: {
                    "typeTravaux": typeTravaux
                },
                dataType: 'html',
                success: function (html) {
                    var span = '<span class="form-text text-muted">Type de travaux</span>';
                    $('.typestravaux').append(html, span);
                    initialiseCheckboxTypeTravaux();

                    if(clean){
                        $(".typestravaux input:checkbox").prop('checked', false);
                        $('#autrestypetravaux').hide();
                        $('#autrestypetravaux').val('');
                    }
                }
            });
        }*/

        /*function initialiseCheckboxTypeTravaux(){
            $(".typestravaux :checkbox").prop('checked', false);
            $('#autrestypetravaux').hide();
            $('#autrestypetravaux').val('');

            $("#typetravaux6").on('click', function (e){
                if ($("#typetravaux6").prop('checked')){
                    $('#autrestypetravaux').show();
                }else{
                    $('#autrestypetravaux').hide();
                    $('#autrestypetravaux').val('');
                }
            });

            $.each(tabTravaux, function(kT, vT){
                $("input[name='typetravaux[]'][value='"+vT+"']").prop('checked', true);
                if (vT == "6"){
                    $('#autrestypetravaux').show();
                    $('#autrestypetravaux').val(autrestypetravaux);
                }
            });
        }*/

        /*function triListePrestation(listePrestations){
            var arrayTrie = [];
            var arrayCodeTraite = [];
            $.each(triGrandeFamille[0], function(kF, vF){
                $.each(triFamille[0][vF], function(kC, vC){
                    $.each(listePrestations, function(kL, vL){
                        if(vL != ""){
                            if(vL.code.charAt(0) == vF && countInstances(vL.code, vC)){
                                arrayTrie.push(listePrestations[kL]);
                                arrayCodeTraite.push(vL.code);
                            }
                        }
                    });
                });
            });

            var elementsAAjouter = [];
            $.each(listePrestations, function(kP, vP){
                if(!arrayCodeTraite.includes(vP.code)){
                    elementsAAjouter.push(listePrestations[kP]);
                }
            });

            listePrestations = [];
            listePrestations = arrayTrie;

            $.each(elementsAAjouter, function(kE, vE){
                listePrestations.push(vE);
            });

            return listePrestations;
        }*/

        /*function countInstances(string, word) {
            return string.split(word).length - 1;
         }*/ 

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
                    location.reload();
                }
            });
        });

        $("#select2_typevente").on('change', function(e) {
           if ($("#select2_typevente").val() == '3') {
               $('.lestechniciens').show();
           } else {
               $('.lestechniciens').hide();
               $('#select2_technicien').val(null).trigger('change');
               $('#select2_technicien2').val(null).trigger('change');
               $('#select2_recommandation').val('0').trigger('change');
           }
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
    };

    // Public Functions
    return {
        // public functions
        init: function() {
            _page = $('.accueil a');
            _subpage = $('.commandesAnnulees');
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
