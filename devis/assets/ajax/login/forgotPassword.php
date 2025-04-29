<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('../../includes/connexion.php');
include('../../includes/fonctions/fonctionsgeneral.php');
include('../../includes/fonctions/fonctionslogin.php');

require '../../includes/phpmailer/src/Exception.php';
require '../../includes/phpmailer/src/PHPMailer.php';
require '../../includes/phpmailer/src/SMTP.php';

if(isAjax()) {
    if (isset($_POST['email'])) {
        $email = pg_escape_string($_POST['email']);

        if(loginExist($connexion, $email)){
            $mail = new PHPMailer();

            $cle = md5(time());
            reinitialisation($connexion, $email, $cle);
            $sujet = '[Groupe Colibri] Informations de connexion';

            $message = 'Bonjour,<br /><br />Pour réinitialiser vos informations de connexion, merci de cliquer sur ce lien :<br /><br />';
            if(isProd()) {
                $message .= 'https://gestion.groupe-colibri.fr/motdepasseoublie.php?q=' . $cle;
            }else{
                $message .= 'https://dev-gestion.groupe-colibri.fr/motdepasseoublie.php?q=' . $cle;
            }

            envoiEmail($connexion, $mail, $sujet, $email, $message);
            insertLog($connexion, '[REINITIALISATION] Demande de réinitialisation', $email);
        }
    }
}