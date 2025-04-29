<ul class="header-tabs nav align-self-end font-size-lg" role="tablist">
    <!--begin::Item-->
    <?php if (getDroitsPage($connexion, 'accueil', $_SESSION['user']['typeutilisateur'])) { ?>
        <li class="nav-item mr-3 accueil">
            <a href="./admin/index.php" class="nav-link py-4 px-6">Accueil</a>
        </li>
    <?php } ?>
    <!--end::Item-->
    <!--begin::Item-->
    <?php if (getDroitsPage($connexion, 'clients', $_SESSION['user']['typeutilisateur'])) { ?>
        <li class="nav-item mr-3 personne">
            <a href="./admin/clients.php" class="nav-link py-4 px-6">Clients/Prospects</a>
        </li>
    <?php } ?>
    <!--end::Item-->
    <!--begin::Item-->
    <?php if (getDroitsPage($connexion, 'utilisateurs', $_SESSION['user']['typeutilisateur'])) { ?>
        <li class="nav-item mr-3 parametres">
            <a href="./admin/utilisateurs.php" class="nav-link py-4 px-6">Paramètres</a>
        </li>
    <?php } ?>
    <!--end::Item-->
    <!--begin::Item-->
    <li class="nav-item mr-3">
        <a target="_blank" href="https://help.act-cs.fr" class="nav-link py-4 px-6">Support</a>
    </li>
    <!--end::Item-->
</ul>