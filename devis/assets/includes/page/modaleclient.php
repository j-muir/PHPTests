<!-- Modal -->
<div class="modal fade" id="staticBackdropClient" data-id="" data-backdrop="static" role="dialog" aria-labelledby="staticBackdropClient">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleClient">Modal Title</h5>
                    <button type="button" class="close" data-number="1" aria-label="Close">
                    <i class="ki ki-close"></i>
                </button>
            </div>
            <form class="form" id="kt_form_client" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6 border-right border-light taillecolonne">
                            <div class="mb-5">
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <?php $type = 'type'; echo buildSelectTypeClient($type)?>
                                        <span class="form-text text-muted">Type de client</span>
                                    </div>
                                    <div class="col-lg-6 professionnel">
                                        <input id="societe" type="text" class="form-control" placeholder="Société" name="societe" />
                                        <span class="form-text font-weight-bold">*Nom du groupe</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-2">
                                        <?php
                                        echo buildSelectListeDeroulante($connexion, 'civilite', 'civilite')
                                        ?>
                                        <span class="form-text text-muted">Civilité</span>
                                    </div>
                                    <div class="col-lg-5">
                                        <input id="nom" type="text" class="form-control" placeholder="Nom" name="nom" />
                                        <span class="form-text font-weight-bold">*Nom</span>
                                    </div>
                                    <div class="col-lg-5">
                                        <input id="prenom" type="text" class="form-control" placeholder="Prénom" name="prenom" />
                                        <span class="form-text font-weight-bold">*Prénom</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <input id="adresse" type="text" class="form-control" placeholder="Adresse" name="adresse" />
                                        <span class="form-text text-muted">Adresse</span>
                                    </div>
                                    <div class="col-lg-2">
                                        <input id="codepostal" type="text" class="form-control" placeholder="Code postal" name="codepostal" />
                                        <span class="form-text font-weight-bold">*Code postal</span>
                                    </div>
                                    <div class="col-lg-4">
                                        <input id="ville" type="text" class="form-control" placeholder="Ville" name="ville" />
                                        <span class="form-text font-weight-bold">*Ville</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-6">
                                        <input id="email" type="text" class="form-control" placeholder="Email" name="email" />
                                        <span class="form-text text-mute">Email</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <input id="numtel" type="text" class="form-control" placeholder="N° Tél fixe" name="numtel" />
                                        <span class="form-text text-muted">Téléphone fixe</span>
                                    </div>
                                    <div class="col-lg-3">
                                        <input id="numportable" type="text" class="form-control" placeholder="N° Tél portable" name="numportable" />
                                        <span class="form-text text-muted">Téléphone portable</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h3 class="historiqueCommande">Historique des devis</h3>
                                    <div class="historiqueCommande" style="max-height:400px; overflow-y:auto;">
                                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_commande">
                                            <thead>
                                            <tr>
                                                <th>Numéro de devis</th>
                                                <th>Date</th>
                                                <th>Objet</th>
                                                <th>Montant HT Net</th>
                                                <th>État</th>
                                            </tr>
                                            </thead>
                                            <tbody id="commandes">
                                            <tr>
                                                <td class="text-center" colspan="4">Aucun devis passé</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <h3 class="historiqueDemande">Historique des demandes</h3>
                                    <div class="historiqueDemande" style="max-height:400px; overflow-y:auto;">
                                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable_demande">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>État</th>
                                            </tr>
                                            </thead>
                                            <tbody id="commandes">
                                            <tr>
                                                <td class="text-center" colspan="2">Aucun demande passée</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row mr-auto">
                        <div class="col-lg-12">
                            <button style="float:left;" id="deleteClient" class="btn btn-danger font-weight-bold">Supprimer le client</button>
                        </div>
                    </div>
                    <button id="closeClientModal" class="btn btn-light-danger font-weight-bold" data-number="1">Annuler</button>
                    <button type="submit" id="saveModalClient" type="button" class="btn btn-primary font-weight-bold">Ajouter et fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal -->

<!-- Modal -->
<div class="modal fade" id="staticBackdropDeleteClient" data-backdrop="static" role="dialog" aria-labelledby="staticBackdropDeleteClient">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleDeleteClient">Suppression du client</h5>
                <button type="button" class="close" data-number="4" aria-label="Close">
                    <i class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Vous allez supprimer ce client. <br><br> Êtes-vous sûr de vouloir continuer ?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light-danger font-weight-bold" data-number="4">Annuler</button>
                <button type="submit" id="saveModalDeleteClient" type="button" class="btn btn-primary font-weight-bold">Valider</button>
            </div>
        </div>
    </div>
</div>
<!-- End modal -->