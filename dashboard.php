<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #161D29;
            color: white;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow-y: auto;
        }

        #graficoSaldo {
            max-width: 600px;
            margin: 20px auto;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 10px;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            max-height: 80vh;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #333 #161D29;
        }

        .container::-webkit-scrollbar {
            width: 8px;
        }

        .container::-webkit-scrollbar-thumb {
            background-color: #333;
            border-radius: 4px;
        }

        .container::-webkit-scrollbar-track {
            background-color: #161D29;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        h2, h3 {
            color: #fff;
            font-size: 24px;
            font-weight: bold;
        }

        .btn-icon {
            padding: 5px 10px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div id="stars"></div>
    <div id="stars2"></div>
    <div id="stars3"></div>

    <div class="container mt-4">
        <h2 class="mb-4">Dashboard</h2>

        <canvas id="graficoSaldo"></canvas>

        <h3 class="mt-4">Lançamentos do Mês Selecionado</h3>
        <form method="post">
            <label for="mesSelecionado">Selecione o mês:</label>
            <select name="mesSelecionado" id="mesSelecionado" class="form-select">
                <?php
                $nomesMeses = array(
                    1 => 'Janeiro',
                    2 => 'Fevereiro',
                    3 => 'Março',
                    4 => 'Abril',
                    5 => 'Maio',
                    6 => 'Junho',
                    7 => 'Julho',
                    8 => 'Agosto',
                    9 => 'Setembro',
                    10 => 'Outubro',
                    11 => 'Novembro',
                    12 => 'Dezembro'
                );

                foreach ($nomesMeses as $numeroMes => $nomeMes) {
                    $selected = ($numeroMes == $mesSelecionado) ? "selected" : "";
                    echo "<option value='$numeroMes' $selected>$nomeMes</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary mt-2">Mostrar Lançamentos</button>
        </form>
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Conexão com o banco de dados
                    $pdo = new PDO("mysql:host=localhost;dbname=fluxo", "root", "");

                    $mesSelecionado = (isset($_POST['mesSelecionado'])) ? intval($_POST['mesSelecionado']) : date('n');
                
                    // Consulta SQL para obter os lançamentos do mês selecionado
                    $sqlLancamentosMes = "SELECT * FROM lancamentos WHERE MONTH(data) = :mesSelecionado";
                
                    // Preparar a consulta
                    $stmtLancamentosMes = $pdo->prepare($sqlLancamentosMes);
                
                    // Bind do parâmetro :mesSelecioanado com o valor adequado
                    $stmtLancamentosMes->bindParam(':mesSelecionado', $mesSelecionado, PDO::PARAM_INT);
                
                    // Executar a consulta
                    $stmtLancamentosMes->execute();
                
                    // Obtém os resultados em um array associativo
                    $resultadoLancamentosMes = $stmtLancamentosMes->fetchAll(PDO::FETCH_ASSOC);
                
                    // Calcula o saldo total
                    $saldoTotal = 0;
                
                    foreach ($resultadoLancamentosMes as $row) {
                        if ($row['tipo'] == 'entrada') {
                            $saldoTotal += $row['valor'];
                        } else {
                            $saldoTotal -= $row['valor'];
                        }
                    }

                    // Verifique se há resultados antes de usar foreach
                    if (!empty($resultadoLancamentosMes)) {
                        foreach ($resultadoLancamentosMes as $row) {
                            $tipo = $row['tipo'];
                            $cor = ($tipo == 'entrada') ? 'text-success' : 'text-danger';
                            echo "<tr>";
                            echo "<td>{$row['data']}</td>";
                            echo "<td>{$row['descricao']}</td>";
                            echo "<td class='$cor'>$tipo</td>";
                            echo "<td>{$row['valor']}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>Nenhum resultado encontrado.</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "Erro na consulta: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>

        <h3 class="mt-4">Saldo Total</h3>
        <p class="<?php echo $corSaldo; ?>">R$ <?php echo number_format($saldoTotal, 2, ',', '.'); ?></p>

        <div id="modalAdicionarEntrada" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Entrada</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAdicionarEntrada">
                            <div class="mb-3">
                                <label for="valorEntrada" class="form-label">Valor:</label>
                                <input type="number" step="0.01" class="form-control" id="valorEntrada" name="valorEntrada" required>
                            </div>
                            <div class="mb-3">
                                <label for="dataEntrada" class="form-label">Data:</label>
                                <input type="date" class="form-control" id="dataEntrada" name="dataEntrada" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricaoEntrada" class="form-label">Descrição:</label>
                                <input type="text" class="form-control" id="descricaoEntrada" name="descricaoEntrada" required>
                            </div>
                            <button type="submit" class="btn btn-success">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalAdicionarSaida" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Saída</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAdicionarSaida">
                            <div class="mb-3">
                                <label for="valorSaida" class="form-label">Valor:</label>
                                <input type="number" step="0.01" class="form-control" id="valorSaida" name="valorSaida" required>
                            </div>
                            <div class="mb-3">
                                <label for="dataSaida" class="form-label">Data:</label>
                                <input type="date" class="form-control" id="dataSaida" name="dataSaida" required>
                            </div>
                            <div class="mb-3">
                                <label for="descricaoSaida" class="form-label">Descrição:</label>
                                <input type="text" class="form-control" id="descricaoSaida" name="descricaoSaida" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Adicionar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalExcluirRegistro" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Excluir Registro</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formExcluirRegistro">
                            <div class="mb-3">
                                <label for="idRegistroExcluir" class="form-label">ID do Registro:</label>
                                <input type="number" class="form-control" id="idRegistroExcluir" name="idRegistroExcluir" required>
                            </div>
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <a href="home.php" class="btn btn-danger position-absolute top-0 end-0 m-4">
            <i class="fas fa-home"></i>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Configuração do gráfico de linha
        var ctx = document.getElementById('graficoSaldo').getContext('2d');
        var graficoSaldo = new Chart(ctx, {
            type: 'line', // Mudamos o tipo para linha
            data: {
                labels: <?php echo json_encode(array_values($nomesMeses)); ?>,
                datasets: [{
                    label: 'Entradas',
                    data: <?php echo json_encode(array_values($entradasPorMes)); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false // Removemos o preenchimento
                }, {
                    label: 'Saídas',
                    data: <?php echo json_encode(array_values($saidasPorMes)); ?>,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false // Removemos o preenchimento
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'R$ ' + value.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
                            }
                        }
                    }
                }
            }
        });

        // Função para abrir um modal pelo ID
        function abrirModal(id) {
            $("#" + id).modal("show");
        }

        // AJAX para adicionar entrada
        $("#formAdicionarEntrada").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "entradas.php", // Verifique se o URL está correto
                data: $(this).serialize(),
                success: function(response) {
                    $("#modalAdicionarEntrada").modal("hide");
                    location.reload();
                }
            });
        });

        // AJAX para adicionar saída
        $("#formAdicionarSaida").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "saidas.php", // Verifique se o URL está correto
                data: $(this).serialize(),
                success: function(response) {
                    $("#modalAdicionarSaida").modal("hide");
                    location.reload();
                }
            });
        });

        // AJAX para excluir registro
        $("#formExcluirRegistro").submit(function(event) {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "excluir_registro.php", // Verifique se o URL está correto
                data: $(this).serialize(),
                success: function(response) {
                    $("#modalExcluirRegistro").modal("hide");
                    location.reload();
                }
            });
        });
    </script>
</body>
</html>
