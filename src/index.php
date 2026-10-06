<?php
include 'classes/contatos.class.php';
$contato = new Contatos();
?>
<h1>Agenda Senac</h1>
<hr>
<button><a href="adicionarContato.php">ADICIONAR</a></button>
<button><a href="sair.php">SAIR</a></button>
<br><br>
<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>NOME</th>
        <th>TELEFONE</th>
        <th>EMAIL</th>
        <th>ENDEREÇO</th>
        <th>INFORMAÇÕES</th>
        <th>GRUPO</th>
        <th>NASCIMENTO</th>
        <th>PROFISSÃO</th>
        <th>FOTO</th>
        <th>STATUS</th>
        <th>AÇÕES</th>
    </tr>
    <?php
    $lista = $contato->getFoto();
    foreach ($lista as $item):
    ?>
        <tbody>
            <tr>
                <td><?php echo $item['id'] ?></td>
                <td><?php echo $item['nome'] ?></td>
                <td><?php echo $item['telefone'] ?></td>
                <td><?php echo $item['email'] ?></td>
                <td><?php echo $item['endereco'] ?></td>
                <td><?php echo $item['informacoes'] ?></td>
                <td><?php echo $item['grupo'] ?></td>
                <td><?php echo $item['dt_nasc'] ?></td>
                <td><?php echo $item['profissao'] ?></td>
                <td>
                    <?php if (!empty($item['url'])): ?>
                        <img src="img/contatos/<?php echo $item['url']; ?>" height="50px" border="0">
                    <?php else: ?>
                        <img src="img/default.png" height="50px" border="0">
                    <?php endif; ?>
                </td>
                <td><?php echo $item['status'] ?></td>
                <td>
                    <a href="editarContato.php?id=<?php echo $item['id']; ?>">EDITAR</a>
                    <a href="excluirContato.php?id=<?php echo $item['id'] ?>" onclick="return confirm('Você tem certeza que quer excluir este contato?')"> | EXCLUIR</a>
                </td>
            </tr>
        </tbody>
    <?php
    endforeach;
    ?>
</table>