<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $info = $contato->buscar($id);
    if (empty($info['email'])) {
        header("Location: /");
        exit;
    }
} else {
    header("Location: /");
    exit;
}
if (!empty($_POST['id'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $informacoes = $_POST['informacoes'];
    $grupo = $_POST['grupo'];
    $dt_nasc = $_POST['dt_nasc'];
    $profissao = $_POST['profissao'];
    if (isset($_FILES['foto'])) {
        $foto = $_FILES['foto'];
    } else {
        $foto = array();
    }
    $status = $_POST['status'];
    $id = $_POST['id'];

    if (!empty($email)) {
        $contato->editar($nome, $telefone, $email, $endereco, $informacoes, $grupo, $dt_nasc, $profissao, $foto, $status, $_GET['id']);
    }
    header("Location: /");
}
if(isset($_GET['id']) && !empty($_GET['id'])){
    $info = $contato->getContato($_GET['id']);
}else{
    ?>
        <script type="text/javascript">window.location.href="/";</script>
    <?php
    exit;
}
?>
<h1>Editar Contato</h1>

<form method="POST" enctype="multipart/form-data"><!--Permite adicionar imagens no form-->
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    Nome: <br>
    <input type="text" name="nome" value="<?php echo $info['nome']; ?>" /><br><br>
    Telefone: <br>
    <input type="text" name="telefone" value="<?php echo $info['telefone']; ?>" /><br><br>
    Email: <br>
    <input type="mail" name="email" value="<?php echo $info['email']; ?>" /><br><br>
    Endereço: <br>
    <input type="text" name="endereco" value="<?php echo $info['endereco']; ?>" /><br><br>
    Informações: <br>
    <input type="text" name="informacoes" value="<?php echo $info['informacoes']; ?>" /><br><br>
    Grupo: <br>
    <input type="text" name="grupo" value="<?php echo $info['grupo']; ?>" /><br><br>
    Data Nascimento: <br>
    <input type="date" name="dt_nasc" value="<?php echo $info['dt_nasc']; ?>" /><br><br>
    Profissão: <br>
    <input type="text" name="profissao" value="<?php echo $info['profissao']; ?>" /><br><br>
    Foto: <br>
    <input type="file" name="foto[]" multiple /><br><br>
    <div class="grupo">
        <div class="cabecalho">Foto Contato</div>
        <div class="corpo">
            <?php foreach ($info['foto'] as $fotos): ?>
                <div class="foto_item">
                    <img src="img/contatos/<?php echo $fotos['url']; ?>">
                    <a href="excluir_foto.php?id=<?php $fotos['id']; ?>">Excluir Imagem</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    Status: <br>
    <input type="text" name="status" value="<?php echo $info['status']; ?>" /><br><br>
    <input type="submit" name="btAlterar" value="ALTERAR" />
</form>