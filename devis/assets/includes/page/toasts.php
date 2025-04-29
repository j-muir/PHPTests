<!-- Start Toast -->
<div class="position-fixed top-0 right-0 p-3" style="min-height: 10%;z-index: 9999; right: 0; top: 0;">
    <div id="liveToastInformations" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header bg-primary text-white">
            <strong class="mr-auto" id="infosToastTitle">Information</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="infosToastBody">
            Modifications enregistrées avec succès !
        </div>
    </div>
</div>
<div class="position-fixed top-0 right-0 p-3" style="min-height: 10%;z-index: 9999; right: 0; top: 0;">
    <div id="liveToastErreurs" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="4000">
        <div class="toast-header bg-danger text-white">
            <strong class="mr-auto" id="erreursToastTitle">Attention</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" id="erreursToastBody">
            Une erreur est survenue.
        </div>
    </div>
</div>
<!-- End Toast -->