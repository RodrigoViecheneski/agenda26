<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

if (!empty($_POST['email'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $informacoes = $_POST['informacoes'];
    $grupo = $_POST['grupo'];
    $dt_nasc = $_POST['dt_nasc'];
    $profissao = $_POST['profissao'];
    //$foto = $_POST['foto'];
    $status = $_POST['status'];
    $contato->adicionar($email, $nome, $telefone, $endereco, $informacoes, $grupo, $dt_nasc, $profissao, $status);
    //print_r($contato);
    //exit;
    header('Location: index.php');
} else {
    echo '<script type="text/javascript">alert("Email já cadastrado!");</script>';
}
