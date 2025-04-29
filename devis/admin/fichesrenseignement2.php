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

$exerciceencours = $_SESSION['anneeExercice'];

$arrayDemandes = getDemandes($connexion, '0', $exerciceencours);

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

        .card.card-custom>.card-body, .card-header{
            padding-left:15px;
            padding-right: 15px;
        }

        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto, .col-xxl, .col-xxl-1, .col-xxl-10, .col-xxl-11, .col-xxl-12, .col-xxl-2, .col-xxl-3, .col-xxl-4, .col-xxl-5, .col-xxl-6, .col-xxl-7, .col-xxl-8, .col-xxl-9, .col-xxl-aut{
            padding-left:4px;
            padding-right:4px;
        }

        table.dataTable>thead>tr>th:not(.sorting_disabled){
            padding-right:2px;
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
                                            <button style="float:right;" id="addDemande" type="button"
                                                    class="btn btn-primary ml-3" data-keyboard="false" data-toggle="modal">
                                                Ajouter une fiche
                                            </button>
                                            <!--end::Button-->
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <!--begin: Datatable-->
                                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                                            <thead>
                                            <tr>
                                                <th style="width:5%;">N°</th>
                                                <th style="width:5%;">Date</th>
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
                                                <td>00001</td>
                                                <td>23/05/2024</td>
                                                <td>Société ACT-CS - Didier REMOUSSENARD - 07 77 06 74 40<br />3 participants</td>
                                                <td><div style="width:15px;height:15px; background-color:red;"</td>
                                                <td><div style="width:15px;height:15px; background-color:red;"</td>
                                                <td><div style="width:15px;height:15px; background-color:red;"</td>
                                                <td><div style="width:15px;height:15px; background-color:red;"</td>
                                                <td><div style="width:15px;height:15px; background-color:red;"</td>
                                                <td><div style="width:15px;height:15px; background-color:red;"</td>
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
                                            <h3 class="card-label">Informations - <small>Fiche réalisée par Didier le 27/05/2024 - En attente d'envoi</small></h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <button class="btn btn-primary">Imprimer le devis</button>&nbsp;<button class="btn btn-primary">Envoyer le devis</button>&nbsp;<button class="btn btn-primary">Transférer le devis au responsable</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-9" style="background-color:#e4e4e4;">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><b>N° fiche :</b> 00001</td>
                                                        <td><b>Date de la demande :</b> 28/05/2024</td>
                                                        <td colspan="2"><b>Reçu par :</b> Téléphone</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"><b>Contact groupe :</b><br />Société ACT-CS - Jean Hugo - 03 83 56 56 56 - d.remoussenard@act-cs.fr - 293 avenue de la libération 54000 Nancy</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Date de la visite :</b> 10/06/2024 (pas d'option)</td>
                                                        <td colspan="2"><b>Devis pour le :</b> 01/06/2024 (envoi par mail)</td>
                                                        <td colspan="2">Musée motobécane</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"><b>Participants :</b> Comité d'entreprise - 3 adulte(s) + 5 enfant(s) + 1 accompagnateur (pas d'accueil PMR)</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"><b>Prestations complémentaires :</b> Location salle de réception, Pause gourmande</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-lg-3">
                                                <textarea style="height:100%;" class="form-control" placeholder="Commentaire"></textarea>
                                            </div>
                                            <div class="col-lg-12 pl-4 pr-4">
                                                <div class="mt-2 col-md-12">
                                                    <div class="form-group row">
                                                        <div class="col-lg-12">
                                                            <h3 class="font-size-lg text-dark font-weight-bold mb-1">Descriptif du devis</h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-7">
                                                            <?php

                                                            echo buildSelectPrestations($connexion, 'prestations', '', true);

                                                            ?>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <button class="addPrestation btn btn-primary">+</button>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <button class="float-right addPrestationVide btn btn-primary">+ commentaire</button>
                                                        </div>
                                                    </div>
                                                    <div style="" class="mt-2 form-group row">
                                                        <div class="col-lg-12">
                                                            <table class="table table-bordered table-collapse">
                                                                <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Désignation</th>
                                                                    <th>Qté</th>
                                                                    <th>Montant</th>
                                                                    <th>TVA</th>
                                                                    <th>Total</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="listePrestations">
                                                                    <tr class="lignePrestation">
                                                                        <td style="vertical-align: middle; width:90px;"><i class="fa fa-arrows-alt"></i></td>
                                                                        <td style="vertical-align: middle; width:1000px;"><textarea rows="1" style="" class="form-control modDesignation" data-cle="0">Entrée(s) adulte(s)</textarea></td>
                                                                        <td style="vertical-align: middle; width: 60px;"><input style="width:50px;" type="number" min="1" step="1" value="30" class="form-control modQte" data-cle="0"></td>
                                                                        <td style="vertical-align: middle; width:60px;">10,00</td>
                                                                        <td style="vertical-align: middle; width:70px;">10%</td>
                                                                        <td class="montanttotalprestation" data-cle="0" style="text-align:right; vertical-align: middle; width:41px;">300,00&nbsp;€</td>
                                                                        <td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="0" class="deletePrestation">X</td>
                                                                    </tr>
                                                                    <tr class="lignePrestation">
                                                                        <td style="vertical-align: middle; width:90px;"><i class="fa fa-arrows-alt"></i></td>
                                                                        <td style="vertical-align: middle; width:1000px;"><textarea rows="1" style="" class="form-control modDesignation" data-cle="0">Location salle - journée (de 26 à 70)</textarea></td>
                                                                        <td style="vertical-align: middle; width: 60px;"><input style="width:50px;" type="number" min="1" step="1" value="1" class="form-control modQte" data-cle="0"></td>
                                                                        <td style="vertical-align: middle; width:60px;">195,00</td>
                                                                        <td style="vertical-align: middle; width:70px;">10%</td>
                                                                        <td class="montanttotalprestation" data-cle="0" style="text-align:right; vertical-align: middle; width:41px;">195,00&nbsp;€</td>
                                                                        <td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="0" class="deletePrestation">X</td>
                                                                    </tr>
                                                                    <tr class="lignePrestation">
                                                                        <td style="vertical-align: middle; width:90px;"><i class="fa fa-arrows-alt"></i></td>
                                                                        <td colspan="5" style="vertical-align: middle; width:1000px;"><textarea rows="1" style="" class="form-control modDesignation" data-cle="0">Merci de vous présenter 30 minutes avant l'heure prévue.</textarea></td>
                                                                        <td style="cursor:pointer; text-align:center; background-color:red; color:white; vertical-align: middle; width:2%;" data-cle="0" class="deletePrestation">X</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="position:absolute;bottom:0px;width: 100%;">
                                            <div class="col-lg-12">
                                                <table class="tableTotaux table table-bordered table-collapse">
                                                    <tr>
                                                        <td class="font-weight-bold" style="vertical-align: middle;">TVA 0%</td>
                                                        <td class="font-weight-bold" style="vertical-align: middle;">TVA 5.5%</td>
                                                        <td class="font-weight-bold" style="vertical-align: middle;">TVA 10%</td>
                                                        <td class="font-weight-bold" style="vertical-align: middle;">TVA 20%</td>
                                                        <td class="font-weight-bold" style="vertical-align: middle;">Total TTC €</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align: middle;"><span data-tva="0" class="totalTVA">0,00</span></td>
                                                        <td style="vertical-align: middle;"><span data-tva="5.5" class="totalTVA">0,00</span></td>
                                                        <td style="vertical-align: middle;"><span data-tva="10" class="totalTVA">49,50</span></td>
                                                        <td style="vertical-align: middle;"><span data-tva="20" class="totalTVA">0,00</span></td>
                                                        <td style="vertical-align: middle;"><span class="totalTTC">495,00</span></td>
                                                    </tr>
                                                </table>
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
            <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
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