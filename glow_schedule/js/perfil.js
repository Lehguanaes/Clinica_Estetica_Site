// Função para pré-visualizar a imagem selecionada do perfil
    function previewProfilePic() {
        const input = document.getElementById("foto_atendente");
        const preview = document.getElementById("profile-pic-preview");

        const file = input.files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
