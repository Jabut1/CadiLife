<?php 
session_start();
        
        // Verifica se o usuário está logado
        if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: login.html');
            exit;
        }

        include_once('config.php');
        
        // Recupera o ID e nome do usuário
        $email = $_SESSION['email'];
        $sql_usuario = "SELECT id, nome FROM usuarios WHERE email = '$email'";
        $usuario = $conexao->query($sql_usuario)->fetch_assoc();
        
        // Se o usuário não for encontrado
        if (!$usuario) {
            header('Location: login.html');
            exit;
        }
        
        $usuario_id = $usuario['id'];
        $nome = $usuario['nome'];
         $sql_dados = "SELECT * FROM dados_saude WHERE usuario_id = '$usuario_id' ORDER BY data DESC ";
        $dados = $conexao->query($sql_dados)->fetch_all(MYSQLI_ASSOC);

        $filtro = $_GET['filtro'] ?? '';

        if ($filtro === 'mais_antigo') {
            $sql_dados = "SELECT * FROM dados_saude WHERE usuario_id = '$usuario_id' ORDER BY data ASC";
        } elseif ($filtro === 'mais_recente') {
            $sql_dados = "SELECT * FROM dados_saude WHERE usuario_id = '$usuario_id' ORDER BY data DESC";
        }

        $dados = $conexao->query($sql_dados)->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <title>Todos dados</title>


</head>
<body  bgcolor="#F0F8FF">
    <a href="relatorio.php" class="voltar">Voltar</a> 

    <form method="GET" class="filtros">
        <button type="submit" name="filtro" class="filtro" value="mais_recente">Mais Recente</button>
        <button type="submit" name="filtro" class="filtro" value="mais_antigo">Mais Antigo</button>
    </form>
    <table border="0">
            <tr>
                <th>Data</th>
                <th>Peso (kg)</th>
                <th>Pressão</th>
                <th>Sono (h)</th>
                <th>Glicose (mg/dL)</th>
            </tr>
            <?php foreach ($dados as $linha): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($linha['data'])) ?></td>
                <td><?= htmlspecialchars($linha['peso']) . ' kg'?></td>
                <td><?= htmlspecialchars($linha['pressao']) . ' mmHg'?></td>
                <td><?= htmlspecialchars($linha['sono']) . ' h'?></td>
                <td><?= htmlspecialchars($linha['glicose']) . ' mg/dL'?></td>
            </tr>
        <?php endforeach; ?>
        </table>
</body>
</html>
<style>
    * {
    margin: 0;
    padding: 30px;
    font-family: "Roboto";
}
    .voltar {
    font-family: sans-serif;
    position: absolute;
    top: 20px;
    left: 20px;
    text-decoration: none;
    background-color: rgb(133, 133, 133);
    padding: 15px;
    text-align:center;
    width: 4%;
    border-radius: 10px;
    color: white;

    font-size: medium;
    cursor: pointer;
}

.voltar:hover{
    background-color: rgb(85, 85, 85);
    transition: 0.5s all;

}
.filtro {
    position: relative;
    top: 25px;
    left: 300px;
    background-color: #6db5e6;
    padding: 15px;
    text-align:center;
    width: 8%;
    border-radius: 10px;
    color: white;
    border: 0;
    font-size: medium;
    cursor: pointer;
}

.filtro:hover{
    background-color: rgb(52, 113, 138);
    transition: 0.5s all;
}


table {
    width: 100%; /* Define uma largura para a tabela */
    max-width: 1100px; /* Largura máxima para responsividade */
    margin-left: auto;
    margin-right: auto;
    border-collapse: collapse; /* Remove espaços entre as bordas das células */
    margin-bottom: 20px; /* Espaçamento abaixo da tabela */
    box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Sombra sutil para a tabela */
    background-color: #fff; /* Fundo branco para a tabela */
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #DC143C; /* Cor de destaque para o cabeçalho da tabela, combinando com o menu */
    color: white; /* Texto branco para contraste */
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9; /* Linhas alternadas para melhor leitura */
}

table tr:hover {
    background-color: #f1f1f1; /* Efeito hover nas linhas */
}
</style>