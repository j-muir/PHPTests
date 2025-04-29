<?php

session_start();
if (!isset($_SESSION['user']['login'])) {
    header('Location: ../');
}

include('../assets/includes/connexion.php');
include('../assets/includes/fonctions/fonctionsgeneral.php');

$equipes = getAllEquipes($connexion);

?>

<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<!--begin::Head-->
<head>
    <base href="../">
    <meta charset="utf-8"/>
    <title>VDMA | Gestion du planning</title>
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
        .modal *:not(h5, h3, span, button) {
            font-size: 11px !important;
        }

        .card-header {
            padding: 0.2rem 0.25rem !important;
        }

        .header-bottom {
            display: none !important;
        }

        .header-fixed.header-bottom-enabled .wrapper {
            padding-top: 55px !important;
        }

        .header-fixed.header-bottom-enabled .header {
            height: 45px;
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
        <!--        <img alt="Logo" src="assets/media/logos/logo-bci3.jpg" class="max-h-30px"/>-->
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
                                <!--<img alt="Logo" src="assets/media/logos/logo-letter-9.png" class="max-h-35px" />-->
                            </a>
                            <!--end::Logo-->
                            <!--begin::Tab Navs(for desktop mode)-->
                            <?php include('../assets/includes/menu/menu.php'); ?>
                            <!--begin::Tab Navs-->
                        </div>
                        <!--end::Left-->
                        <!--begin::Topbar-->
                        <div class="topbar bg-primary">
                            <?php include('../assets/includes/page/topbar.php'); ?>
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
                    <div class="container" style="max-width:1900px;">
                        <!--begin::Card-->
                        <div class="row">
                            <div class="col-3">
                                <div class="card card-custom" style="height:120px;">
                                    <div style="border:0px;" class="card-header flex-wrap py-1">
                                        <div class="card-title">
                                            <h3 class="card-label">Intervention hors commande</h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <button id="boutonplanifierHors"
                                                    class="boutonplanifierHors btn btn-success">Appliquer
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding: 0.2rem 0.25rem;">
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea id="remarquehors" type="text"
                                                          style="height: 50px; resize: none;width: 100%"
                                                          placeholder="Description intervention hors commande"
                                                          rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mt-2" style="height:120px;">
                                    <div style="border:0px;" class="card-header flex-wrap py-1">
                                        <div class="card-title">
                                            <h3 class="card-label">Remarques<span style="font-size:11px !important"
                                                                                  id="remarquecommandeselectionnee"></span>
                                            </h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <button id="boutonremarque" class="btn btn-success">Appliquer</button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding: 0.2rem 0.25rem;">
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea id="remarque" type="text"
                                                          style="height: 50px; resize: none;width: 100%"
                                                          placeholder="Remarques" rows="2" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mt-2" style="height:330px;">
                                    <div style="border:0px;min-height:80px;" class="card-header flex-wrap py-1">
                                        <div class="card-title">
                                            <h3 style="margin:0px;" class="card-label"><small style="color:black;">A
                                                    facturer (<span id="nbcommandesaplanifier">0</span>)</small></h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <input id="searchCommande" style="width:20%;" type="text"
                                                   placeholder="Rechercher"/>
                                            <button data-idcommande='' id="boutonplanifierAP"
                                                    class="boutonplanifier btn btn-success mx-1">Appliquer
                                            </button>
                                            <button data-idcommande='' id="boutonplanifierfacturerAP"
                                                    class="boutonplanifierfacturer btn btn-success mx-1">Appliquer et
                                                prêt à facturer
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body nonplanifiees"
                                         style="padding: 0.2rem 0.25rem; max-height:340px;overflow-y:scroll;">
                                        <div style="width:100%;margin:0;" class="row">
                                            <div style="padding:0;" class="col-12">
                                                <table style="width:100%;" class="table table-striped">
                                                    <tbody class="lescommandesaplanifier">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-custom mt-2" style="height:330px;">
                                    <div style="border:0px;min-height:80px;" class="card-header flex-wrap py-1">
                                        <div class="card-title">
                                            <h3 style="margin:0px;" class="card-label"><small style="color:black;">Prêt
                                                    à facturer (<span id="nbcommandesplanifiees">0</span>)</small></h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <input type="text" style="width:20%;" placeholder="Rechercher"
                                                   id="searchCommandeFacturee"/>
                                            <button data-idcommande='' id="boutonplanifierP"
                                                    class="boutonplanifier btn btn-success mx-1">Appliquer et passer à
                                                facturer
                                            </button>
                                            <button data-idcommande='' id="boutonplanifierfacturerP"
                                                    class="boutonplanifierfacturer btn btn-success mx-1">Appliquer
                                            </button>
                                        </div>
                                    </div>
                                    <div class="planifiees card-body"
                                         style="padding: 0.2rem 0.25rem; max-height:340px; overflow-y:scroll;">
                                        <div style="width:100%;margin:0;" class="row">
                                            <div style="padding:0;" class="col-12">
                                                <table style="width:100%;" class="table table-striped">
                                                    <tbody class="lescommandesplanifiees">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div style="height:100%;" class="card card-custom">
                                    <div style="border:0px;" class="card-header flex-wrap py-1">
                                        <div class="card-title">
                                            <h3 class="card-label">Planning - Semaine <span class="numSemaine"></span> -
                                                <span style="color:red;">Total : <span
                                                            class="totalMultiEquipe">&mdash;€</span></span></h3>
                                        </div>
                                        <div class="card-toolbar">
                                            <button id="imprimerplaning" class="btn btn-primary">Imprimer le planning
                                            </button>
                                        </div>
                                        <div class="card-toolbar">
                                            <button data-week="" class="previousWeek btn btn-primary">Semaine
                                                précédente
                                            </button>&nbsp;<button data-week="" class="currentWeek btn btn-primary">
                                                Semaine en cours
                                            </button>&nbsp;<button data-week="" class="nextWeek btn btn-primary">Semaine
                                                suivante
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding: 0.2rem 0.25rem;">
                                        <table style="width:100%; height:100%;" class="table">
                                            <tr>
                                                <td></td>
                                                <?php
                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td class="text-center font-weight-bold">
                                                        <table style="height:100%;width:100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="border:0px;">' . $equipe['nom'] . '</td>
        
                                                                    <td style="width:25%;border:0px;" class="align-middle text-right"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>';
                                                }
                                                ?>

                                            </tr>
                                            <tr style="height:8.33%;">
                                                <td rowspan="2" style="width:10%;" class="font-weight-bold">Lundi <span
                                                            class="dateJour" data-numerojour="0">28/02</span></td>
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td style="width:30%">
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="0" data-partiejournee="am" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td style="width:30%">
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="0" data-partiejournee="pm" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <td rowspan="2" class="font-weight-bold">Mardi <span class="dateJour"
                                                                                                     data-numerojour="1">28/02</span>
                                                </td>
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="1" data-partiejournee="am" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="1" data-partiejournee="pm" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <td rowspan="2" class="font-weight-bold">Mercredi <span class="dateJour"
                                                                                                        data-numerojour="2">28/02</span>
                                                </td>
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="2" data-partiejournee="am" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="2" data-partiejournee="pm" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <td rowspan="2" class="font-weight-bold">Jeudi <span class="dateJour"
                                                                                                     data-numerojour="3">28/02</span>
                                                </td>
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="3" data-partiejournee="am" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="3" data-partiejournee="pm" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <td rowspan="2" class="font-weight-bold">Vendredi <span class="dateJour"
                                                                                                        data-numerojour="4">28/02</span>
                                                </td>
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="4" data-partiejournee="am" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="4" data-partiejournee="pm" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <td rowspan="2" class="font-weight-bold">Samedi <span class="dateJour"
                                                                                                      data-numerojour="5">28/02</span>
                                                </td>
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="5" data-partiejournee="am" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr style="height:8.33%;">
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td>
                                                        <table style="height:100%;width:100%;">
                                                            <tr class="ligneplanification" data-idcommande="" data-date="" data-numerojour="5" data-partiejournee="pm" data-idequipe="' . $idequipe . '">
                                                                <td class="borderselect1" style="border:0px;background-color:#f1f1f1;">
                                                                </td>
                                                                <td style="width:5%;border:0px;background-color:#f1f1f1;" class="borderselect2 align-middle infoscommande"></td>
                                                                <td style="width:8%;border:0px;background-color:#f1f1f1;" class="borderselect3 align-middle"><input class="checkboxplanification form-control" style="height:20px;" type="checkbox" /></td>
                                                                <td style="width:25%;border:0px;" class="align-middle font-weight-bold text-right text-danger"></td>
                                                            </tr>
                                                        </table>
                                                    </td>';
                                                }

                                                ?>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <?php

                                                foreach ($equipes as $idequipe => $equipe) {
                                                    echo
                                                        '<td class="text-center font-weight-bold">
                                                        <table style="height:100%;width:100%;">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="border:0px;"></td>
                                                                    <td style="width:25%;border:0px;" class="align-middle text-right text-danger"><span data-equipe="' . $idequipe . '" class="totalSemaine">&mdash;€</span></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>';
                                                }
                                                ?>
                                            </tr>
                                        </table>
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
            <!-- Modal -->
            <?php
            $modifiable = false;
            include('../assets/includes/page/modalecommande.php');
            include('../assets/includes/page/modaleclient.php');
            ?>
            <!-- End modal -->
            <!-- Start Toast -->
            <?php
            include('../assets/includes/page/toasts.php');
            ?>
            <!-- End Toast -->
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
</div><!--end::Main-->
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
<script src="assets/plugins/custom/datatables/datatables.bundle.js">
</script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="assets/js/pages/widgets.js"></script>
<script src="assets/js/pages/modaleclient/main.js"></script>
<script src="assets/js/pages/modalecommande/main.js"></script>
<script src="assets/js/pages/planning/main.js"></script>
<script src="assets/js/pages/global.js"></script>
<script src="assets/plugins/global/jquery-ui-1.13.0/jquery-ui.min.js"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>