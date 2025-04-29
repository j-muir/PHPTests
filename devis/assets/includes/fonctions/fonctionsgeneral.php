<?php

/* ******************* */
/* fonctions générales */
/* ******************* */
function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function getListeDeroulanteById($connexion, $tableConcerne, $id) {
    $requete = "SELECT * FROM $tableConcerne WHERE id_$tableConcerne = '" . pg_escape_string($id) . "'";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    return $row['nom_' . $tableConcerne];
}

function getListeDeroulante($connexion, $tableConcerne) {
    $requete = "SELECT * FROM $tableConcerne";
    $res = $connexion->query($requete);
    $array = [];
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $array[$row['id_' . $tableConcerne]]['nom'] = $row['nom_' . $tableConcerne];
    }

    return $array;
}

function getFamillePrestation($connexion) {
    $requete = "SELECT * FROM familles_prestation";
    $res = $connexion->query($requete);
    $array = [];
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $array[$row['id_famille']]['nom'] = $row['nom_famille'];
        $array[$row['id_famille']]['initiale'] = $row['initiale_famille'];

    }

    return $array;
}

function parse_qsl($qs, $keep_blank_values = false) {
    $qs = explode("&", $qs);
    $out = [];
    foreach ($qs as $pair) {
        $pair = explode("=", $pair, 2);
        if (count($pair) != 2) continue;
        $value = urldecode($pair[1]);
        if ($keep_blank_values || $value !== '') {
            $key = urldecode($pair[0]);
            $out[$key][] = $value;
        }
    }
    return $out;
}

function getNextMonths() {
    $months = [];
    $currentMonth = (int)date('n');
    $currentYear = (int)date('Y');

    $monthNames = [
        1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
        5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
        9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
    ];

    for ($i = 0; $i < 13; $i++) {
        $monthNumber = ($currentMonth + $i) % 12;
        if ($monthNumber == 0) {
            $monthNumber = 12;
        }

        $year = $currentYear + (int)(($currentMonth + $i - 1) / 12);
        $value = $year . '-' . str_pad($monthNumber, 2, '0', STR_PAD_LEFT);
        $label = $monthNames[$monthNumber] . ' ' . $year;

        $months[] = [
            'value' => $value,
            'label' => $label
        ];
    }

    return $months;
}

function addJoursOuvres($startDate, $daysToAdd) {
    $currentDate = strtotime($startDate);
    $addedDays = 0;

    while ($addedDays < $daysToAdd) {
        $currentDate = strtotime("+1 day", $currentDate);
        $dayOfWeek = date("N", $currentDate);
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5) {
            $addedDays++;
        }
    }

    return date("Y-m-d", $currentDate);
}

function buildSelectListeDeroulante($connexion, $tableConcernee, $id, $multiple = "", $disabled = "", $optionAucun = true) {
    $arrayListeDeroulante = getListeDeroulante($connexion, $tableConcernee);

    $build = '<select id="' . $id . '" name="' . $id . '" ' . $multiple . ' ' . $disabled . ' class="form-control">';
    if ($optionAucun) {
        $build .= '<option value="0">Aucun</option>';
    }

    foreach ($arrayListeDeroulante as $keyS => $valS) {
        $build .= '<option value="' . $keyS . '">' . $valS['nom'] . '</option>';
    }
    $build .= '</select>';
    return $build;
}

function buildSelectListeTypeDemande($connexion, $id, $ceb, $multiple = "", $disabled = "", $optionAucun = true) {
    $arrayListeDeroulante = ['Téléphone' => 'Téléphone', 'Sur place' => 'Sur place', 'Email' => 'Email', 'Courrier' => 'Courrier'];

    $build = '<select data-ceb="'.$ceb.'" id="' . $id . '" name="' . $id . '" ' . $multiple . ' ' . $disabled . ' class="form-control">';
    if ($optionAucun) {
        $build .= '<option value="0">Aucun</option>';
    }

    foreach ($arrayListeDeroulante as $keyS => $valS) {
        $build .= '<option value="' . $keyS . '">' . $valS . '</option>';
    }
    $build .= '</select>';
    return $build;
}

function getInitials($fullName) {
    $parts = explode(' ', $fullName);
    $initials = '';
    foreach ($parts as $part) {
        $initials .= strtoupper($part[0]);
    }

    return $initials;
}

function buildSelectListeSpecificitesGroupeDemande($connexion, $id, $ceb, $multiple = "", $disabled = "", $optionAucun = true) {
    $arrayListeDeroulante = ['Visiteurs' => 'Visiteurs', 'Maternelle/primaire OCCE' => 'Maternelle/primaire OCCE', 'Maternelle/primaire HORS OCCE' => 'Maternelle/primaire HORS OCCE', 'Etudiants' => 'Etudiants', 'Lycéens' => 'Lycéens', 'Collégiens' => 'Collégiens', 'Centre de loisirs' => 'Centre de loisirs', "Comité d'entreprise" => "Comité d'entreprise", "Association" => "Association", "Sénior" => "Sénior"];

    $build = '<select data-ceb="'.$ceb.'" id="' . $id . '" name="' . $id . '" ' . $multiple . ' ' . $disabled . ' class="form-control">';
    if ($optionAucun) {
        $build .= '<option value="0">Aucun</option>';
    }

    foreach ($arrayListeDeroulante as $keyS => $valS) {
        $build .= '<option value="' . $keyS . '">' . $valS . '</option>';
    }
    $build .= '</select>';
    return $build;
}

function addBlocage($connexion, $objetId, $tableConcernee, $utilisateur){
    $reqBlocage = "INSERT INTO blocage (id_blocage, date_blocage, utilisateur_blocage, table_concernee_blocage) VALUES ('" . $objetId . "', NOW(), '" . $utilisateur . "', '" . $tableConcernee . "')";
    $resBlocage = $connexion->query($reqBlocage);
    return $resBlocage != false ? true : $resBlocage;
}

function getBlocage($connexion, $id, $type, $utilisateur){
    $reqBlocage = "SELECT * FROM blocage WHERE id_blocage = '" . $id . "' AND table_concernee_blocage = '" . $type . "' AND utilisateur_blocage != '" . $utilisateur . "'";
    $resBlocage = $connexion->query($reqBlocage);
    $count = $resBlocage->rowCount();
    if ($count > 0) {
        $row = $resBlocage->fetch(PDO::FETCH_ASSOC);
        return array('status' => true, 'login' => $row['utilisateur_blocage']);
    } else {
        return array('status' => false, 'login' => '');
    }
}

function deleteUserBlocage($connexion, $utilisateur){
    $requete = "DELETE FROM blocage WHERE utilisateur_blocage = '".pg_escape_string($utilisateur)."'";
    $res = $connexion->query($requete);
}

function buildSelectClient($connexion, $id, $class = "", $multiple = "", $isNotMultiple = false) {
    $arrayUtilisateur = getClients($connexion);

    $build = '<select id="select2_' . $id . '" name="' . $id . '" ' . $multiple . ' class="form-control select2 kt_select2_' . $id . ' ' . $class . '" style="width: 100%;">';
    if ($isNotMultiple) {
        $build .= '<option value="0">Aucun</option>';
    }
    foreach ($arrayUtilisateur as $keyS => $valS) {
        if ($valS['societe'] != "") {
            $build .= '<option value="' . $keyS . '">' . $valS['nom'] . ' ' . $valS['prenom'] . ' (' . $valS['societe'] . ')</option>';
        } else {
            $build .= '<option value="' . $keyS . '">' . $valS['nom'] . ' ' . $valS['prenom'] . '</option>';
        }
    }
    $build .= '</select>';
    return $build;
}

function buildSelectPrestations($connexion, $id, $multiple = "", $isNotMultiple = false) {
    $arrayPrestation = getPrestations($connexion);

    $build = '<select id="select2_' . $id . '" name="' . $id . '" ' . $multiple . ' class="form-control select2 kt_select2_' . $id . '" style="width: 100%;">';
    if ($isNotMultiple) {
        $build .= '<option value="0">Sélectionnez une prestation</option>';
    }

    foreach ($arrayPrestation as $keyS => $valS) {
        $build .= '<option value="' . $keyS . '">' . $valS['designationSimple'] . ' (' . $valS['prixHt'] . '€)</option>';
    }
    $build .= '</select>';
    return $build;
}

function buildSelectIndicatif($codeTel) {
    return '<select id="' . $codeTel . '" class="form-control select2" aria-invalid="false" aria-multiselectable="false" aria-describedby="message_Dropdown_72024148" name="' . $codeTel . '"  style="width: 100%;"><option value="+33" selected="selected">France +33</option><option value="+27">Afrique du Sud +27</option><option value="+355">Albanie +355</option><option value="+213">Algérie +213</option><option value="+49">Allemagne +49</option><option value="+376">Andorre +376</option><option value="+244">Angola +244</option><option value="+1">États-Unis, Canada et Caraïbes +1</option><option value="+599">Antilles néerlandaises +599</option><option value="+966">Arabie saoudite +966</option><option value="+54">Argentine +54</option><option value="+374">Arménie +374</option><option value="+297">Aruba +297</option><option value="+61">Australie +61</option><option value="+43">Autriche +43</option><option value="+994">Azerbaïdjan +994</option><option value="+973">Bahreïn +973</option><option value="+32">Belgique +32</option><option value="+501">Belize +501</option><option value="+975">Bhoutan +975</option><option value="+375">Biélorussie +375</option><option value="+591">Bolivie +591</option><option value="+387">Bosnie-Herzégovine +387</option><option value="+267">Botswana +267</option><option value="+673">Brunéi Darussalam +673</option><option value="+55">Brésil +55</option><option value="+359">Bulgarie +359</option><option value="+226">Burkina Faso +226</option><option value="+257">Burundi +257</option><option value="+229">Bénin +229</option><option value="+855">Cambodge +855</option><option value="+237">Cameroun +237</option><option value="+238">Cap-Vert +238</option><option value="+56">Chili +56</option><option value="+86">Chine +86</option><option value="+357">Chypre +357</option><option value="+57">Colombie +57</option><option value="+269">Comores +269</option><option value="+242">Congo-Brazzaville +242</option><option value="+243">Congo-Kinshasa +243</option><option value="+82">Corée du Sud +82</option><option value="+506">Costa Rica +506</option><option value="+385">Croatie +385</option><option value="+225">Côte d’Ivoire +225</option><option value="+45">Danemark +45</option><option value="+253">Djibouti +253</option><option value="+503">El Salvador +503</option><option value="+34">Espagne +34</option><option value="+372">Estonie +372</option><option value="+679">Fidji +679</option><option value="+358">Finlande +358</option><option value="+241">Gabon +241</option><option value="+220">Gambie +220</option><option value="+350">Gibraltar +350</option><option value="+299">Groenland +299</option><option value="+30">Grèce +30</option><option value="+590">Guadeloupe +590</option><option value="+502">Guatemala +502</option><option value="+224">Guinée +224</option><option value="+245">Guinée-Bissau +245</option><option value="+592">Guyana +592</option><option value="+594">Guyane française +594</option><option value="+995">Géorgie +995</option><option value="+504">Honduras +504</option><option value="+36">Hongrie +36</option><option value="+91">Inde +91</option><option value="+62">Indonésie +62</option><option value="+353">Irlande +353</option><option value="+354">Islande +354</option><option value="+972">Israël +972</option><option value="+39">Italie +39</option><option value="+81">Japon +81</option><option value="+962">Jordanie +962</option><option value="+7">Kazakhstan +7</option><option value="+254">Kenya +254</option><option value="+996">Kirghizistan +996</option><option value="+686">Kiribati +686</option><option value="+965">Koweït +965</option><option value="+262">La Réunion +262</option><option value="+856">Laos +856</option><option value="+266">Lesotho +266</option><option value="+371">Lettonie +371</option><option value="+961">Liban +961</option><option value="+423">Liechtenstein +423</option><option value="+37">Lituanie +370</option><option value="+352">Luxembourg +352</option><option value="+389">Macédoine +389</option><option value="+261">Madagascar +261</option><option value="+60">Malaisie +60</option><option value="+265">Malawi +265</option><option value="+960">Maldives +960</option><option value="+223">Mali +223</option><option value="+356">Malte +356</option><option value="+212">Maroc +212</option><option value="+596">Martinique +596</option><option value="+230">Maurice +230</option><option value="+222">Mauritanie +222</option><option value="+262">Mayotte +262</option><option value="+52">Mexique +52</option><option value="+373">Moldavie +373</option><option value="+377">Monaco +377</option><option value="+976">Mongolie +976</option><option value="+382">Monténégro +382</option><option value="+258">Mozambique +258</option><option value="+264">Namibie +264</option><option value="+674">Nauru +674</option><option value="+505">Nicaragua +505</option><option value="+227">Niger +227</option><option value="+234">Nigéria +234</option><option value="+683">Niue +683</option><option value="+47">Norvège +47</option><option value="+687">Nouvelle-Calédonie +687</option><option value="+64">Nouvelle-Zélande +64</option><option value="+977">Népal +977</option><option value="+968">Oman +968</option><option value="+256">Ouganda +256</option><option value="+680">Palaos +680</option><option value="+507">Panama +507</option><option value="+675">Papouasie-Nouvelle-Guinée +675</option><option value="+595">Paraguay +595</option><option value="+31">Pays-Bas +31</option><option value="+63">Philippines +63</option><option value="+48">Pologne +48</option><option value="+689">Polynésie française +689</option><option value="+351">Portugal +351</option><option value="+51">Pérou +51</option><option value="+974">Qatar +974</option><option value="+852">R.A.S. chinoise de Hong Kong +852</option><option value="+40">Roumanie +40</option><option value="+44">Royaume-Uni +44</option><option value="+7">Russie +7</option><option value="+250">Rwanda +250</option><option value="+420">République tchèque +420</option><option value="+378">Saint-Marin +378</option><option value="+508">Saint-Pierre-et-Miquelon +508</option><option value="+290">Sainte-Hélène +290</option><option value="+685">Samoa +685</option><option value="+239">Sao Tomé-et-Principe +239</option><option value="+381">Serbie +381</option><option value="+248">Seychelles +248</option><option value="+232">Sierra Leone +232</option><option value="+65">Singapour +65</option><option value="+421">Slovaquie +421</option><option value="+386">Slovénie +386</option><option value="+252">Somalie +252</option><option value="+94">Sri Lanka +94</option><option value="+41">Suisse +41</option><option value="+597">Suriname +597</option><option value="+46">Suède +46</option><option value="+47">Svalbard et Jan Mayen +47</option><option value="+268">Swaziland +268</option><option value="+221">Sénégal +221</option><option value="+992">Tadjikistan +992</option><option value="+255">Tanzanie +255</option><option value="+886">Taïwan +886</option><option value="+235">Tchad +235</option><option value="+66">Thaïlande +66</option><option value="+228">Togo +228</option><option value="+676">Tonga +676</option><option value="+216">Tunisie +216</option><option value="+993">Turkménistan +993</option><option value="+90">Turquie +90</option><option value="+688">Tuvalu +688</option><option value="+380">Ukraine +380</option><option value="+598">Uruguay +598</option><option value="+678">Vanuatu +678</option><option value="+58">Venezuela +58</option><option value="+84">Vietnam +84</option><option value="+681">Wallis-et-Futuna +681</option><option value="+967">Yémen +967</option><option value="+260">Zambie +260</option><option value="+263">Zimbabwe +263</option><option value="+20">Égypte +20</option><option value="+971">Émirats arabes unis +971</option><option value="+593">Équateur +593</option><option value="+291">Érythrée +291</option><option value="+39">État de la Cité du Vatican +39</option><option value="+691">États fédérés de Micronésie +691</option><option value="+251">Éthiopie +251</option><option value="+672">Île Norfolk +672</option><option value="+682">Îles Cook +682</option><option value="+298">Îles Féroé +298</option><option value="+500">Îles Malouines +500</option><option value="+692">Îles Marshall +692</option><option value="+64">Îles Pitcairn +64</option><option value="+677">Îles Salomon +677</option></select>';
}

function buildSelectTypeClient($type) {
    return '<select id="' . $type . '" class="form-control select2" aria-invalid="false" aria-multiselectable="false" aria-describedby="message_Dropdown_72024148" name="' . $type . '"  style="width: 100%;"><option value="Particulier" selected="selected">Particulier</option><option value="Professionnel">Autres</option></select>';
}

function insertLog($connexion, $message, $auteur) {
    $requeteInsertLog = "INSERT INTO logs (message_log, date_log, auteur_log) VALUES ('" . pg_escape_string($message) . "', NOW(), '" . pg_escape_string($auteur) . "')";
    $resInsertLog = $connexion->query($requeteInsertLog);
}

function loginExist($connexion, $login, $id = 0) {
    $requeteVerif = "SELECT * FROM utilisateurs WHERE email_utilisateur = '" . $login . "'";
    if ($id != 0) {
        $requeteVerif = "SELECT * FROM utilisateurs WHERE email_utilisateur = '" . $login . "' AND id_utilisateur != '" . $id . "'";
    }

    $resVerif = $connexion->query($requeteVerif);
    $exists = false;
    if ($resVerif->rowCount() > 0) {
        $exists = true;
    }

    return $exists;
}

function getUtilisateurs($connexion) {
    $requeteUtilisateurs = "SELECT * FROM utilisateurs";
    $resUtilisateurs = $connexion->query($requeteUtilisateurs);
    $arrayTypeUtilisateur = getListeDeroulante($connexion, 'typeutilisateurs');
    $array = [];
    while ($rowUtilisateurs = $resUtilisateurs->fetch(PDO::FETCH_ASSOC)) {
        $typeUtilisateur = $arrayTypeUtilisateur[$rowUtilisateurs['typeutilisateur_utilisateur']]['nom'];

        $array[$rowUtilisateurs['id_utilisateur']]['nom'] = $rowUtilisateurs['nom_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['prenom'] = $rowUtilisateurs['prenom_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['numtel'] = $rowUtilisateurs['numtel_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['numportable'] = $rowUtilisateurs['numportable_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['fonction'] = $rowUtilisateurs['fonction_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['email'] = $rowUtilisateurs['email_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['email2'] = $rowUtilisateurs['email2_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['connecte'] = $rowUtilisateurs['is_utilisateur_connecte'];
        $array[$rowUtilisateurs['id_utilisateur']]['codenumtel'] = $rowUtilisateurs['codenumtel_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['codenumportable'] = $rowUtilisateurs['codenumportable_utilisateur'];
        $array[$rowUtilisateurs['id_utilisateur']]['typeUtilisateur'] = $typeUtilisateur;
    }

    return $array;
}

function getCommandesAccueil($connexion, $isannulee = '0') {
    $requeteCommandes = "SELECT * FROM commandes WHERE isannulee_commande = '" . $isannulee . "' AND etat_commande != 'Payée' ORDER BY timestamp_commande DESC";
    $resCommandes = $connexion->query($requeteCommandes);
    $array = [];
    while ($rowCommandes = $resCommandes->fetch(PDO::FETCH_ASSOC)) {
        $array[$rowCommandes['id_commande']]['client'] = getClientById($connexion, $rowCommandes['id_client']);
        $array[$rowCommandes['id_commande']]['date'] = date('d/m/Y', strtotime($rowCommandes['date_commande']));
        $array[$rowCommandes['id_commande']]['datetri'] = date('Ymd', strtotime($rowCommandes['date_commande']));

        $chaineType = "";
        if ($rowCommandes['typetravaux_commande'] != "") {
            $tabType = explode('|', $rowCommandes['typetravaux_commande']);
            foreach ($tabType as $keyT => $valT) {
                $chaineType .= getListeDeroulanteById($connexion, 'type_travaux', $valT);
                if ($valT == "6") {
                    $chaineType .= ' (';
                    $chaineType .= $rowCommandes['typetravauxautres_commande'];
                    $chaineType .= ')';
                }
                $chaineType .= ', ';
            }
        }

        $portefeuille = "#portefeuillegeneral";
        if ($rowCommandes['planification_commande'] == '0') {
            $portefeuille = "#portefeuillegeneral#portefeuilleapresplanification";
        }
        if (sprintf("%04d", date('Y', strtotime($rowCommandes['date_commande']))) == sprintf("%04d", date('Y')) && sprintf("%02d", date('m', strtotime($rowCommandes['date_commande']))) == sprintf("%02d", date('m'))) {
            $portefeuille .= "#portefeuillemois";
        }

        $etat = '<table style="float:left;" class="table table-bordered text-center tableEtat">
                <tr>
                    <td data-etat="En cours" id="boutonEnCours" class="boutonEtat font-weight-bold" style="background-color: #67B7DC;width: 33%;">';

        switch ($rowCommandes['etat_commande']) {
            case "Facturée":
                $etat .= 'P</td>';
                $etat .= '<td data-etat="Facturée" id="boutonFacturee" class="boutonEtat font-weight-bold" style="background-color: #F9D61B;width: 33%;"><span style="display: none;">#facturees</span>F</td>';
                $etat .= '<td data-etat="Payée" id="boutonPayee" class="boutonEtat bg-secondary opacity-50" style="width: 33%;">E</td></tr></table>';
                break;
            case "Payée" :
                $etat .= 'P</td>';
                $etat .= '<td data-etat="Facturée" id="boutonFacturee" class="boutonEtat font-weight-bold" style="background-color: #F9D61B;width: 33%;">F</td>';
                $etat .= '<td data-etat="Payée" id="boutonPayee" class="boutonEtat font-weight-bold" style="background-color:#84B761;width: 33%;"><span style="display: none;">#encaissees</span>E</td></tr></table>';
                break;
            case "En cours":
                $etat .= '<span style="display: none;">' . $portefeuille . '</span>P</td>';
                $etat .= '<td data-etat="Facturée" id="boutonFacturee" class="boutonEtat bg-secondary opacity-50" style="width: 33%;">F</td>';
                $etat .= '<td data-etat="Payée" id="boutonPayee" class="boutonEtat bg-secondary opacity-50" style="width: 33%;">E</td></tr></table>';
                break;
        }

        $array[$rowCommandes['id_commande']]['typetravaux'] = substr($chaineType, 0, -2);
        $array[$rowCommandes['id_commande']]['numero'] = $rowCommandes['numero_commande'];
        $array[$rowCommandes['id_commande']]['travauxaexecuter'] = $rowCommandes['travauxaexecuter_commande'];
        $array[$rowCommandes['id_commande']]['montantht'] = number_format($rowCommandes['totalht_commande'], 2, ',', ' ') . '&nbsp;€';
        $array[$rowCommandes['id_commande']]['montanthtMR'] = number_format($rowCommandes['total_commande'], 2, ',', ' ') . '&nbsp;€';
        $array[$rowCommandes['id_commande']]['montanthtMRtri'] = $rowCommandes['total_commande'];
        $array[$rowCommandes['id_commande']]['etat'] = $rowCommandes['etat_commande'];
        $array[$rowCommandes['id_commande']]['commentaire'] = $rowCommandes['commentaireannulation_commande'];
        $array[$rowCommandes['id_commande']]['etathtml'] = $etat;
    }

    return $array;
}

function getCommandes($connexion, $isannulee = '0', $annee = "") {
    if ($annee == "") {
        $requeteCommandes = "SELECT * FROM commandes WHERE isannulee_commande = '" . $isannulee . "' ORDER BY timestamp_commande DESC";
    } else {
        $requeteCommandes = "SELECT * FROM commandes WHERE isannulee_commande = '" . $isannulee . "' AND date_commande LIKE '" . $annee . "-%'ORDER BY timestamp_commande DESC";
    }
    $resCommandes = $connexion->query($requeteCommandes);
    $array = [];
    while ($rowCommandes = $resCommandes->fetch(PDO::FETCH_ASSOC)) {
        $array[$rowCommandes['id_commande']]['client'] = getClientById($connexion, $rowCommandes['id_client']);
        $array[$rowCommandes['id_commande']]['date'] = '';
        $array[$rowCommandes['id_commande']]['datetri'] = '';
        if(!empty($rowCommandes['dateprevu_commande'])){
            $array[$rowCommandes['id_commande']]['date'] = date('d/m/Y', strtotime($rowCommandes['dateprevu_commande']));
            $array[$rowCommandes['id_commande']]['datetri'] = date('Ymd', strtotime($rowCommandes['dateprevu_commande']));
        }


        $chaineType = "";
        if ($rowCommandes['typetravaux_commande'] != "") {
            $tabType = explode('|', $rowCommandes['typetravaux_commande']);
            foreach ($tabType as $keyT => $valT) {
                $chaineType .= getListeDeroulanteById($connexion, 'type_travaux', $valT);
                if ($valT == "6") {
                    $chaineType .= ' (';
                    $chaineType .= $rowCommandes['typetravauxautres_commande'];
                    $chaineType .= ')';
                }
                $chaineType .= ', ';
            }
        }

        $etatAffiche = "En cours";
        switch($rowCommandes['etat_commande']){
            case "Envoyé":
                $etatAffiche = "Envoyé";
                break;
            case "Validé" :
                $etatAffiche = "Validé";
                break;
        }

        $array[$rowCommandes['id_commande']]['typetravaux'] = substr($chaineType, 0, -2);
        $array[$rowCommandes['id_commande']]['numero'] = $rowCommandes['numero_commande'];
        $array[$rowCommandes['id_commande']]['travauxaexecuter'] = $rowCommandes['travauxaexecuter_commande'];
        $array[$rowCommandes['id_commande']]['montantht'] = number_format($rowCommandes['totalht_commande'], 2, ',', ' ') . '&nbsp;€';
        $array[$rowCommandes['id_commande']]['montanthtMR'] = number_format($rowCommandes['total_commande'], 2, ',', ' ') . '&nbsp;€';
        $array[$rowCommandes['id_commande']]['montanthtMRtri'] = $rowCommandes['total_commande'];
        $array[$rowCommandes['id_commande']]['etat'] = $etatAffiche;
        $array[$rowCommandes['id_commande']]['commentaire'] = $rowCommandes['commentaireannulation_commande'];
        $array[$rowCommandes['id_commande']]['solde'] = number_format($rowCommandes['solde_commande'], 2, ',', ' ').'&nbsp;€';

        $array[$rowCommandes['id_commande']]['adressetravaux'] = $rowCommandes['adressetravaux_commande'];
        $array[$rowCommandes['id_commande']]['adresse'] = $rowCommandes['ruetravaux_commande'];
        $array[$rowCommandes['id_commande']]['codepostal'] = $rowCommandes['cptravaux_commande'];
        $array[$rowCommandes['id_commande']]['ville'] = $rowCommandes['villetravaux_commande'];

        $client = getClientById($connexion, $rowCommandes['id_client']);
        $array[$rowCommandes['id_commande']]['tel'] = $client['tel'];
        $array[$rowCommandes['id_commande']]['telportable'] = $client['telportable'];
    }

    return $array;
}

function getPrestations($connexion, $fiche = 0) {
    $requetePrestations = "SELECT * FROM prestations WHERE fiche_renseignement_prestation = '".$fiche."' ORDER BY ref_prestation ASC";
    if($fiche == 0){
        $requetePrestations = "SELECT * FROM prestations ORDER BY ref_prestation ASC";
    }
    $resPrestations = $connexion->query($requetePrestations);
    $array = [];
    while ($rowPrestations = $resPrestations->fetch(PDO::FETCH_ASSOC)) {
        $tva = "";
        $arrayTVA = explode('|', $rowPrestations['tva_prestation']);
        foreach ($arrayTVA as $key => $value) {
            if ($key === 0) {
                $tva = $value . "%";
            } else {
                $tva .= "|" . $value . "%";
            }
        }

        $array[$rowPrestations['id_prestation']]['designationSimple'] = $rowPrestations['designation_prestation'];
        $array[$rowPrestations['id_prestation']]['designationComplementaire'] = $rowPrestations['designation_complementaire_prestation'];
        $array[$rowPrestations['id_prestation']]['prixHt'] = $rowPrestations['prix_ht_prestation'];
        $array[$rowPrestations['id_prestation']]['prixTtc'] = $rowPrestations['prix_ttc_prestation'];
        $array[$rowPrestations['id_prestation']]['tva'] = $tva;
        $array[$rowPrestations['id_prestation']]['reference'] = $rowPrestations['ref_prestation'];
        $array[$rowPrestations['id_prestation']]['ficherenseignement'] = $rowPrestations['fiche_renseignement_prestation'];
    }

    return $array;
}

function getPrestationById($connexion, $id) {
    $requete = "SELECT * FROM prestations WHERE id_prestation = '" . $id . "'";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $arrayPrestation['designationSimple'] = $row['designation_prestation'];
    $arrayPrestation['designationComplementaire'] = $row['designation_complementaire_prestation'];
    $arrayPrestation['montant'] = $row['prix_ht_prestation'];
    $arrayPrestation['tva'] = $row['tva_prestation'];
    $arrayPrestation['code'] = $row['ref_prestation'];

    return $arrayPrestation;
}

function getPrestationByIds($connexion, $id) {
    $arrayPrestation = [];
    $requete = "SELECT * FROM prestations WHERE id_prestation IN (" . implode(',', $id) . ")";
    $res = $connexion->query($requete);
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $arrayPrestation[$row['id_prestation']]['designationSimple'] = $row['designation_prestation'];
        $arrayPrestation[$row['id_prestation']]['designationComplementaire'] = $row['designation_complementaire_prestation'];
        $arrayPrestation[$row['id_prestation']]['montant'] = $row['prix_ht_prestation'];
        $arrayPrestation[$row['id_prestation']]['tva'] = $row['tva_prestation'];
        $arrayPrestation[$row['id_prestation']]['code'] = $row['ref_prestation'];
    }

    return $arrayPrestation;
}

function getClientById($connexion, $id) {
    $requete = "SELECT * FROM clients WHERE id_client = '" . $id . "'";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $arrayClient['nom'] = $row['nom_client'];
    $arrayClient['prenom'] = $row['prenom_client'];
    $arrayClient['societe'] = $row['societe_client'];
    $arrayClient['codepostal'] = $row['code_postal_client'];
    $arrayClient['tel'] = $row['numtel_client'];
    $arrayClient['telportable'] = $row['numportable_client'];

    return $arrayClient;
}

function getClients($connexion) {
    $requeteClients = "SELECT * FROM clients ORDER BY nom_client ASC, prenom_client";
    $resClients = $connexion->query($requeteClients);
    $array = [];
    while ($rowClients = $resClients->fetch(PDO::FETCH_ASSOC)) {
        $array[$rowClients['id_client']]['type'] = $rowClients['type_client'];
        $array[$rowClients['id_client']]['societe'] = $rowClients['societe_client'];
        $array[$rowClients['id_client']]['nom'] = $rowClients['nom_client'];
        $array[$rowClients['id_client']]['prenom'] = $rowClients['prenom_client'];
        $array[$rowClients['id_client']]['civilite'] = $rowClients['civilite_client'];
        $array[$rowClients['id_client']]['adresse'] = $rowClients['adresse_client'];
        $array[$rowClients['id_client']]['codepostal'] = $rowClients['code_postal_client'];
        $array[$rowClients['id_client']]['ville'] = $rowClients['ville_client'];
        $array[$rowClients['id_client']]['codenumtel'] = $rowClients['code_numtel_client'];
        $array[$rowClients['id_client']]['numtel'] = $rowClients['numtel_client'];
        $array[$rowClients['id_client']]['codenumportable'] = $rowClients['code_numportable_client'];
        $array[$rowClients['id_client']]['numportable'] = $rowClients['numportable_client'];
        $array[$rowClients['id_client']]['email'] = $rowClients['email_client'];

    }

    return $array;
}

function getDroitsPage($connexion, $laPage, $typeUtilisateur) {
    $nomPage = explode('/', $laPage);
    $nomPage = end($nomPage);
    $nomPage = explode('?', $nomPage);
    $nomPage = $nomPage[0];
    $nomPage = str_replace('.php', '', $nomPage);

    $requete = "SELECT * FROM pages WHERE nom_page = '" . $nomPage . "'";
    $res = $connexion->query($requete);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $listeDroits = explode(',', $row['droits_page']);
    foreach ($listeDroits as $value) {
        if ($typeUtilisateur == $value) {
            return true;
        }
    }

    return false;
}

function getChiffreAffaireParMois($connexion, $etat, $anneeCourante, $mois) {
    if ($etat == "Facturée") {
        $req = "SELECT SUM(CAST(total_commande as FLOAT)) AS total FROM commandes WHERE total_commande != '0' AND EXTRACT(YEAR FROM datefacture_commande) = '" . $anneeCourante . "' AND EXTRACT(MONTH FROM datefacture_commande) =  '" . $mois . "' AND isannulee_commande = '0'";
    } else if ($etat == "Payée") {
        $req = "SELECT SUM(CAST(total_commande as FLOAT)) AS total FROM commandes WHERE total_commande != '0' AND EXTRACT(YEAR FROM dateencaisse_commande) = '" . $anneeCourante . "' AND EXTRACT(MONTH FROM dateencaisse_commande) = '" . $mois . "' AND isannulee_commande = '0'";
    } else {
        if (strlen($mois) == 1) {
            $mois = '0' . $mois;
        }
        $req = "SELECT SUM(CAST(total_commande as FLOAT)) AS total FROM commandes WHERE total_commande != '0' AND date_commande LIKE '" . $anneeCourante . "-%' AND date_commande LIKE '%-" . $mois . "-%' AND isannulee_commande = '0'";
    }

    $res = $connexion->query($req);
    $res = $res->fetch(PDO::FETCH_ASSOC);

    return isset($res['total']) ? $res['total'] : 0;
}

function getMoisSA($mois) {
    $array[1] = 'janvier';
    $array[2] = 'fevrier';
    $array[3] = 'mars';
    $array[4] = 'avril';
    $array[5] = 'mai';
    $array[6] = 'juin';
    $array[7] = 'juillet';
    $array[8] = 'aout';
    $array[9] = 'septembre';
    $array[10] = 'octobre';
    $array[11] = 'novembre';
    $array[12] = 'decembre';

    return $array[$mois];
}

function getMois($mois) {
    $array[1] = 'janvier';
    $array[2] = 'février';
    $array[3] = 'mars';
    $array[4] = 'avril';
    $array[5] = 'mai';
    $array[6] = 'juin';
    $array[7] = 'juillet';
    $array[8] = 'aout';
    $array[9] = 'septembre';
    $array[10] = 'octobre';
    $array[11] = 'novembre';
    $array[12] = 'décembre';

    return $array[$mois];
}

function getParametre($connexion) {
    $requeteParametre = "SELECT * FROM parametres WHERE id_parametre = 1";
    $resParamatre = $connexion->query($requeteParametre);
    $rowParametre = $resParamatre->fetch(PDO::FETCH_ASSOC);

    $array['host'] = $rowParametre['host_parametre'];
    $array['email'] = $rowParametre['email_parametre'];
    $array['password'] = $rowParametre['passwordemail_parametre'];
    $array['template'] = $rowParametre['templateemail_parametre'];
    $array['exercice'] = $rowParametre['exerciceactif_parametre'];

    return $array;
}

function getExercices($connexion) {
    $arrayParametre = getParametre($connexion);
    $req = "SELECT * FROM exercices ORDER BY annee_exercice DESC";
    $res = $connexion->query($req);
    $array = [];

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $array[$row['id_exercice']]['id'] = $row['id_exercice'];
        $array[$row['id_exercice']]['nom'] = $row['nom_exercice'];
        $array[$row['id_exercice']]['annee'] = $row['annee_exercice'];
        if ($arrayParametre['exercice'] == $row['id_exercice']) {
            $array[$row['id_exercice']]['actif'] = 1;
        } else {
            $array[$row['id_exercice']]['actif'] = 0;
        }
    }

    return $array;
}

function getCivilite($connexion, $nom) {
    $req = "SELECT * FROM civilite WHERE nom_civilite LIKE '%" . pg_escape_string(ucfirst(mb_strtolower($nom))) . "%'";
    $res = $connexion->query($req);
    $row = $res->fetch(PDO::FETCH_ASSOC);

    $array['id'] = $row['id_civilite'];
    $array['nom'] = $row['nom_civilite'];

    return $array;
}

function getAllExercices($connexion) {
    $req = "SELECT * FROM exercices";
    $res = $connexion->query($req);
    $array = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $array[$row['id_exercice']]['nom'] = $row['nom_exercice'];
        $array[$row['id_exercice']]['annee'] = $row['annee_exercice'];
    }

    return $array;
}

/**
 * @param $string
 * @return false|string
 * NFD (Normalization Form D) : effectue une décomposition canonique pour obtenir la forme décomposée du caractère (ex: c + cédille)
 * [:Nonspacing Mark:] Remove : ici, la transformation « Remove » ne s’appliquera qu’aux caractères faisant partie de la catégorie Unicode « Nonspacing Mark ». Hors, tous les caractères combinants en font partie : puisqu’ils se lient au caractère qui les précède, ils n’occupent pas leur propre espace !
 * NFC : ici, on recompose les caractères qui restent précédemment décomposés par NFD. (ex : les syllabes de l’alphabet hangeul peuvent également être encodées par une combinaison de jamos).
 */
function removeAccentsAndDiacriticsToString($string) {
    return \Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC')->transliterate($string);
}

function stringToGoodStringFloat($string) {
    $res = str_replace([' ', ','], ['', '.'], ltrim($string, '0'));
    if (empty($res)) {
        $res = '0';
    }

    return $res;
}

function prepareToStringComparison($string) {
    $string = removeAccentsAndDiacriticsToString($string);
    $string = strtolower($string);
    return $string;
}

function isProd() {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else
        $link = "http";

    $link .= "://";
    $link .= $_SERVER['HTTP_HOST'];
    $link .= $_SERVER['REQUEST_URI'];

    if (substr_count($link, 'dev-gestion') == 0) {
        return true;
    } else {
        return false;
    }
}

/** BEGIN DEMANDES */
function getDemandes($connexion, $statut, $exercice) {
    $req = "SELECT * FROM demandes WHERE statut_demande = '" . $statut . "' AND exercice_demande = '" . $exercice . "'";
    $res = $connexion->query($req);

    $array = array();

    $arrayClients = getClients($connexion);

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $array[$row['id_demande']]['id'] = $row['id_demande'];
        $array[$row['id_demande']]['date_demande'] = !empty($row['date_demande'])?date('d/m/Y', strtotime($row['date_demande'])):'';
        $array[$row['id_demande']]['date_a_envoyer'] = !empty($row['date_a_envoyer_demande'])?date('d/m/Y', strtotime($row['date_a_envoyer_demande'])):'';
        $array[$row['id_demande']]['responsable'] = $arrayClients[$row['id_client']]['nom'] . ' ' . $arrayClients[$row['id_client']]['prenom'];
        $array[$row['id_demande']]['numtel'] = $arrayClients[$row['id_client']]['numtel'];
        $array[$row['id_demande']]['email'] = $arrayClients[$row['id_client']]['email'];
        $array[$row['id_demande']]['date_visite'] = !empty($row['date_visite_demande'])?date('d/m/Y H:i', strtotime($row['date_visite_demande'])):'';
    }

    return $array;
}

/** END DEMANDES */

function encrypt($data, $key) {
    $method = 'aes-256-cbc';
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($method));
    $encrypted = openssl_encrypt($data, $method, $key, 0, $iv);
    return base64_encode($iv . $encrypted);
}

function decrypt($data, $key) {
    $method = 'aes-256-cbc';
    $data = base64_decode($data);
    $iv_length = openssl_cipher_iv_length($method);
    $iv = substr($data, 0, $iv_length);
    $encrypted = substr($data, $iv_length);
    return openssl_decrypt($encrypted, $method, $key, 0, $iv);
}

?>