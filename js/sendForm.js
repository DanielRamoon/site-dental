const express = require("express");
const bodyParser = require("body-parser");
const sendEmail = require("./sendEmail");

const app = express();

app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

app.post("/enviar-email", (req, res) => {
  const { nome, email, whatsapp, celular } = req.body;

  // Chamar a função para enviar o e-mail
  sendEmail(nome, email, whatsapp, celular);

  res.send("E-mail enviado com sucesso!");
});

app.listen(3000, () => {
  console.log("Servidor rodando na porta 3000");
});
