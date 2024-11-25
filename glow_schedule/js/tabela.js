// Filtro tabela de clientes
$(document).ready(function () {
    // Função para buscar clientes
    function buscarClientes(query = '') {
        $.ajax({
            url: "buscarClientes.php", // Arquivo PHP que processa a consulta
            method: "POST",
            data: { search: query },
            success: function (data) {
                $("#results").html(data);
            },
            error: function () {
                alert("Erro ao carregar os dados.");
            }
        });
    }

    // Chamada inicial para carregar todos os clientes
    buscarClientes();

    // Evento ao digitar no campo de busca
    $("#search").on("keyup", function () {
        const query = $(this).val().trim();
        buscarClientes(query);
    });
});

// Filtro tabela de atendentes
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-atendentes");
    const tabela = document.getElementById("atendentesTabela").getElementsByTagName("tbody")[0];
    const noResultsMessage = document.getElementById("noResultsMessage");
    
        // Esconde a mensagem ao carregar a página
        noResultsMessage.style.display = "none";
    
        searchInput.addEventListener("input", function () {
            const filter = searchInput.value.toLowerCase();
            const rows = tabela.getElementsByTagName("tr");
            let hasResults = false;
    
            for (let i = 0; i < rows.length; i++) {
                const cpf = rows[i].getElementsByTagName("td")[1]; // Coluna do CPF
                const nome = rows[i].getElementsByTagName("td")[2]; // Coluna do Nome
    
                if (cpf && nome) {
                    const cpfText = cpf.textContent || cpf.innerText;
                    const nomeText = nome.textContent || nome.innerText;
    
                    if (cpfText.toLowerCase().indexOf(filter) > -1 || nomeText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = ""; // Exibe a linha
                        hasResults = true;
                    } else {
                        rows[i].style.display = "none"; // Oculta a linha
                    }
                }
            }
    
            // Exibe ou oculta a mensagem de "Nenhum atendente encontrado"
            if (filter.trim() === "") {
                noResultsMessage.style.display = "none"; // Não exibe mensagem se o filtro estiver vazio
            } else {
                noResultsMessage.style.display = hasResults ? "none" : "block";
            }
    });
});    

// Filtro tabela de esteticistas
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-esteticistas");
    const tabela = document.getElementById("esteticistasTabela").getElementsByTagName("tbody")[0];
    const noResultsMessage = document.getElementById("noResultsMessage");
    
        // Esconde a mensagem ao carregar a página
        noResultsMessage.style.display = "none";
    
        searchInput.addEventListener("input", function () {
            const filter = searchInput.value.toLowerCase();
            const rows = tabela.getElementsByTagName("tr");
            let hasResults = false;
    
            for (let i = 0; i < rows.length; i++) {
                const cpf = rows[i].getElementsByTagName("td")[1]; // Coluna do CPF
                const nome = rows[i].getElementsByTagName("td")[2]; // Coluna do Nome
    
                if (cpf && nome) {
                    const cpfText = cpf.textContent || cpf.innerText;
                    const nomeText = nome.textContent || nome.innerText;
    
                    if (cpfText.toLowerCase().indexOf(filter) > -1 || nomeText.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = ""; // Exibe a linha
                        hasResults = true;
                    } else {
                        rows[i].style.display = "none"; // Oculta a linha
                    }
                }
            }
    
            // Exibe ou oculta a mensagem de "Nenhum Esteticista encontrado"
            if (filter.trim() === "") {
                noResultsMessage.style.display = "none"; // Não exibe mensagem se o filtro estiver vazio
            } else {
                noResultsMessage.style.display = hasResults ? "none" : "block";
            }
    });
});   

// Filtro tabela de procedimentos
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-procedimentos");
    const tabela = document.getElementById("procedimentosTabela").getElementsByTagName("tbody")[0];
    const noResultsMessage = document.getElementById("noResultsMessage");
    const rows = tabela.getElementsByTagName("tr");

    // Verifica se há procedimentos na tabela ao carregar a página
    const hasProcedures = rows.length > 0;
    noResultsMessage.style.display = hasProcedures ? "none" : "block";

    // Adiciona evento de input ao campo de busca
    searchInput.addEventListener("input", function () {
        const filter = searchInput.value.toLowerCase().trim(); // Normaliza o texto de busca
        let hasResults = false;

        for (let i = 0; i < rows.length; i++) {
            const nome = rows[i].getElementsByTagName("td")[1]; // Coluna do Nome do Procedimento (2ª coluna)

            if (nome) {
                const nomeText = nome.textContent || nome.innerText;

                // Verifica se o texto do procedimento contém o filtro
                if (nomeText.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = ""; // Exibe a linha
                    hasResults = true;
                } else {
                    rows[i].style.display = "none"; // Oculta a linha
                }
            }
        }

        // Mostra ou esconde a mensagem de "nenhum resultado encontrado"
        noResultsMessage.style.display = hasResults ? "none" : "block";
    });
});
