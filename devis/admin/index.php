<?php

session_start();
if (!isset($_SESSION['user']['login'])) {
    header('Location: ../');
}

include('../assets/includes/connexion.php');
include('../assets/includes/fonctions/fonctionsgeneral.php');

?>
<!DOCTYPE html>
<html lang="fr">
<!--begin::Head-->
<head>
    <base href="../">
    <meta charset="utf-8"/>
    <title>VDMA | Accueil</title>
    <meta name="description" content="Updates and statistics"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="canonical" href="https://keenthemes.com/metronic"/>
    <!--begin::Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <!--end::Fonts-->

    <!--begin::Page Vendors Styles(used by this page)-->
    <link href="assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css"/>
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
                    <div class="container">
                        <!--begin::Card-->
                        <div class="card card-custom">
                            <div class="card-header flex-wrap" style="min-height: 0;">
                                <div class="card-title">
                                    <h3 class="card-label">Tableau de bord</h3>
                                </div>
                                <div class="card-toolbar">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-lg-4">
                                        <div style="cursor:pointer;" data-search="" class="filterTable card card-custom bg-radial-gradient-warning card-shadowless gutter-b text-white">
                                            <div class="card-body text-center">
                                                <span class="card-title font-weight-bolder text-hover-state-dark d-block" style="font-size: 1.1em; margin-bottom: 0;">Demandes à envoyer prochainement</span>
                                                <span class="card-text text-dark font-weight-bolder mr-2" style="font-size:2.5em">5</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div style="cursor:pointer;" data-search="" class="filterTable card card-custom bg-radial-gradient-success card-shadowless gutter-b text-white">
                                            <div class="card-body text-center">
                                                <span class="card-title font-weight-bolder text-hover-state-dark d-block" style="font-size: 1.1em; margin-bottom: 0;">Devis en cours</span>
                                                <span class="card-text text-dark font-weight-bolder mr-2" style="font-size:2.5em">10</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div style="cursor:pointer;" data-search="" class="filterTable card card-custom bg-radial-gradient-warning card-shadowless gutter-b text-white">
                                            <div class="card-body text-center">
                                                <span class="card-title font-weight-bolder text-hover-state-dark d-block" style="font-size: 1.1em; margin-bottom: 0;">Devis à relancer</span>
                                                <span class="card-text text-dark font-weight-bolder mr-2" style="font-size:2.5em">10</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-custom mt-3 mb-5">
                            <div class="card-header flex-wrap" style="min-height: 0;">
                                <div class="card-title">
                                    <h3 class="card-label">Planning des groupes</h3>
                                </div>
                                <div class="card-toolbar">
                                </div>
                            </div>
                            <div class="card-body">
                                <div style="height:100%;" id="calendar">

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
            <!-- Modal -->
            <?php
            $modifiable = true;
            include('../assets/includes/page/modalecommande.php');
            ?>
            <!-- End modal -->
            <!-- Modal -->
            <?php
            include('../assets/includes/page/modaleclient.php');
            ?>
            <!-- End modal -->
            <!-- Start Toast -->
            <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999; right: 0; bottom: 0;">
                <div id="liveToastDeletePrestation" class="toast hide" role="alert" aria-live="assertive"
                     aria-atomic="true" data-delay="2000">
                    <div class="toast-header bg-warning">
                        <strong class="mr-auto">Suppression d'une prestation</strong>
                        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        Pour supprimer une prestation, la quantité doit être à 0.
                    </div>
                </div>
            </div>
            <!-- End Toast -->
            <!-- Start Toast -->
            <?php
            include('../assets/includes/page/toasts.php');
            ?>
            <!-- End Toast -->
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
				<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                     height="24px" viewBox="0 0 24 24" version="1.1">
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
<script>var KTAppSettings = {"breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200},
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
<script src="https://cdn.datatables.net/plug-ins/1.11.3/sorting/natural.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/serial.js"></script>
<script type="text/javascript" src="https://www.amcharts.com/lib/3/themes/light.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="assets/js/pages/widgets.js"></script>
<script src="assets/js/pages/modaleclient/main.js"></script>
<script src="assets/js/pages/modalecommande/main.js"></script>
<script src="assets/js/pages/dashboard/main.js"></script>
<script src="assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="assets/plugins/global/jquery-ui-1.13.0/jquery-ui.min.js"></script>
<script>
    jQuery(document).ready(function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'fr',
            plugins: ['dayGrid'],
            defaultView: 'dayGridMonth'
        });

        calendar.render();

        var table = $('#kt_datatable');

        // begin first table
        var datatable = table.DataTable({
            order: [[6, "desc"], [1, "desc"]],
            responsive: true,
            paging: true,
            iDisplayLength: 100,
            dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
            buttons: [
                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5]
                    }
                }
            ],
            language: {
                url: './assets/json/dataTable_french.json'
            },
            columnDefs: [
                {
                    "targets": 2,
                    "orderable": false
                },
                {
                    type: 'num',
                    targets: [5],
                    className: 'text-right'
                }
            ]
        });

        $('#kt_datatable thead tr').clone(true).appendTo('#kt_datatable thead');
        $('#kt_datatable thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            if (title != '' && title != "Etat") {
                $(this).html('<input type="text" class="form-control" placeholder="Rechercher par ' + title + '" />');

                $('input', this).on('keyup change', function () {
                    if (datatable.column(i).search() !== this.value) {
                        datatable
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            } else {
                $(this).html('');
            }
        });

        $('#kt_datatable_search_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $(".filterTable").click(function () {
            let search = $(this).attr('data-search');
            datatable.search(search).draw();
        });
    });


</script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>