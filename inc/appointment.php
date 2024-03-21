<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = EMAIL_SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_SMTP_USERNAME;
        $mail->Password = EMAIL_SMTP_PASSWORD;
        $mail->SMTPSecure = EMAIL_SMTP_SECURE;
        $mail->Port = EMAIL_SMTP_PORT;

        $mail->setFrom(EMAIL_SMTP_USERNAME, 'Daniel');
        $mail->addAddress(EMAIL_SMTP_USERNAME);

        $mail->isHTML(false);
        $mail->Subject = 'Novo formulário de contato';
        $mail->Body = "Nome: $nome\nWhatsApp: $whatsapp\nEmail: $email\nCelular: $celular";

        $mail->send();
        echo "E-mail enviado com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
    }
} else {
    echo "Acesso não autorizado.";
}
?>