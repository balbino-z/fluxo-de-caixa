<?php
require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mesSelecionado = $_POST["mesSelecionado"];

    $consultaRegistros = "SELECT * FROM lancamentos WHERE MONTH(data) = :mes";
    $stmt = $conn->prepare($consultaRegistros);
    $stmt->bindParam(":mes", $mesSelecionado, PDO::PARAM_INT);
    $stmt->execute();
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($registros as $registro) {
        echo "<tr>";
        echo "<td>{$registro['data']}</td>";
        echo "<td>{$registro['descricao']}</td>";
        echo "<td>{$registro['tipo']}</td>";
        echo "<td>R$ {$registro['valor']}</td>";
        echo "</tr>";
    }
}
?>
