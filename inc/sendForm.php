<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST["nome"];
    $whatsapp = $_POST["whatsapp"];
    $email = $_POST["email"];
    $celular = $_POST["celular"];

    // Constrói o corpo do e-mail
    $mensagem = "Nome: " . $nome . "\n";
    $mensagem .= "WhatsApp: " . $whatsapp . "\n";
    $mensagem .= "Email: " . $email . "\n";
    $mensagem .= "Celular: " . $celular . "\n";

    // Imprime os dados do formulário para fins de depuração
    echo "<pre>";
    echo "Dados recebidos do formulário:\n";
    print_r($_POST);
    echo "</pre>";

    // Configurações adicionais do e-mail
    $destinatario = "danielramoon@gmail.com";
    $assunto = "Novo formulário de contato";

    // Envia o e-mail
    if (mail($destinatario, $assunto, $mensagem)) {
        echo "E-mail enviado com sucesso!";
    } else {
        echo "Erro ao enviar e-mail. Por favor, tente novamente mais tarde.";
    }
}
?>