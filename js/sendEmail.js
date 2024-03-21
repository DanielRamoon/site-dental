const nodemailer = require("nodemailer");
const config = require("./config");

// Criar um objeto de transporte reutilizável usando o transporte SMTP
let transporter = nodemailer.createTransport(config.email);

// Função para enviar o e-mail
async function sendEmail(nome, email, whatsapp, celular) {
  try {
    // Configurar o e-mail
    let info = await transporter.sendMail({
      from: `"Seu Nome" <${config.email.auth.user}>`, // Remetente
      to: config.email.auth.user, // Destinatário
      subject: "Novo formulário de contato", // Assunto
      html: `
                <p>Nome: ${nome}</p>
                <p>Email: ${email}</p>
                <p>WhatsApp: ${whatsapp}</p>
                <p>Celular: ${celular}</p>
            `,
    });

    console.log("E-mail enviado: %s", info.messageId);
  } catch (error) {
    console.error("Erro ao enviar o e-mail:", error);
  }
}

module.exports = sendEmail;
