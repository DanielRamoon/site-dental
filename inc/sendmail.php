<?php

require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/class.smtp.php');

$mail = new PHPMailer();

//$mail->SMTPDebug = 3; // Ativar saída de depuração detalhada
$mail->isSMTP(); // Definir o mailer para usar SMTP
$mail->Host = 'smtp.gmail.com'; // Especifique o servidor SMTP principal e de backup
$mail->SMTPAuth = true; // Habilitar autenticação SMTP
$mail->Username = 'seu_email@gmail.com'; // Nome de usuário SMTP (seu e-mail Gmail)
$mail->Password = 'sua_senha'; // Senha SMTP (senha do seu e-mail Gmail)
$mail->SMTPSecure = 'tls'; // Habilitar criptografia TLS, 'ssl' também é aceito
$mail->Port = 587; // Porta TCP para se conectar

$message = "";
$status = "false";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['form_name'] != '' && $_POST['form_email'] != '' && $_POST['form_message'] != '') {

        $name = $_POST['form_name'];
        $email = $_POST['form_email'];
        $subject = isset($_POST['form_subject']) ? $_POST['form_subject'] : 'Nova Mensagem | Formulário de Contato';
        $phone = isset($_POST['form_phone']) ? $_POST['form_phone'] : '';
        $message_body = $_POST['form_message'];

        $botcheck = $_POST['form_botcheck'];

        $toemail = 'danielramoon@gmail.com'; // Seu endereço de e-mail
        $toname = 'Daniel Ramoon'; // Seu nome

        if ($botcheck == '') {

            $mail->SetFrom($email, $name);
            $mail->AddReplyTo($email, $name);
            $mail->AddAddress($toemail, $toname);
            $mail->Subject = $subject;

            $name = isset($name) ? "Nome: $name<br><br>" : '';
            $email = isset($email) ? "Email: $email<br><br>" : '';
            $phone = isset($phone) ? "Telefone/WhatsApp: $phone<br><br>" : '';
            $message_body = isset($message_body) ? "Mensagem: $message_body<br><br>" : '';

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>Este formulário foi enviado de: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = "$name $email $phone $message_body $referrer";

            $mail->MsgHTML($body);
            $sendEmail = $mail->Send();

            if ($sendEmail == true) :
                $message = 'Recebemos sua mensagem com <strong>sucesso</strong> e entraremos em contato assim que possível.';
                $status = "true";
            else :
                $message = 'O e-mail <strong>não pôde</strong> ser enviado devido a algum erro inesperado. Por favor, tente novamente mais tarde.<br /><br /><strong>Motivo:</strong><br />' . $mail->ErrorInfo . '';
                $status = "false";
            endif;
        } else {
            $message = 'Bot <strong>detectado</strong>. Limpe-se, Botster!';
            $status = "false";
        }
    } else {
        $message = 'Por favor, <strong>preencha todos</strong> os campos e tente novamente.';
        $status = "false";
    }
} else {
    $message = 'Ocorreu um erro <strong>inesperado</strong>. Por favor, tente novamente mais tarde.';
    $status = "false";
}

$status_array = array('message' => $message, 'status' => $status);
echo json_encode($status_array);
?>