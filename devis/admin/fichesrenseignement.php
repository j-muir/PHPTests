<?php

session_start();
if (!isset($_SESSION['user']['login'])) {
    header('Location: ../');
}

include('../assets/includes/connexion.php');
include('../assets/includes/fonctions/fonctionsgeneral.php');

if (!getDroitsPage($connexion, $_SERVER['REQUEST_URI'], $_SESSION['user']['typeutilisateur'])) {
    header('Location: index.php');
}

deleteUserBlocage($connexion, $_SESSION['user']['login']);
$arrayPresationFiche = getPrestations($connexion, 1);
$nextMonths = getNextMonths();

?>
<!DOCTYPE html>
<html lang="fr">
<!--begin::Head-->
<head>
    <base href="../">
    <meta charset="utf-8"/>
    <title>VDMA | Gestion des demandes à traiter</title>
    <meta name="description" content="Updates and statistics"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="canonical" href="https://keenthemes.com/metronic"/>
    <!--begin::Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <!--end::Fonts-->
    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css"/>
    <!--end::Page Vendors Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css"/>
    <?php if (isProd()) { ?>
        <link href="assets/css/style.bundle-prod.css" rel="stylesheet" type="text/css"/>
    <?php } else { ?>
        <link href="assets/css/style.bundle-rec.css" rel="stylesheet" type="text/css"/>
    <?php } ?> <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        .ui-helper-hidden-accessible {
            display: none !important;
        }

        .modal *:not(h5, h3, span, button) {
            font-size: 11px !important;
        }

        input, select {
            height: 26px !important;
        }

        .tt-query {
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        }

        .tt-hint {
            color: #999999;
        }

        .tt-menu {
            background-color: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            margin-top: 12px;
            padding: 8px 0;
            width: 422px;
        }

        .tt-suggestion {
            font-size: 22px; /* Set suggestion dropdown font size */
            padding: 3px 20px;
        }

        .tt-suggestion:hover {
            cursor: pointer;
            background-color: #0097CF;
            color: #FFFFFF;
        }

        .tt-suggestion p {
            margin: 0;
        }

        .twitter-typeahead {
            width: 100%;
        }

        table.dataTable>thead>tr>th:not(.sorting_disabled){
            padding-right:2px;
        }

        .card.card-custom>.card-body, .card-header{
            padding-left:15px;
            padding-right: 15px;
        }

        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto, .col-xxl, .col-xxl-1, .col-xxl-10, .col-xxl-11, .col-xxl-12, .col-xxl-2, .col-xxl-3, .col-xxl-4, .col-xxl-5, .col-xxl-6, .col-xxl-7, .col-xxl-8, .col-xxl-9, .col-xxl-aut{
            padding-left:4px;
            padding-right:4px;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled page-loading">
<!--begin::Main-->
<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile bg-primary header-mobile-fixed">
    <!--begin::Logo-->
    <a href="index.html">
        <!--<img alt="Logo" src="assets/media/logos/logo-bci3.jpg" class="max-h-30px" />-->
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <button class="btn p-0 burger-icon burger-icon-left ml-4" id="kt_header_mobile_toggle">
            <span></span>
        </button>
        <button class="btn p-0 ml-2" id="kt_header_mobile_topbar_toggle">
            <span class="svg-icon svg-icon-xl">
                <!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                     height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon points="0 0 24 0 24 24 0 24"/>
                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                              fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                              fill="#000000" fill-rule="nonzero"/>
                    </g>
                </svg>
                <!--end::Svg Icon-->
            </span>
        </button>
    </div>
    <!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
            <!--begin::Header-->
            <div id="kt_header" class="header flex-column header-fixed">
                <!--begin::Top-->
                <div class="header-top">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Left-->
                        <div class="d-none d-lg-flex align-items-center mr-3">
                            <!--begin::Logo-->
                            <a href="index.php" class="mr-20">
                                <!--<img alt="Logo" src="assets/media/logos/logo.png" class="max-h-35px" />-->
                            </a>
                            <!--end::Logo-->
                            <!--begin::Tab Navs(for desktop mode)-->
                            <?php include('../assets/includes/menu/menu.php'); ?>
                            <!--begin::Tab Navs-->
                        </div>
                        <!--end::Left-->
                        <!--begin::Topbar-->
                        <div class="topbar bg-primary">
                            <div class="topbar bg-primary">
                                <?php include('../assets/includes/page/topbar.php'); ?>
                            </div>
                        </div>
                        <!--end::Topbar-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Top-->
                <!--begin::Bottom-->
                <div class="header-bottom">
                    <!--begin::Container-->
                    <div class="container">
                        <!--begin::Header Menu Wrapper-->
                        <div class="header-navs header-navs-left" id="kt_header_navs">
                            <!--begin::Tab Navs(for tablet and mobile modes)-->
                            <?php include('../assets/includes/menu/menuMobile.php'); ?>
                            <!--begin::Tab Navs-->
                            <!--begin::Tab Content-->
                            <div class="tab-content">
                                <!--begin::Tab Pane-->
                                <?php include('../assets/includes/menu/subMenu.php'); ?>
                                <!--begin::Tab Pane-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Header Menu Wrapper-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Bottom-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container" style="max-width: 100% !important;">
                        <!--begin::Card-->
                        <div class="row" style="height:100%;">
                            <div class="col-lg-5" style="height:100%;">
                                <div class="card card-custom" style="height:100%;">
                                    <div class="card-header flex-wrap">
                                        <div class="card-title">
                                            <h3 class="card-label">Gestion des fiches de renseignement</h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <!--begin::Button-->
                                            <button style="float:right;" type="button"
                                                    class="btn addDemande btn-primary ml-3" data-keyboard="false" data-toggle="modal">
                                                Ajouter une fiche
                                            </button>
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin: Datatable-->
                                        <table class="table table-separate table-head-custom table-checkable table-striped" id="kt_datatable">
                                            <thead>
                                            <tr>
                                                <th style="width:5%;">N°</th>
                                                <th style="width:5%;">Date</th>
                                                <th style="width:5%;">Qui</th>
                                                <th style="width:89%;">Infos</th>
                                                <th style="width:1%; writing-mode: vertical-lr;">Devis</th>
                                                <th style="width:1%; writing-mode: vertical-lr;">à valider</th>
                                                <th style="width:1%; writing-mode: vertical-lr;">Mail</th>
                                                <th style="width:1%; writing-mode: vertical-lr;">Papier</th>
                                                <th style="width:1%; writing-mode: vertical-lr;">Refusés</th>
                                                <th style="width:1%; writing-mode: vertical-lr;">Cdés</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="modDemande">
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--end: Datatable-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7" style="height:100%;">
                                <div class="card card-custom" style="height:100%;">
                                    <div class="card-header flex-wrap">
                                        <div class="card-title">
                                            <h3 class="card-label">Fiche de renseignement</h3>
                                            <small>-</small>&nbsp;<small id="infoFiche"></small>
                                        </div>
                                        <div class="card-toolbar">
                                            <button class="btn btn-danger effaceFiche" disabled>Effacer la fiche</button>&nbsp;<button class="btn btn-primary" disabled>Générer le devis</button>&nbsp;<button class="btn btn-primary" disabled>Transférer le devis</button>
                                        </div>
                                    </div>
                                    <div style="display:none;" class="card-body divDetailFiche">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <form class="form" id="kt_form_demande" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body" style="padding-bottom:5px !important;">
                                                        <div class="form-group row" style="padding-bottom:0px !important; margin-bottom:0px !important;">
                                                            <div class="col-lg-9 pl-5 pr-5">
                                                                <div class="form-group row">
                                                                    <div class="col-lg-12">
                                                                        <h3 class="font-size-lg text-dark font-weight-bold mb-1">Informations générales</h3>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <input data-ceb="numero" id="numero" disabled type="text" value="" class="form-control"
                                                                               name="numero"/>
                                                                        <span class="form-text">N° Fiche</span>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input data-ceb="date_demande" id="datedemande" type="date" class="form-control" name="datedemande" value="" />
                                                                        <span class="form-text">Date demande</span>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <?php

                                                                        echo buildSelectListeTypeDemande($connexion, 'recupar', 'recu_par', '', '', false);

                                                                        ?>
                                                                        <span class="form-text">Reçu par</span>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input data-ceb="date_a_envoyer_pour_le" id="dateaenvoyer" type="date" class="form-control"
                                                                               name="dateaenvoyer" value=""/>
                                                                        <span class="form-text">Devis à envoyer pour le</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-7">
                                                                        <input data-ceb="nom_groupe" id="nomgroupe" type="text" class="form-control champs_client"
                                                                               placeholder="Nom du groupe"
                                                                               name="nomgroupe"/>
                                                                        <span class="form-text text-muted">Nom du groupe</span>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input data-ceb="nom_responsable" id="nom" type="text" class="form-control champs_client" placeholder="Nom"
                                                                               name="nom"/>
                                                                        <span class="form-text">Nom responsable</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <input data-ceb="prenom_responsable" id="prenom" type="text" class="form-control champs_client"
                                                                               placeholder="Prénom" name="prenom"/>
                                                                        <span class="form-text">Prénom responsable</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-4">
                                                                        <input data-ceb="adresse_responsable" id="adresse" type="text" class="form-control champs_client" placeholder="Adresse"
                                                                               name="adresse"/>
                                                                        <span class="form-text text-muted">Adresse</span>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input data-ceb="complement" id="complement" type="text" class="form-control champs_client" placeholder="Complément"
                                                                               name="complement"/>
                                                                        <span class="form-text text-muted">Complément</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <input data-ceb="cp" id="codepostal" type="text" class="form-control champs_client"
                                                                               placeholder="CP" name="codepostal"/>
                                                                        <span class="form-text">Code postal</span>
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <input data-ceb="ville" id="ville" type="text" class="form-control champs_client" placeholder="Ville"
                                                                               name="ville"/>
                                                                        <span class="form-text">Ville</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-2">
                                                                        <input data-ceb="numero_telephone" id="numtel" type="text" class="form-control champs_client"
                                                                               placeholder="Numéro de téléphone" name="numtel"/>
                                                                        <span class="form-text text-muted">Téléphone</span>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <input data-ceb="email" id="email" type="text" class="form-control champs_client" placeholder="Email"
                                                                               name="email"/>
                                                                        <span class="form-text text-mute">Email</span>
                                                                    </div>
                                                                    <div class="col-lg-4">
                                                                        <input data-ceb="email2" id="email2" type="text" class="form-control champs_client" placeholder="Email 2"
                                                                               name="email2"/>
                                                                        <span class="form-text text-mute">Email 2</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-3">
                                                                        <input data-ceb="date_visite" id="datevisite" type="date" class="form-control"
                                                                               name="datevisite"/>
                                                                        <span class="form-text">Date</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <select data-ceb="heure_visite" class="form-control" id="heurevisite" name="heurevisite"></select>
                                                                        <span class="form-text">Heure de la visite</span>
                                                                    </div>
                                                                    <div class="col-lg-1">
                                                                        <!--begin::Switch-->
                                                                        <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                                            <label>
                                                                                <input data-ceb="option" id="option" type="checkbox" name="option" value="1"/>
                                                                                 <span></span>
                                                                            </label>
                                                                        </span>
                                                                        <span class="form-text text-muted">Option</span>
                                                                        <!--end::Switch-->
                                                                    </div>
                                                                    <div class="col-lg-1 text-center">
                                                                        ou
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <select data-ceb="mois_visite" id="mois_visite" class="form-control" name="mois_visite">
                                                                            <option value="">-</option>
                                                                            <?php foreach ($nextMonths as $month): ?>
                                                                                <option value="<?php echo $month['value']; ?>"><?php echo $month['label']; ?></option>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                        <span class="form-text">Mois de la visite</span>
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col-lg-2">
                                                                        <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                                            <label>
                                                                                <input data-ceb="a_envoyer_par_mail" id="envoimail" type="checkbox" name="envoimail" value="1"/>
                                                                                 <span></span>
                                                                            </label>
                                                                        </span>
                                                                        <span class="form-text">À envoyer par mail</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                                            <label>
                                                                                <input data-ceb="a_envoyer_par_courrier" id="envoicourrier" type="checkbox" name="envoicourrier" value="1"/>
                                                                                 <span></span>
                                                                            </label>
                                                                        </span>
                                                                        <span class="form-text">À envoyer par courrier</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        &nbsp;
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                                            <label>
                                                                                <input data-ceb="motobecane" id="motobecane" type="checkbox" name="motobecane" value="1"/>
                                                                                 <span></span>
                                                                            </label>
                                                                        </span>
                                                                        <span class="form-text">Motobécane</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                                            <label>
                                                                                <input data-ceb="metier_dantan" id="metiersdantan" type="checkbox" name="metiersdantan" value="1"/>
                                                                                 <span></span>
                                                                            </label>
                                                                        </span>
                                                                        <span class="form-text">Métiers d'antan</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-2">
                                                                        <input data-ceb="nb_adulte" id="nbadulte" type="text" placeholder="Nombre d'adulte'"
                                                                               class="form-control" name="nbadulte"/>
                                                                        <span class="form-text">Nb d'adulte</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <input data-ceb="nb_enfant" id="nbenfant" type="text" placeholder="Nombre d'enfant'"
                                                                               class="form-control" name="nbenfant"/>
                                                                        <span class="form-text">Nb d'enfant</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <input data-ceb="nb_accompagnateur" id="nbaccompagnateur" type="text"
                                                                               placeholder="Nombre d'accompagnateurs" class="form-control"
                                                                               name="nbaccompagnateur"/>
                                                                        <span class="form-text">nb d'accompagnateur</span>
                                                                    </div>
                                                                    <div class="col-lg-2">
                                                                        <!--begin::Switch-->
                                                                        <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                                            <label>
                                                                                <input data-ceb="pmr" id="pmr" type="checkbox" name="pmr" value="1"/>
                                                                                 <span></span>
                                                                            </label>
                                                                        </span>
                                                                        <span class="form-text text-muted">Accueil PMR demandé</span>
                                                                        <!--end::Switch-->
                                                                    </div>
                                                                    <div class="col-lg-3">
                                                                        <?php

                                                                        echo buildSelectListeSpecificitesGroupeDemande($connexion, 'specificite', 'specificite', '', '', false);

                                                                        ?>
                                                                        <span class="form-text text-mute">Spécificité du groupe</span>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row">
                                                                    <div class="col-lg-12">
                                                                        <h3 class="font-size-lg text-dark font-weight-bold mb-1">Prestations complémentaires</h3>
                                                                    </div>
                                                                    <?php

                                                                    foreach($arrayPresationFiche as $keyPF => $valPF){
                                                                        echo '<div class="col-lg-1">
                                                                            <!--begin::Switch-->
                                                                            <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                                                <label>
                                                                                    <input data-id="'.$keyPF.'" class="prestationcomplementaire" type="checkbox" value="1"/>
                                                                                     <span></span>
                                                                                </label>
                                                                            </span>
                                                                            <!--end::Switch-->
                                                                        </div>
                                                                        <div class="col-lg-11 pt-1">
                                                                            <span class="font-size-sm">'.$valPF['designationSimple'].' - '.$valPF['prixTtc'].' €</span>
                                                                        </div>
                                                                        ';
                                                                    }

                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <textarea data-ceb="commentaires" id="commentaires" style="height:80%;" class="form-control" placeholder="Commentaires"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="divEnregistrementReussi row" style="display:none;position:absolute;bottom:0px;width: 100%;">
                                            <div class=" col-lg-12">
                                                <div class="alert alert-success">
                                                    Enregistrement réussi
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divEnregistrementErreur row" style="display:none;position:absolute;bottom:0px;width: 100%;">
                                            <div class=" col-lg-12">
                                                <div class="alert alert-success">
                                                    Echec enregistrement
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body btnAddFiche">
                                        <div class="row" style="width:100%; height: 100%;">
                                            <div class="col-lg-12" style="width:100%; height: 100%;">
                                                <button style="width:100%; height: 100%;" class="addDemande btn btn-primary">Ajouter une fiche</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card-->
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer bg-white py-1 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">2024©</span>
                        <a href="https://www.village-metiers-dantan.fr/" target="_blank"
                           class="text-dark-75 text-hover-primary">VDMA</a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Nav-->
                    <div class="nav nav-dark order-1 order-md-2">
                        <a href="https://help.act-cs.fr" target="_blank" class="nav-link pl-3 pr-0">Support ACT-CS</a>
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->
<!-- begin::User Panel-->
<?php include('../assets/includes/page/sidebar.php'); ?>
<!-- end::User Panel-->
<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop">
    <span class="svg-icon">
        <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Up-2.svg-->
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
             viewBox="0 0 24 24" version="1.1">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <polygon points="0 0 24 0 24 24 0 24"/>
                <rect fill="#000000" opacity="0.3" x="11" y="10" width="2" height="10" rx="1"/>
                <path d="M6.70710678,12.7071068 C6.31658249,13.0976311 5.68341751,13.0976311 5.29289322,12.7071068 C4.90236893,12.3165825 4.90236893,11.6834175 5.29289322,11.2928932 L11.2928932,5.29289322 C11.6714722,4.91431428 12.2810586,4.90106866 12.6757246,5.26284586 L18.6757246,10.7628459 C19.0828436,11.1360383 19.1103465,11.7686056 18.7371541,12.1757246 C18.3639617,12.5828436 17.7313944,12.6103465 17.3242754,12.2371541 L12.0300757,7.38413782 L6.70710678,12.7071068 Z"
                      fill="#000000" fill-rule="nonzero"/>
            </g>
        </svg>
        <!--end::Svg Icon-->
    </span>
</div>
<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#6993FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#F3F6F9",
                    "dark": "#212121"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1E9FF",
                    "secondary": "#ECF0F3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#212121",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#ECF0F3",
                "gray-300": "#E5EAEE",
                "gray-400": "#D6D6E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#80808F",
                "gray-700": "#464E5F",
                "gray-800": "#1B283F",
                "gray-900": "#212121"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="assets/plugins/global/plugins.bundle.js"></script>
<script src="assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="assets/js/scripts.bundle.js"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="assets/js/pages/widgets.js"></script>
<script src="assets/js/pages/fiches/main.js"></script>
<script src="assets/js/pages/global.js"></script>
<script src="assets/plugins/global/jquery-ui-1.13.0/jquery-ui.min.js"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>