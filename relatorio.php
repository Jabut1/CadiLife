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
        
        // Inserção de novo registro de saúde
        if (isset($_POST['inserir'])) {
            $sql_inserir = "INSERT INTO dados_saude (usuario_id, data, peso, pressao, sono, glicose)
                            VALUES ('$usuario_id', '{$_POST['data']}', '{$_POST['peso']}', '{$_POST['pressao']}', '{$_POST['sono']}', '{$_POST['glicose']}')";
            $conexao->query($sql_inserir);
            header("Location: relatorio.php");
            exit;
        }

        // Buscar os 7 últimos registros de saúde
        $sql_dados = "SELECT * FROM dados_saude WHERE usuario_id = '$usuario_id' ORDER BY data DESC LIMIT 10";
        $dados = $conexao->query($sql_dados)->fetch_all(MYSQLI_ASSOC);

        // Ordenar para garantir que o mais recente apareça na última linha
        usort($dados, function($a, $b) {
            return strtotime($a['data']) - strtotime($b['data']);
        });

        
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

        <h1 class="escrita">Olá <?php echo $nome; ?>! Este o resumo da sua saúde nos últimos 10 dias registrados.</h1><br />
        <table border="0">
            <tr>
                <th>Data</th>
                <th>Peso (kg)</th>
                <th>Pressão</th>
                <th>Sono (h)</th>
                <th>Glicose (mg/dL)</th>
            </tr>
            <?php
        for ($i = 0; $i < 10; $i++):
            if (isset($dados[$i])) {
                $linha = $dados[$i];
                echo "<tr>
                    <td>". date('d/m/Y', strtotime($linha['data'])) ."</td>
                    <td>{$linha['peso']} kg</td>
                    <td>{$linha['pressao']} mmHg</td>
                    <td>{$linha['sono']} h</td>
                    <td>{$linha['glicose']} mg/dL</td>
                </tr>";
            } else {
                // Linha vazia se não tiver dado
                echo "<tr>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                    <td>---</td>
                </tr>";
            }
        endfor;
        ?>
        </table>
    <div class="botoes_dados">
        <a href="novo_dia.php" class="dados">Novo dia</a>
        <a href="todos_dados.php" class="dados">Todos dados</a>
    </div>

    </body>
    </html>