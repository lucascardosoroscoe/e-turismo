<?php
    include('../includes/verificarAcesso.php');
    include('../includes/trello.php');
    $email = $_POST['inputEmailAddress'];
    $nome = $_POST['inputName'];
    $telefone = $_POST['inputTelefone'];
    $cidade = $_POST['inputCidade'];
    $estado = $_POST['inputEstado'];
    $inputConfirmPassword = $_POST['inputConfirmPassword'];
    $inputPassword = $_POST['inputPassword'];
    $inputCPF = $_POST['inputCPF'];
    $inputCEP = $_POST['inputCEP'];
    $inputEndereco = $_POST['inputEndereco'];
    $inputNumero = $_POST['inputNumero'];
    $inputBairro = $_POST['inputBairro'];

    if($inputPassword == $inputConfirmPassword){
        $hash = password_hash($inputPassword, PASSWORD_DEFAULT);
        $consulta = "SELECT `id` FROM `Produtor` WHERE `usuario` = '$email'";
        $msg = verificar($consulta);
        if($msg == "Sucesso!"){
            $consulta = "INSERT INTO `Produtor`(`usuario`, `senha`, `nome`, `telefone`, `email`, `CPF`, `CEP`, `endereco`, `numero`, `bairro`, `cidade`, `estado`) VALUES ('$email', '$hash', '$nome', '$telefone', '$email', '$inputCPF', '$inputCEP', '$inputEndereco', '$inputNumero', '$inputBairro', '$cidade', '$estado')";
            $msg = executar($consulta);
            if($msg != "Sucesso!"){
                $msg = "Erro ao criar Usuário, por favor contate o suporte!!";
            }
        }else{
            $msg = "E-mail do Usuário já cadastrado. ";
        }
    }else{
        $msg = "A senha não condiz com a confirmação de Senha";
    }
    $data = date('Y-m-d');
    $nomeCard = $nome . " - " . $cidade . '/' . $estado . ' (' . $telefone . ')';
    $descricaoCard = "
        telefone: $telefone \n
        E-mail: $email
    "; 
    criarCard($nomeCard, $descricaoCard, $data, $idListaProdutorCriado);

   header('Location: index.php?msg='.$msg);
?>