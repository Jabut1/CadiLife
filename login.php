<?php
    session_start();

    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) 
    {
        include_once('config.php');
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $sql = "SELECT * FROM usuarios WHERE email = '$email' and senha = '$senha'";

        $result = $conexao->query($sql);

        if(mysqli_num_rows($result) < 1) {
            header('Location: login.html?erro=1');
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
        } else {
            $usuario = $result->fetch_assoc(); 
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['senha'] = $usuario['senha'];
            $_SESSION['nome'] = $usuario['nome'];
            header('Location: relatorio.php');
        }
    }else {
        header('Location: login.html');
    }
    
?>