<?php
    include_once 'includes/header.php';
    
    include('includes/db_valores.php');
    $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
session_start();
/*session created*/
$produtor  =  $_GET["produtor"];
$promoter  =  $_SESSION["promoter"];
$atividade =  $_SESSION["atividade"];
$msg = $_GET["msg"];
$evento    =  $_GET['evento'];
$_SESSION["evento"] = $evento;
    echo ('<div class="row">');
            echo ('<div class="col s12 m6 push-m3 ">');
                echo ('<img src="includes/logo.png"class="logo">');
                echo ('<h3>Emitir Ingresso</h3>');
                echo ('<form action="emitir.php" id="emitir" method="get">');

                    echo('<input type="hidden" name="evento" id="evento"  value="'.$evento.'" required>');
                    echo('<input type="hidden" name="msg" id="msg"  value="'.$msg.'">');
                    echo('<input type="hidden" name="produtor" id="produtor"  value="'.$produtor.'" required>');

                    echo ('<br><p> Selecione o Lote:  </p>');
                    echo ('<select name="lote" form="emitir">');
                    addLote($evento);

                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="cliente" id="cliente" required>');
                        echo ('<label for="cliente">Nome do Cliente</label>');
                    echo ('</div>');

                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="telefone" id="telefone" required>');
                        echo ('<label for="telefone">Telefone do Cliente: DDD obrigatório</label>');
                    echo ('</div>');

                    echo ('<br><p>Sexo do Cliente: </p>');
                    echo ('<select name="sexo" form="emitir">');
                        echo ('<option value="Masculino">Masculino</option>');
                        echo ('<option value="Feminino">Feminino</option>');
                    echo('</select>');
                    echo('<br>');
                    echo ('<button type="submit" name="emitir" class="btn">Emitir Ingresso</button>');
                echo('</form>');
                $idConvite = getId($evento, $promoter);
                //echo ('<br><a href="https://ingressozapp.com/convite/index.php?id='. $idConvite .'" class="btn">Link de Convite</a>');
                echo ('<br><br><a href="relatorio/index.php" class="btn">Relatório de Vendas</a>');

                echo ('<br><br><a href="https://ingressozapp.com/promoter/" class="btn">Voltar</a>');
            echo ('</div>');
        echo ('</div>');



function addLote($evento){
    global $conexao;
    $consulta = "SELECT * FROM Lote WHERE evento='$evento' and validade='DISPONÍVEL'";

    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }

    $size = sizeof($dados);
    for ($i = 0; $i < $size; $i++){
        $obj = $dados[$i];
        //echo json_encode($primeiro);
        //echo "<br>";
        $nome = $obj['nome'];
        $valor = $obj['valor'];
        echo ('<option value="'.$nome.'">'.$nome.', R$'.$valor.',00</option>');
    }

    
function getId($evento, $promoter){
    global $conexao;

    $consulta = "SELECT `id` FROM `Convite` WHERE `evento` = '$evento' AND `promoter` = '$promoter'";

    $gravacoes = mysqli_query($conexao, $consulta);
    $dados = array();
    while($linha = mysqli_fetch_assoc($gravacoes)){
        $dados[] = $linha; 
    }

    
    $id = $dados[0]['id'];
    if ($id != ''){
        return $id;
    }else{
        $consulta = "INSERT INTO `Convite`(`evento`, `promoter`) VALUES ('$evento', '$promoter')";
        
        if(mysqli_query($conexao, $consulta)){
            $sucesso = 1;
            $consulta = "SELECT `id` FROM `Convite` WHERE `evento` = '$evento' AND `promoter` = '$promoter'";
            
            $gravacoes = mysqli_query($conexao, $consulta);
            $dados = array();
            while($linha = mysqli_fetch_assoc($gravacoes)){
                $dados[] = $linha; 
            }

            $id = $dados[0]['id'];
            if ($id != ''){
                return $id;
            }
        }else{echo "erro";}
    }   
}

    echo('</select>');
   
}

include_once 'includes/footer.php';
?>