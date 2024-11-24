<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <!-- Link para o arquivo CSS -->
    <link rel="stylesheet" href="../css/duvidas.css">
    <!-- Link para o arquivo JavaScript -->
    <script src="../js/cadastrarDuvidas.js" defer></script>
    <!-- Link para os icones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="div_container">
            <h2>Precisa de ajuda?</h2>
            <p>Se precisar de ajuda, não hesite em nos chamar pelos meios de contato abaixo, ficaremos felizes em responder você!</p>
            <div class="contact-section">
                <div class="contact-info">
                    <h3>Entre em Contato, estamos disponiveis de diversas formas!</h3>
                    <div><i class="fa-brands fa-whatsapp"></i> WhatsApp: +55 (11) 99999-9999</div>
                    <div><i class="fa-regular fa-envelope"></i> E-mail: CareTones@gmail.com</div>
                    <div><i class="fa-brands fa-instagram"></i> Instagram: @CareTones</div>
                    <div><i class="fa-brands fa-facebook"></i> Facebook: @CareTones</div>
                    <!-- Div para exibir a mensagem de resposta -->
                <div id="mensagemResposta"></div>
                </div>
                <form class="contact-form" method="POST" id="formDuvida">
                    <h3>...ou nos mande uma mensagem</h3>
                    <label for="nome"><i class="fas fa-user"></i> Nome completo</label>
                    <input type="text" id="nome" name="nome" required>
                    
                    <label for="telefone"><i class="fa-solid fa-phone"></i> Telefone</label>
                    <input type="text" id="telefone" name="telefone" required>
                    
                    <label for="objetivo"><i class="fas fa-bullseye"></i> Objetivo</label>
                    <input type="text" id="objetivo" name="objetivo" required>
                    
                    <label for="mensagem">Mensagem</label>
                    <textarea id="mensagem" name="mensagem" required></textarea>
                    <button type="button" id="button-duvida" onclick="enviarDuvida()">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>