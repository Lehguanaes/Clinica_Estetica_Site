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

    echo "<table>";
    echo "<tr>
            <th id='titulo_calendario'><span class='prev-next' onclick='carregarMes($mesAnterior, $anoAnterior)'>&lt;&lt;</span></th>
            <th id='titulo_calendario' colspan='5'>" . ucfirst($nomeMes) . " $anoAtual</th>
            <th id='titulo_calendario'><span class='prev-next' onclick='carregarMes($mesProximo, $anoProximo)'>&gt;&gt;</span></th>
        </tr>";
    echo "<tr>
            <th id='nome_dia'>Dom</th>
            <th id='nome_dia'>Seg</th>
            <th id='nome_dia'>Ter</th>
            <th id='nome_dia'>Qua</th>
            <th id='nome_dia'>Qui</th>
            <th id='nome_dia'>Sex</th>
            <th id='nome_dia'>Sáb</th>
        </tr>";
    echo "<tr>";
    
    for ($i = 0; $i < $diaDaSemana; $i++) {
        echo "<td></td>";
    }

    for ($dia = 1; $dia <= $diasNoMes; $dia++) {
        if (($i + $dia - 1) % 7 == 0) {
            echo "</tr><tr>";
        }

        $data = $anoAtual . '-' . str_pad($mesAtual, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dia, 2, '0', STR_PAD_LEFT);
        $hoje = date('Y-m-d');
        
        if ($data < $hoje) {
            echo "<td class='date-select' style='color: #ccc;'>$dia</td>";
        } elseif ($dia == $diaAtual && $mesAtual == date('m') && $anoAtual == date('Y')) {
            echo "<td class='today date-select' onclick=\"selecionarData('$data', this)\">$dia</td>";
        } else {
            echo "<td class='date-select' onclick=\"selecionarData('$data', this)\">$dia</td>";
        }
    }

    echo "</tr>";
    echo "</table>";
}
?>
