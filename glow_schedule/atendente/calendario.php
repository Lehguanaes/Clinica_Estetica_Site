<?php
if (isset($_GET['mes']) && isset($_GET['ano'])) {
    date_default_timezone_set('America/Sao_Paulo');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');

    $mesAtual = $_GET['mes'];
    $anoAtual = $_GET['ano'];
    $diaAtual = date('j');
    $primeiroDiaMes = mktime(0, 0, 0, $mesAtual, 1, $anoAtual);
    $diasNoMes = date('t', $primeiroDiaMes);
    $diaDaSemana = date('w', $primeiroDiaMes);
    $nomeMes = strftime('%B', $primeiroDiaMes);

    // Calcula o mês e ano anteriores e próximos
    $mesAnterior = $mesAtual - 1;
    $mesProximo = $mesAtual + 1;
    if ($mesAnterior < 1) {
        $mesAnterior = 12;
        $anoAnterior = $anoAtual - 1;
    } else {
        $anoAnterior = $anoAtual;
    }
    if ($mesProximo > 12) {
        $mesProximo = 1;
        $anoProximo = $anoAtual + 1;
    } else {
        $anoProximo = $anoAtual;
    }

    echo "<table class='table table-bordered'>";
    echo "<tr>
            <th><span class='prev-next' onclick='carregarMes($mesAnterior, $anoAnterior)'>&lt;&lt;</span></th>
            <th colspan='5'>" . ucfirst($nomeMes) . " $anoAtual</th>
            <th><span class='prev-next' onclick='carregarMes($mesProximo, $anoProximo)'>&gt;&gt;</span></th>
          </tr>";
    echo "<tr>
            <th>Dom</th>
            <th>Seg</th>
            <th>Ter</th>
            <th>Qua</th>
            <th>Qui</th>
            <th>Sex</th>
            <th>Sáb</th>
          </tr>";
    echo "<tr>";

    // Preenche os primeiros dias vazios da semana
    for ($i = 0; $i < $diaDaSemana; $i++) {
        echo "<td></td>";
    }

    // Preenche os dias do mês
    for ($dia = 1; $dia <= $diasNoMes; $dia++) {
        if (($i + $dia - 1) % 7 == 0) {
            echo "</tr><tr>";
        }

        // Define a data no formato YYYY-MM-DD
        $data = $anoAtual . '-' . str_pad($mesAtual, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dia, 2, '0', STR_PAD_LEFT);

        // Verifica se é o dia atual para adicionar a classe "today"
        $class = ($dia == $diaAtual && $mesAtual == date('n') && $anoAtual == date('Y')) ? 'today' : '';

        echo "<td class='date-select $class' onclick=\"selecionarData('$data', this)\">$dia</td>";
    }

    echo "</tr>";
    echo "</table>";
}
?>