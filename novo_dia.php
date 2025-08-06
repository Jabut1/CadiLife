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

        if (isset($_POST['inserir'])) {
            $sql_inserir = "INSERT INTO dados_saude (usuario_id, data, peso, pressao, sono, glicose)
                            VALUES ('$usuario_id', '{$_POST['data']}', '{$_POST['peso']}', '{$_POST['pressao']}', '{$_POST['sono']}', '{$_POST['glicose']}')";
            $conexao->query($sql_inserir);
            header("Location: relatorio.php");
            exit;
        }

        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inserir Dados de Saúde</title>
</head>

<body  bgcolor="#F0F8FF">

        <a href="relatorio.php" class="voltar">Voltar</a> 

    <div class="form-container">
        <section class="header"><h2>Inserir novo dia</h2></section>
        <form method="POST">
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" id="data" name="data" required>
            </div>

            <div class="form-group">
                <label for="peso">Peso (kg)</label>
                <input type="text" id="peso" name="peso" step="0.01" min="0" max="500" required>
            </div>

            <div class="form-group">
                <label for="pressao">Pressão (mmHg)</label>
                <input type="text" id="pressao" name="pressao" pattern="\d{2,3}/\d{2,3}" placeholder="ex: 120/80" required>
            </div>
           
            <div class="form-group">
                <label for="sono">Sono</label>
                <input type="text" id="sono" name="sono" min="0" max="24" required>
            </div>
            <div class="form-group">
                <label for="glicose" >Glicose (mg/dL)</label>
                <input type="text" id="glicose" name="glicose" min="0" max="500" required>
            </div>
            <button type="submit" name="inserir" class="confirm-button" >Confirmar</button>
        </form>
    </div>
    <div class="box">
       
    </div>
 
</body>
</html>

    <style>
        body {
            font-family: sans-serif;
            background-color: #F0F8FF; /* Cor de fundo cinza claro da imagem */
            display: flex;
            justify-content: center;
            align-items: flex-start; /* Alinha o formulário ao topo */
            padding-top: 120px; /* Espaçamento do topo */
            margin: 0;
 /* Garante que o body ocupe a tela toda se necessário */
        }
        .voltar {
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
            font-weight:bold;
            font-size: medium;
            cursor: pointer;
        }

        .voltar:hover{
        background-color: rgb(85, 85, 85);
        transition: 0.5s all;

      }
       
        

        .form-container {
            background-color: #cccccc; /* Cor de fundo do container do formulário */
            padding: 20px;
            border-radius: 8px;
            width: 300px; /* Largura aproximada do formulário na imagem */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
       
        .form-container h2 {
            font-size: 1.1em;
            color: #333;
            margin-top: 0;
            margin-bottom: 15px;
            font-weight: bold;
        }
         
     
            .header{
                background: linear-gradient(90deg, red 0%, red 100%, );
                padding: 2px;


                text-align: center;
                color: white;
                border-radius: 8%;
             
            }
       
        .form-group {
            margin-bottom: 15px;
        }
       
        .form-group label {
            display: block;
            font-size: 0.9em;
            color: #000; /* Cor preta para os rótulos */
            margin-bottom: 5px;
            font-weight: bold;
        }
       
        .form-group input {
            width: calc(100% - 16px); /* Ajusta a largura considerando o padding */
            padding: 8px;
            border: 1px solid white; /* Borda sutil como na imagem */
            border-radius: 4px;
            background-color: #f8f8f8; /* Fundo branco/cinza claro para os inputs */
            font-size: 0.9em;
        }
       
        .confirm-button {
            background-color: #00aeff; /* Cor azul do botão */
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            width: 100%; /* Botão ocupa toda a largura */
            text-align: center;
        }
       
        .confirm-button:hover {
            background-color: #008bcc; /* Um azul um pouco mais escuro para o hover */
        }
        </style>
</body>
</html>