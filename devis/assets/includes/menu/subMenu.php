<div class="tab-pane py-5 p-lg-0 show" id="kt_header_tab_1">
    <!--begin::Menu-->
    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
        <!--begin::Nav-->
        <ul class="menu-nav">
            <?php if (getDroitsPage($connexion, 'tableaudebord', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="dashboard menu-item" aria-haspopup="true">
                    <a href="./admin/index.php" class="menu-link">
                        <span class="menu-text">Tableau de bord</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (getDroitsPage($connexion, 'fichesrenseignement', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="fichesrenseignement menu-item" aria-haspopup="true">
                    <a href="./admin/fichesrenseignement.php" class="menu-link">
                        <span class="menu-text">Fiches de renseignement/Devis</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (getDroitsPage($connexion, 'validedevis', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="validedevis menu-item" aria-haspopup="true">
                    <a href="./admin/validedevis.php" class="menu-link">
                        <span class="menu-text">Validation devis</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <!--end::Nav-->
    </div>
    <!--end::Menu-->
</div>
<!--begin::Tab Pane-->
<div class="tab-pane py-5 p-lg-0 show" id="kt_header_tab_2">
    <!--begin::Menu-->
    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
        <!--begin::Nav-->
        <ul class="menu-nav">
            <?php if (getDroitsPage($connexion, 'clients', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="clients menu-item" aria-haspopup="true">
                    <a href="./admin/clients.php" class="menu-link">
                        <span class="menu-text">Clients/Prospects</span>
                    </a>
                </li>
            <?php } ?>
            <?php /*if (getDroitsPage($connexion, 'touslesclients', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="touslesclients menu-item" aria-haspopup="true">
                    <a href="./admin/touslesclients.php" class="menu-link">
                        <span class="menu-text">Tous les clients</span>
                    </a>
                </li>
            <?php }*/ ?>
        </ul>
        <!--end::Nav-->
    </div>
    <!--end::Menu-->
</div>
<div class="tab-pane py-5 p-lg-0 show" id="kt_header_tab_3">
    <!--begin::Menu-->
    <div id="kt_header_menu" class="header-menu header-menu-mobile header-menu-layout-default">
        <!--begin::Nav-->
        <ul class="menu-nav">
            <?php if (getDroitsPage($connexion, 'utilisateurs', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="utilisateurs menu-item" aria-haspopup="true">
                    <a href="./admin/utilisateurs.php" class="menu-link">
                        <span class="menu-text">Utilisateurs</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (getDroitsPage($connexion, 'prestations', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="prestations menu-item" aria-haspopup="true">
                    <a href="./admin/prestations.php" class="menu-link">
                        <span class="menu-text">Prestations</span>
                    </a>
                </li>
            <?php } ?>
            <?php if (getDroitsPage($connexion, 'exercices', $_SESSION['user']['typeutilisateur'])) { ?>
                <li class="exercices menu-item" aria-haspopup="true">
                    <a href="./admin/exercices.php" class="menu-link">
                        <span class="menu-text">Exercices</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <!--end::Nav-->
    </div>
    <!--end::Menu-->
</div>