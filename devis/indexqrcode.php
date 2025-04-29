<?php

include('./assets/includes/fonctions/fonctionsgeneral.php');

/*$key = 'keycryptvdmaactcs54gestionticket'; // Clé de 256 bits (32 caractères)
$data = 'g.hochlander@act-cs.fr||123456';

$encrypted = encrypt($data, $key);
echo "Encrypted: " . $encrypted . "\n";*/

$qrcode = '';
if(isset($_GET['q'])){
    $qrcode = $_GET['q'];
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>VDMA | Connexion à votre interface privée</title>
    <meta name="description" content="Login page example" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://keenthemes.com/metronic" />
    <!--begin::Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="./assets/css/pages/login/login.css" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="./assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="./assets/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
    <?php if(isProd()){ ?>
        <link href="assets/css/style.bundle-prod.css" rel="stylesheet" type="text/css" />
    <?php } else { ?>
        <link href="assets/css/style.bundle-rec.css" rel="stylesheet" type="text/css" />
    <?php }?>
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="./assets/media/logos/favicon.ico" />
    <style>
        @media screen and (max-width: 1280px) {
            .logoMain {
                display:none;
            }
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled subheader-enabled page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <?php if(isProd()){ ?>
        <div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(./assets/media/bg/bg-5.jpg);">
            <?php } else { ?>
            <div class="login-aside d-flex flex-row-auto bgi-size-cover bgi-no-repeat p-10 p-lg-10" style="background-image: url(./assets/media/bg/bg-12.jpg);">
                <?php }?>
                <!--begin: Aside Container-->
                <div class="d-flex flex-row-fluid flex-column justify-content-between">
                    <!--begin: Aside header-->
                    <a href="#" class="logoMain flex-column-auto mt-5 pb-lg-0 pb-10">
                        <img src="./assets/media/logos/logo.png" style="width:100%;" alt="" />
                    </a>
                    <!--end: Aside header-->
                    <!--begin: Aside content-->
                    <div class="flex-column-fluid d-flex flex-column justify-content-center">
                        <h3 class="font-size-h1 mb-5 text-white">Bienvenue sur devis VDMA !</h3>
                        <p class="font-weight-lighter text-white opacity-80">le logiciel de gestion des devis pour VDMA.</p>
                    </div>
                    <!--end: Aside content-->
                    <!--begin: Aside footer for desktop-->
                    <div class="d-none flex-column-auto d-lg-flex justify-content-between mt-10">
                        <div class="opacity-70 font-weight-bold text-white">© 2024 VDMA</div>
                        <div class="d-flex">
                            <a target="_blank" href="https://help.act-cs.fr" class="text-white ml-10">Support ACT-CS</a>
                        </div>
                    </div>
                    <!--end: Aside footer for desktop-->
                </div>
                <!--end: Aside Container-->
            </div>
            <!--begin::Aside-->
            <!--begin::Content-->
            <div class="d-flex flex-column flex-row-fluid position-relative p-7 overflow-hidden">
                <!--begin::Content header-->
                <div class="position-absolute top-0 right-0 text-right mt-5 mb-15 mb-lg-0 flex-column-auto justify-content-center py-5 px-10">
                    <!--<span class="font-weight-bold text-dark-50">Dont have an account yet?</span>
                    <a href="javascript:;" class="font-weight-bold ml-2" id="kt_login_signup">Sign Up!</a>-->
                </div>
                <!--end::Content header-->
                <!--begin::Content body-->
                <div class="d-flex flex-column-fluid flex-center mt-30 mt-lg-0">
                    <!--begin::Signin-->
                    <div class="login-form login-signin">
                        <div class="text-center mb-10 mb-lg-20">
                            <h3 class="font-size-h1">Connexion</h3>
                            <p class="text-muted font-weight-bold">Scannez votre QR Code</p>
                        </div>
                        <!--begin::Form-->
                        <form class="form" novalidate="novalidate" id="kt_login_signin_form">
                            <div class="form-group">
                                <input id="qrcode" value="<?php echo $qrcode; ?>" class="form-control form-control-solid h-auto py-5 px-6" type="text" placeholder="Scannez votre qrcode" name="qrcode" autocomplete="off" />
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Signin-->
                </div>
                <!--end::Content body-->
                <!--begin::Content footer for mobile-->
                <div class="d-flex d-lg-none flex-column-auto flex-column flex-sm-row justify-content-between align-items-center mt-5 p-5">
                    <div class="text-dark-50 font-weight-bold order-2 order-sm-1 my-2">© 2024 VDMA</div>
                    <div class="d-flex order-1 order-sm-2 my-2">
                        <a target="_blank" href="https://help.act-cs.fr" class="text-dark-75 text-hover-primary ml-4">Support ACT-CS</a>
                    </div>
                </div>
                <!--end::Content footer for mobile-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
    <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
    <!--begin::Global Config(global config for global JS scripts)-->
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="./assets/plugins/global/plugins.bundle.js"></script>
    <script src="./assets/plugins/custom/prismjs/prismjs.bundle.js"></script>
    <script src="./assets/js/scripts.bundle.js"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="./assets/js/pages/login/login-general-qrcode.js"></script>
    <!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>