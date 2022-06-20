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
            verificarProdutor();
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


    function verificarProdutor(){
        global $email, $inputPassword;
        $consulta = "SELECT `id`, `nome`, `senha` FROM `Produtor` WHERE `email` = '$email'";
        echo $consulta;
        $dados = selecionar($consulta);
        echo json_encode($dados);
        $hash = $dados[0]['senha'];
        echo $hash;
        $valid = password_verify($inputPassword, $hash);
        if ($valid == 1){
            $id = $dados[0]['id'];
            $nome = $dados[0]['nome'];
            $type = 2;
            login($id, $nome, $type, $email, 'prod');
        }
    }
    function login($id, $nome, $type, $email, $extra){
        $msg = "Sucesso!";
    
        $_SESSION["idUsuario"] = $id;
        $_SESSION["usuario"] = $nome;
        $_SESSION["tipoUsuario"] = $type;
        $_SESSION["emailUsuario"] = $email;
        $_SESSION["idLote"] = "0";
        $_SESSION["nCaixa"] = "0";
        $_SESSION["msg"] = "0";
        echo $_SESSION["tipoUsuario"];
        echo $_SESSION["usuario"];
    
        header('Location: ../eventos/adicionar.php');
        
    }

?>