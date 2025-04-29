<!-- Modal -->
<div class="modal fade" data-modifiable="<?php echo isset($modifiable)?$modifiable:true ?>" id="staticBackdropCommande" data-backdrop="static" role="dialog" aria-labelledby="staticBackdropCommande" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-lg-11">
                    <h5 class="modal-title" id="modalTitleCommande">Modal Title</h5>
                </div>
                <div class="col-lg-1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
            </div>
            <form class="form" id="kt_form_1" method="post" enctype="multipart/form-data">
                <div style="max-height:800px;overflow:auto;" class="modal-body">
                    <div>
                        <div class="row">
                            <div class="col-12 ongletmenu">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="informations-tab" data-toggle="tab" href="#informations" aria-controls="informations">
                                                    <span class="nav-icon">
                                                        <i class="flaticon2-layers-1"></i>
                                                    </span>
                                            <span class="nav-text">Informations</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="descriptif-tab" data-toggle="tab" href="#descriptif" aria-controls="descriptif">
                                                    <span class="nav-icon">
                                                        <i class="flaticon2-layers-1"></i>
                                                    </span>
                                            <span class="nav-text">Descriptif du devis</span>
                                        </a>
                                    </li>
                                    <!--                                    <li class="nav-item">-->
                                    <!--                                        <a class="nav-link" id="facturation-tab" data-toggle="tab" href="#facturation" aria-controls="facturation">-->
                                    <!--                                                    <span class="nav-icon">-->
                                    <!--                                                        <i class="flaticon2-layers-1"></i>-->
                                    <!--                                                    </span>-->
                                    <!--                                            <span class="nav-text">Facturation</span>-->
                                    <!--                                        </a>-->
                                    <!--                                    </li>-->
                                    <li class="nav-item">
                                        <a class="nav-link" id="historique-tab" data-toggle="tab" href="#historique" aria-controls="historique">
                                                    <span class="nav-icon">
                                                        <i class="flaticon2-layers-1"></i>
                                                    </span>
                                            <span class="nav-text">Historique</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 onglets">
                                <div class="tab-content" id="myTabContent5">
                                    <div class="tab-pane fade show active moisvalide" id="informations" role="tabpanel" aria-labelledby="informations-tab">
                                        <div class="col-md-12 mt-2">
                                            <div class="form-group row">
                                                <div class="col-lg-1">
                                                    <input id="numero" type="text" class="form-control" placeholder="N° de devis" name="numero" />
                                                    <span class="form-text font-weight-bold">*N° devis</span>
                                                </div>
                                                <div class="col-lg-1" style="display:none;">
                                                    <input id="numerodevis" type="text" class="form-control" placeholder="N° de devis" name="numerodevis" />
                                                    <span class="form-text">N° devis</span>
                                                </div>
                                                <div class="col-lg-1">
                                                    <input id="dateprevu" type="date" class="form-control" placeholder="Date prévu" name="dateprevu" />
                                                    <span class="form-text text-muted">Date de la visite</span>
                                                </div>
                                                <div class="col-lg-1">
                                                    <input id="heureprevu" type="time" class="form-control" placeholder="" name="heureprevu" />
                                                    <span class="form-text text-muted">Heure de la visite</span>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input id="travauxaexecuter" type="text" class="form-control" placeholder="Objet du devis" name="travauxaexecuter" />
                                                    <span class="form-text font-weight-bold">*Objet</span>
                                                </div>
                                                <div class="col-lg-2">
                                                    <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                        <label>
                                                             <input id="accespmr" type="checkbox" name="accespmr" value="0" />
                                                             <span></span>
                                                        </label>
                                                    </span>
                                                    <span class="form-text text-muted">Accès PMR</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-2">
                                                    <select class="form-control" id="modepaiement" name="modepaiement">
                                                        <option value="Aucun">&mdash;</option>
                                                        <option value="Carte bleue">Carte bleue</option>
                                                        <option value="Chèque">Chèque</option>
                                                        <option value="Espèces">Espèces</option>
                                                        <option value="Virement">Virement</option>
                                                        <!--                                                        <option value="Crédit">Crédit</option>-->
                                                        <!--                                                        <option value="Paiement en plusieurs fois">Paiement en plusieurs fois</option>-->
                                                    </select>
                                                    <span class="form-text text-muted">Mode de paiement<span>
                                                </div>
                                                <div class="col-lg-2">
                                                    <span class="switch switch-outline switch-icon switch-success switch-sm">
                                                        <label>
                                                             <input id="paiementjourvisite" type="checkbox" name="paiementjourvisite" value="0" />
                                                             <span></span>
                                                        </label>
                                                    </span>
                                                    <span class="form-text text-muted">Paiement le jour de la visite</span>
                                                </div>
                                                <!--                                                <div class="paiementplusieursfois col-lg-2">-->
                                                <!--                                                    <input class="solde form-control text-white" name="solde" type="text" placeholder="Solde restant" disabled />-->
                                                <!--                                                    <span class="form-text text-muted">Solde restant en €</span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="paiementcredit col-lg-2">-->
                                                <!--                                                    <input class="form-control" data-type='currency' name="montantfinance" id="montantfinance" type="text" min="1" step="0.01" value="0.00"/>-->
                                                <!--                                                    <span class="form-text text-muted">Montant financé en €</span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="paiementcredit col-lg-2">-->
                                                <!--                                                    <input class="form-control" data-type='currency' name="apport" id="apport" type="text" min="1" step="0.01" value="0.00" />-->
                                                <!--                                                    <span class="form-text text-muted">Apport en €</span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="paiementcredit col-lg-2">-->
                                                <!--                                                    <input class="form-control" name="nbmensualites" id="nbmensualites" type="number" min="1" step="1" value="1"/>-->
                                                <!--                                                    <span class="form-text text-muted">Nombre de mensualités</span>-->
                                                <!--                                                </div>-->
                                                <!--                                                <div class="paiementcredit col-lg-2">-->
                                                <!--                                                    <input class="form-control" data-type='currency' name="montantmensualites" id="montantmensualites" type="text" min="1" step="0.01" value="1.00" />-->
                                                <!--                                                    <span class="form-text text-muted">Montant des mensualités en €</span>-->
                                                <!--                                                </div>-->
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <hr />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <h3 class="font-size-lg text-dark font-weight-bold mb-1">Client/Prospect</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="mb-3 col-lg-4">
                                                    <?php

                                                    echo buildSelectClient($connexion, 'clients', '', '', true);

                                                    ?>
                                                    <span class="form-text text-muted">Clients</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <h3 class="font-size-lg text-dark font-weight-bold mb-1">Adresse</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-2" hidden>
                                                    <input id="numerotravaux" type="text" class="lesChampsTravaux form-control" placeholder="N°" name="numerotravaux" />
                                                    <span class="form-text text-muted">Numéro</span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input id="ruetravaux" type="text" class="lesChampsTravaux form-control" placeholder="Adresse" name="ruetravaux" />
                                                    <span class="form-text text-muted">Adresse</span>
                                                </div>
                                                <div class="col-lg-2">
                                                    <input id="cptravaux" type="text" class="lesChampsTravaux form-control" placeholder="Code postal" name="cptravaux" />
                                                    <span class="form-text text-muted">Code postal</span>
                                                </div>
                                                <div class="col-lg-4">
                                                    <input id="villetravaux" type="text" class="lesChampsTravaux form-control" placeholder="Ville" name="villetravaux" />
                                                    <span class="form-text text-muted">Ville</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <hr />
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-2">
                                                    <input id="date" type="date" class="form-control" placeholder="Date" name="date" />
                                                    <span class="form-text text-muted">Date du devis</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade moisvalide" id="descriptif" role="tabpanel" aria-labelledby="descriptif-tab">
                                        <div class="mt-2 col-md-12">
                                            <div class="form-group row">
                                                <div class="col-lg-12">
                                                    <h3 class="font-size-lg text-dark font-weight-bold mb-1">Descriptif du devis</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-8">
                                                    <?php

                                                    echo buildSelectPrestations($connexion, 'prestations', '', true);

                                                    ?>
                                                </div>
                                                <!--<div class="col-lg-1">
                                                    <input id="quantite" type="number" class="form-control" placeholder="Qté" min="1" step="1" />
                                                </div>-->
                                                <div class="col-lg-1">
                                                    <button class="addPrestation btn btn-primary">Ajouter</button>
                                                </div>
                                                <div class="float-right col-lg-2">
                                                    <button class="addPrestationVide btn btn-primary">Ajouter un commentaire</button>
                                                </div>
                                            </div>
                                            <div style="" class="mt-2 form-group row">
                                                <div class="col-lg-12">
                                                    <table class="table table-bordered table-collapse">
                                                        <thead>
                                                        <tr>
                                                            <th>Code</th>
                                                            <th>Désignation</th>
                                                            <th>Qté</th>
                                                            <th>Montant</th>
                                                            <th colspan="2" class="text-center">Unité</th>
                                                            <th>TVA</th>
                                                            <th>Total</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="listePrestations">

                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-8">
                                                </div>
                                                <div class="col-lg-4">
                                                    <table class="tableTotaux table table-bordered table-collapse">
                                                        <tr>
                                                            <td class="font-weight-bold" style="vertical-align: middle;">Total H.T € </td><td style="vertical-align: middle;"><span class="totalHT"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;">Remise €</td><td style="vertical-align: middle;"><input style="width:100px;" class="form-control remisesclass" type="number" value="" id="totalRemise" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="vertical-align: middle;">Remise %</td><td style="vertical-align: middle;"><input style="width:100px;" class="form-control remisesclass" type="number" value="" id="totalRemisePourcent" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold" style="vertical-align: middle;">Total Net H.T €</td><td style="vertical-align: middle;"><span class="totalNet"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold" style="vertical-align: middle;">T.V.A 5.5%</td><td style="vertical-align: middle;"><span data-tva="5.5" class="totalTVA"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold" style="vertical-align: middle;">T.V.A 10%</td><td style="vertical-align: middle;"><span data-tva="10" class="totalTVA"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold" style="vertical-align: middle;">T.V.A 20%</td><td style="vertical-align: middle;"><span data-tva="20" class="totalTVA"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="font-weight-bold" style="vertical-align: middle;">Total TTC €</td><td style="vertical-align: middle;"><span class="totalTTC"></span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                                <div class="col-lg-12">
                                                    <textarea id="info" class="form-control" placeholder="" name="info"></textarea>
                                                    <span class="form-text text-muted">Informations complémentaires<span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="facturation" role="tabpanel" aria-labelledby="facturation-tab">
                                        <div class="mt-2 col-md-12">
                                            <div class="form-group row mb-4">
                                                <div class="col-lg-12">
                                                    <h3 class="font-size-lg text-dark font-weight-bold mb-1">Facturation</h3>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-lg-6">
                                                    <div class="row mb-4">
                                                        <div class="col-lg-2">
                                                            <input disabled id="numcomfact" type="text" class="form-control" placeholder="N° devis" name="numcomfact" />
                                                            <span class="form-text text-muted">N° de devis</span>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input disabled id="modepaiementfact" type="text" class="form-control" placeholder="Mode de paiement" name="modepaiementfact" />
                                                            <span class="form-text text-muted">Mode de paiement</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-10">
                                                            <input disabled id="objetfact" type="text" class="form-control" placeholder="Travaux à exécuter" name="objetfact" />
                                                            <span class="form-text text-muted">Object</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-5">
                                                            <input disabled id="clientfact" type="text" class="form-control" placeholder="Client" name="clientfact" />
                                                            <span class="form-text text-muted">Client</span>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-lg-9">
                                                            <input disabled id="adresseclientfact" type="text" class="form-control" placeholder="Adresse de facturation" name="adresseclientfact" />
                                                            <span class="form-text text-muted">Adresse de facturation</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <hr class="mt-5">
                                                    <div class="mt-5 row encaissementFacture">
                                                        <div class="col-lg-12">
                                                            <h3 class="font-size text-dark font-weight-bold mb-2">Ajouter un encaissement</h3>
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <input id="dateencaissement" type="date" class="fieldsencaissement form-control" placeholder="Date d'encaissement" name="dateencaissement" />
                                                                    <span class="form-text font-weight-bold">*Date d'encaissement</span>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <select class="fieldsencaissement form-control" id="typepaiementencaissement" name="typepaiementencaissement">
                                                                        <option value="Avoir">Avoir</option>
                                                                        <option value="Chèque">Chèque</option>
                                                                        <option value="Espèces">Espèces</option>
                                                                        <option value="Virement">Virement</option>
                                                                    </select>
                                                                    <span class="form-text font-weight-bold">*Type de paiement</span>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <input id="montantencaissement" type="text" class="fieldsencaissement form-control" placeholder="Montant encaissé" name="montantencaissement" />
                                                                    <span class="form-text font-weight-bold">*Montant encaissé</span>
                                                                </div>
                                                                <div class="col-lg-4 text-center">
                                                                    <button class="addencaissement btn btn-primary" data-keyboard="false">Ajouter un encaissement</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-5 row encaissementFacture">
                                                        <div class="col-lg-12">
                                                            <h3 class="font-size-lg text-dark font-weight-bold mb-2">Liste des encaissements ajoutés</h3>
                                                            <table class="table table-bordered table-collapse">
                                                                <thead>
                                                                <tr>
                                                                    <th>Date d'encaissement</th>
                                                                    <th>Type de paiement</th>
                                                                    <th>Montant encaissé</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody id="addtabencaissements">
                                                                <tr id="addaucunencaissement">
                                                                    <td class="text-center" colspan="3">Aucun encaissement</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="mt-5 row">
                                                        <div class="col-lg-8">
                                                            <button class="encaisseFacture btn btn-primary" data-keyboard="false">Encaisser le devis</button>&nbsp;<span style="padding-top:8px;" id="encaisseFacturation"></span>
                                                        </div>
                                                        <div class="col-lg-4 encaissementFacture">
                                                            <input type="text" class="solde form-control text-white" placeholder="Solde restant" name="solde" disabled />
                                                            <span class="form-text text-muted">Solde restant en €</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="historique" role="tabpanel" aria-labelledby="historique-tab">
                                        <div class="mt-2 col-md-12">
                                            <table class="tableHistorique table table-collapse">

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row mr-auto">
                        <div class="col-lg-12">
                            <button id="annulerCommande" type="button" class="btn btn-light-danger font-weight-bold" style="float:left;">Annuler le devis</button>
                        </div>
                    </div>
                    <button id="cancelModal" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Annuler</button>
                    <button type="submit" id="saveModalCommande" type="button" class="btn btn-primary font-weight-bold">Ajouter et fermer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal -->
<!-- Modal -->
<div class="modal fade" id="staticBackdropAnnulerCommande" data-backdrop="static" tabindex="10" role="dialog" aria-labelledby="staticBackdropAnnulerCommande">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleAnnulerCommande">Annulation du devis</h5>
                <button type="button" class="close" data-number="2" aria-label="Close">
                    <i class="ki ki-close"></i>
                </button>
            </div>
            <form class="form" id="kt_form_2">
                <div class="modal-body">
                    <div>
                        <div class="tab-content" id="myTabContent5">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="row mb">
                                        <div class="col-lg-12">
                                            <textarea id="commentaireAnnulation" class="form-control" placeholder="Commentaire" name="commentaireAnnulation"></textarea>
                                            <span class="form-text font-weight-bold">*Motif d'annulation du devis</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12">
                            <button id="annulationCommandeAnnuler" class="btn btn-danger font-weight-bold" data-number="2">Annuler</button>
                            <button type="submit" id="annulationCommandeConfirmer" type="button" class="btn btn-primary font-weight-bold">Valider</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal -->