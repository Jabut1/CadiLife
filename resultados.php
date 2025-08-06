<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

include_once('config.php');
$email = $_SESSION['email'];

// Pegando dados do usuário
$usuario = $conexao->query("SELECT id, nome, sobrenome, altura FROM usuarios WHERE email = '$email'")->fetch_assoc();
$usuario_id = $usuario['id'];
$nome = $usuario['nome'];
$altura = $usuario['altura'];
$sobrenome = $usuario['sobrenome'];

if (isset($_POST['atualizar_altura'])) {
    $nova_altura = $_POST['nova_altura'];
    $sql = "UPDATE usuarios SET altura = '$nova_altura' WHERE id = '$usuario_id'";
    $conexao->query($sql);
    header("Location: resultados.php");
    exit;
}
// Pegando os 10 últimos registros do usuário
$sql_dados = "SELECT * FROM dados_saude WHERE usuario_id = '$usuario_id' ORDER BY data DESC LIMIT 10";
$dados = $conexao->query($sql_dados)->fetch_all(MYSQLI_ASSOC);

// Ordena os dados da data mais antiga para a mais recente
usort($dados, function($a, $b) {
    return strtotime($a['data']) - strtotime($b['data']);
});

// Define registros mais antigo e mais recente
$mais_antigo = $dados[0];
$mais_recente = end($dados);

// Função para calcular o IMC
function imc($peso, $altura) {
    if ($altura <= 0) return 'Altura inválida';
    $valor = $peso / ($altura * $altura);
    if ($valor < 18.5) $class = 'Abaixo do peso';
    elseif ($valor < 25) $class = 'Normal';
    elseif ($valor < 30) $class = 'Sobrepeso';
    else $class = 'Obesidade';
    return number_format($valor, 2) . " (<span>$class</span>)";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Relatório de Saúde</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css?v=3">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>
<body bgcolor="#F0F8FF">
    <header>
        <div class="logo-container">
    <div class="logo-icon">
      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="20" cy="20" r="18" fill="#0089e0" fill-opacity="0.2" stroke="#0089e0" stroke-width="2"/>
        <path d="M20 10V30M10 20H30" stroke="#0089e0" stroke-width="3" stroke-linecap="round"/>
      </svg>
      <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10 20C10 13.3726 15.3726 8 22 8C28.6274 8 34 13.3726 34 20C34 26.6274 28.6274 32 22 32C15.3726 32 10 26.6274 10 20Z" fill="#005b96" fill-opacity="0.2" stroke="#005b96" stroke-width="2"/>
        <path d="M15 20H29M22 13V27" stroke="#005b96" stroke-width="3" stroke-linecap="round"/>
      </svg>
    </div>
                  <h1 class="logo"><span class="cadi"><h2>Cadi</h2></span><span class="life"><h2>Life</h2></span></h1>
               </div>

        <nav id="menu">
            <ul>
                <li><a href="relatorio.php">Relatório</a></li>
                <li><a href="plano.php">Plano</a></li>
                <li><a href="resultados.php">Resultados</a></li>
            </ul>
        </nav>
    </header>
    <div class="escrita">
    <h1 class="resultado">Veja o seu progresso dos últimos 7 dias.</h1> 
    <h2>Nome: <?php echo $nome;?> <?php echo $sobrenome;?></h2>
    <h2>Altura: <?php echo $altura; ?>m</h2>
    <form method="POST">
        <input type="number" step="0.01" class="nova_altura" name="nova_altura" id="nova_altura" min="0.1" required>
        <button type="submit" class="botao_altura" name="atualizar_altura">Alterar altura</button>
    </form> <br />
    
</div>

    <table>
    <tr>
        <th>Propriedade</th>
        <th>Antes</th>
        <th>Depois</th>
    </tr>
    <tr>
        <th>Peso</th>
        <td><?php echo htmlspecialchars($mais_antigo['peso']) . ' kg'; ?></td>
        <td style="color: <?php echo ($mais_recente['peso'] < $mais_antigo['peso']) ? 'green' : 'red'; ?>">
            <?php echo htmlspecialchars($mais_recente['peso']) . ' kg'; ?>
        </td>
    </tr>

    <tr>
    <th>Pressão</th>
    <td><?php echo htmlspecialchars($mais_antigo['pressao']) . ' mmHg'; ?></td>
    <td style="color: <?php
        $ideal = 120; // Pressão ideal
        $antes = abs($mais_antigo['pressao'] - $ideal);
        $depois = abs($mais_recente['pressao'] - $ideal);
        echo ($depois < $antes) ? 'green' : 'red';
    ?>">
        <?php echo htmlspecialchars($mais_recente['pressao']) . ' mmHg'; ?>
    </td>
</tr>

    <tr>
        <th>Sono</th>
        <td><?php echo htmlspecialchars($mais_antigo['sono']) . ' h'; ?></td>
        <td style="color: <?php echo ($mais_recente['sono'] > $mais_antigo['sono']) ? 'green' : 'red'; ?>">
            <?php echo htmlspecialchars($mais_recente['sono']) . ' h'; ?>
        </td>
    </tr>

    <tr>
    <th>Glicose</th>
    <td><?php echo htmlspecialchars($mais_antigo['glicose']) . ' mg/dL'; ?></td>
    <td style="color: <?php
        $ideal_glicose = 100; // Valor ideal aproximado
        $dist_antes = abs($mais_antigo['glicose'] - $ideal_glicose);
        $dist_depois = abs($mais_recente['glicose'] - $ideal_glicose);
        echo ($dist_depois < $dist_antes) ? 'green' : 'red';
    ?>">
        <?php echo htmlspecialchars($mais_recente['glicose']) . ' mg/dL'; ?>
    </td>
</tr>

    <tr>
        <th>IMC</th>
        <td><?php echo imc($mais_antigo['peso'], $altura); ?></td>
        <td style="color: <?php
            $imcAntes = $mais_antigo['peso'] / ($altura * $altura);
            $imcDepois = $mais_recente['peso'] / ($altura * $altura);
            $distAntes = abs($imcAntes - 22); // ideal ~22
            $distDepois = abs($imcDepois - 22);
            echo ($distDepois < $distAntes) ? 'green' : 'red';
        ?>">
            <?php echo imc($mais_recente['peso'], $altura); ?>
        </td>
    </tr>
</table>
</body>
</html>
