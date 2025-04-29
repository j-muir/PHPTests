<div class="d-flex align-items-center mt-5">
    <div class="symbol symbol-100 mr-5">
        <div class="symbol-label" id="photoAdmin"></div>
        <i class="symbol-badge bg-success"></i>
    </div>
    <div class="d-flex flex-column">
        <a href="#" class="font-weight-bold font-size-h5 text-dark-75 text-hover-primary"><?php echo $_SESSION['user']['prenom'].' '.$_SESSION['user']['nom']; ?></a>
        <div class="text-muted mt-1"><?php echo $_SESSION['user']['fonction']; ?></div>
        <div class="navi mt-2">
            <a href="../logout.php" class="btn btn-sm btn-light-primary font-weight-bolder py-2 px-5">Se déconnecter</a>
        </div>
    </div>
</div>
<div class="separator separator-dashed mt-8 mb-5"></div>
<div class="mb-5">
    <div class="row listeAdmin">

    </div>
</div>
<!--<div class="separator separator-dashed mt-8 mb-5"></div>-->
<!--<div class="navi navi-spacer-x-0 p-0">-->
<!--    <h5 class="font-weight-bold mb-5">Anomalies</h5>-->
<!--    <div class="row listeAnomalieSideBar">-->
<!--    </div>-->
<!--</div>-->
<!--end::Nav-->