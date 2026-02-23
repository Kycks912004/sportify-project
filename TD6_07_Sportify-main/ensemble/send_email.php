<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\ensemble\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\ensemble\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\ensemble\PHPMailer\src\SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to_email = $_POST['to_email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com'; // Serveur SMTP d'Outlook
        $mail->SMTPAuth = true;
        $mail->Username = 'webdyna@outlook.fr'; // Remplacez par votre adresse e-mail Outlook
        $mail->Password = 'VTR123456.'; // Remplacez par votre mot de passe d'application
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinataires
        $mail->setFrom('webdyna@outlook.fr', 'Web Dyna');
        $mail->addAddress($to_email);

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($message);

        $mail->send();
        echo "<script>alert('Email envoyé avec succès.'); window.location.href='email_form.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Échec de l\'envoi de l\'email: {$mail->ErrorInfo}'); window.location.href='email_form.html';</script>";
    }
} else {
    echo "Méthode non autorisée.";
}
?>
