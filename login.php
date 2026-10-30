<?php
// 1. Inclui o arquivo de conexão com o banco de dados
include "conecta.php";

// 2. Recebe os dados enviados pelo formulário do index.php via método POST
$cpf = $_POST['cpf'];
$senha = $_POST['senha'];

// 3. Monta o comando SQL usando parâmetros (:cpf e :senha) para evitar SQL Injection
$sql = "SELECT * FROM aluno WHERE cpf = :cpf AND senha = :senha";

try {
    // 4. Prepara a consulta SQL usando a conexão criada no conecta.php
    $stmt = $conexao->prepare($sql);

    // 5. Vincula os valores das variáveis aos parâmetros da consulta (proteção SQL Injection)
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':senha', $senha);

    // 6. Executa a consulta no banco de dados
    $stmt->execute();

    // 7. Verifica se encontrou algum registro usando o método fetch()
    if ($linha = $stmt->fetch()) {
        // Se encontrou o aluno, exibe a mensagem de boas-vindas com o nome dele
        echo "<p>Bem-vindo, " . $linha['nome'] . "!</p>";
    } else {
        // Se não encontrou ninguém com esse CPF e senha
        echo "<p>CPF ou senha incorretos!</p>";
    }

} catch (PDOException $e) {
    echo "Erro ao realizar o login: " . $e->getMessage();
}
?>