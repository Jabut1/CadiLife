<?php
include_once('config.php');

$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$sexo = $_POST['sexo'];
$altura = $_POST['altura'];
$senha = $_POST['senha'];


$sql_check = "SELECT id FROM usuarios WHERE email = '$email'";
$result_check = mysqli_query($conexao, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "<a href='cadastro.html' class='voltar'>Voltar</a> <br /> <br /> <br /> 
    <style>
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

}</style> 
"; 
    echo "<h2>Erro: Já existe um usuário cadastrado com este email.</h2>";
    exit;

} else {
    $result = mysqli_query($conexao, "INSERT INTO usuarios(nome, sobrenome, email, sexo, altura, senha) 
    VALUES('$nome', '$sobrenome', '$email', '$sexo', '$altura', '$senha')");

    header('Location: login.html');
    exit;
}
?>
