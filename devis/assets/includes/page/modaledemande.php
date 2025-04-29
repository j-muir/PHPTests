<!-- Modal -->
<div class="modal fade" id="staticBackdropDemande" data-is-modifiable="<?php echo $isModifiable; ?>" data-id=""
     data-backdrop="static" role="dialog"
     aria-labelledby="staticBackdropDemande">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleDemande">Modal Title</h5>
                <button type="button" class="close" data-number="5" aria-label="Close">
                    <i class="ki ki-close"></i>
                </button>
            </div>
            <form class="form" id="kt_form_demande" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <h3 class="font-size-lg text-dark font-weight-bold mb-1">Informations générales</h3>
                        </div>
                        <div class="col-lg-2">
                            <input id="date_demande" type="date" class="form-control" name="date_demande"/>
                            <span class="form-text font-weight-bold">*Date demande</span>
                        </div>
                        <div class="col-lg-2">
                            <input id="date_a_envoyer" type="date" class="form-control"
                                   name="date_a_envoyer"/>
                            <span class="form-text font-weight-bold">*A envoyer pour le</span>
                        </div>
                        <div class="col-lg-3">
                            <?php

                            echo buildSelectListeTypeDemande($connexion, 'type_demande');

                            ?>
                            <span class="form-text font-weight-bold">*Faite par</span>
                        </div>
                        <div class="col-lg-5 autres_type_demande d-none">
                            <input id="autres_type_demande" type="text" placeholder="Préciser" class="form-control"
                                   name="autres_type_demande"/>
                            <span class="form-text font-weight-bold">*Préciser</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <h3 class="font-size-lg text-dark font-weight-bold mb-1">Prospect</h3>
                        </div>
                        <div class="col-lg-1">
                            <!--begin::Switch-->
                            <span class="switch switch-outline switch-icon switch-success switch-sm">
                                            <label>
                                                <input id="nouveau_prospect" type="checkbox"
                                                       name="nouveau_prospect" value="1"/>
                                                 <span></span>
                                            </label>
                                        </span>
                        </div>
                        <div class="col-lg-3 pt-1">
                            <span class="font-size-sm">Nouveau prospect</span>
                        </div>
                        <div class="col-lg-4">
                            <?php

                            echo buildSelectClient($connexion, 'clients', 'ancien_client');

                            ?>
                        </div>
                        <div class="col-lg-4">
                            <button id="searchInfosClient" type="button"
                                    class="btn btn-primary font-weight-bold ancien_client">Récupérer les infos
                                existantes
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <input id="nom_groupe" type="text" class="form-control champs_client"
                                   placeholder="Nom du groupe"
                                   name="nom_groupe"/>
                            <span class="form-text text-muted">Nom du groupe</span>
                        </div>
                        <div class="col-lg-4">
                            <input id="nom" type="text" class="form-control champs_client" placeholder="Nom responsable"
                                   name="nom"/>
                            <span class="form-text font-weight-bold">*Nom responsable</span>
                        </div>
                        <div class="col-lg-4">
                            <input id="prenom" type="text" class="form-control champs_client"
                                   placeholder="Prénom responsable" name="prenom"/>
                            <span class="form-text font-weight-bold">*Prénom responsable</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <input id="adresse" type="text" class="form-control champs_client" placeholder="Adresse"
                                   name="adresse"/>
                            <span class="form-text text-muted">Adresse</span>
                        </div>
                        <div class="col-lg-2">
                            <input id="codepostal" type="text" class="form-control champs_client"
                                   placeholder="Code postal" name="codepostal"/>
                            <span class="form-text font-weight-bold">*Code postal</span>
                        </div>
                        <div class="col-lg-3">
                            <input id="ville" type="text" class="form-control champs_client" placeholder="Ville"
                                   name="ville"/>
                            <span class="form-text font-weight-bold">*Ville</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-2">
                            <input id="numtel" type="text" class="form-control champs_client"
                                   placeholder="Numéro de téléphone" name="numtel"/>
                            <span class="form-text text-muted">Téléphone</span>
                        </div>
                        <div class="col-lg-4">
                            <input id="email" type="text" class="form-control champs_client" placeholder="Email"
                                   name="email"/>
                            <span class="form-text text-mute">Email</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <input id="date_visite" type="datetime-local" class="form-control"
                                   name="date_visite"/>
                            <span class="form-text font-weight-bold">*Date de la visite</span>
                        </div>
                        <div class="col-lg-2">
                            <input id="nombre_participant" type="text" placeholder="Nombre de participants"
                                   class="form-control" name="nombre_participant"/>
                            <span class="form-text font-weight-bold">*Nombre de participants</span>
                        </div>
                        <div class="col-lg-2">
                            <input id="nombre_accompagnateur" type="text"
                                   placeholder="Nombre d'accompagnateurs" class="form-control"
                                   name="nombre_accompagnateur"/>
                            <span class="form-text font-weight-bold">*Nombre d'accompagnateurs</span>
                        </div>
                        <div class="col-lg-3">
                            <!--begin::Switch-->
                            <span class="switch switch-outline switch-icon switch-success switch-sm">
                                            <label>
                                                <input id="accueil_pmr" type="checkbox" name="accueil_pmr" value="1"/>
                                                 <span></span>
                                            </label>
                                        </span>
                            <span class="form-text text-muted">Accueil PMR demandé</span>
                            <!--end::Switch-->
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <h3 class="font-size-lg text-dark font-weight-bold mb-1">Spécificité du groupe</h3>
                        </div>
                        <div class="col-lg-6">
                            <?php

                            echo buildSelectListeSpecificitesGroupeDemande($connexion, 'specificite_groupe');

                            ?>
                            <span class="form-text text-mute">&nbsp;</span>
                        </div>
                        <div class="col-lg-6 autres_specificite_groupe d-none">
                            <input id="autres_specificite_groupe" type="text" placeholder="Préciser"
                                   class="form-control"
                                   name="autres_specificite_groupe"/>
                            <span class="form-text font-weight-bold">*Préciser</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <h3 class="font-size-lg text-dark font-weight-bold mb-1">Suppléments</h3>
                        </div>
                        <div class="col-lg-1">
                            <!--begin::Switch-->
                            <span class="switch switch-outline switch-icon switch-success switch-sm">
                                            <label>
                                                <input id="guidage_benevole" type="checkbox" name="guidage_benevole"
                                                       value="1"/>
                                                 <span></span>
                                            </label>
                                        </span>
                            <!--end::Switch-->
                        </div>
                        <div class="col-lg-11 pt-1">
                            <span class="font-size-sm">Guidage par un de nos bénévoles selon disponibilité&nbsp;: 1 guidage pour 20 pax = 20€</span>
                        </div>
                        <div class="col-lg-1">
                            <!--begin::Switch-->
                            <span class="switch switch-outline switch-icon switch-success switch-sm">
                                            <label>
                                                <input id="guide_professionnel" type="checkbox"
                                                       name="guide_professionnel" value="1"/>
                                                 <span></span>
                                            </label>
                                        </span>
                            <!--end::Switch-->
                        </div>
                        <div class="col-lg-11 pt-1">
                            <span class="font-size-sm">Guide professionnel par office de tourisme&nbsp;: sur devis</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <h3 class="font-size-lg text-dark font-weight-bold mb-1">Autres prestations</h3>
                        </div>
                        <div class="col-lg-12 mb-2">
                            <span class="font-size-sm">Pause gourmande&nbsp;: 2.90€ / personne (1 boisson chaude, 1 madeleine, 1 jus d'orange)</span>
                        </div>
                        <div class="col-lg-12">
                            <input id="location_salle" type="text" class="form-control"
                                   placeholder="Location de la salle de réception"
                                   name="location_salle"/>
                            <span class="form-text text-mute">Location de la salle de réception</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light-danger font-weight-bold" data-number="5">Annuler</button>
                    <?php
                    if ($isModifiable) {
                        ?>
                        <button id="saveModalDemande" type="button"
                                class="btn btn-primary font-weight-bold">Ajouter et fermer
                        </button>
                        <?php
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End modal -->