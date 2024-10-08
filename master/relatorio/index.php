<?php
    include_once '../includes/header.php';
    session_start();
    /*session created*/
    $produtor  =  $_SESSION["usuario"];
    $validade =  $_SESSION["validade"];
    if ($validade == "VALIDO"){
        echo ('<div class="row">');
            echo ('<div class="col s12 m6 push-m3 ">');
                echo ('<h5>Escolha dentre as opções abaixo e emita seu relatório personalizado</h5>');
                echo ('<form action="relatorio.php" id="relatorio" method="get">');

                    echo ('<h5>Selecione o Evento: </h5>');
                    itemSelect("Evento", "Eventos", $produtor, "nome");

                    echo ('<h5>Selecione o Vendedor: </h5>');
                    itemSelect("Vendedor", "Vendedores", $produtor, "usuario");

                    echo ('<h5>Selecione o Lote: </h5>');
                    itemSelect("Lote", "Lotes", $produtor, "nome");

                    echo ('<h5>Selecione o Sexo: </h5>');
                    echo ('<select name="Sexo" form="relatorio">');
                    echo ('<option value="todos">Ambos</option>');
                    echo ('<option value="M">Masculino</option>');
                    echo ('<option value="F">Feminino</option>');
                    echo ('</select><br><br>');

                    echo ('<h5>Selecione a Validade do Ingresso: </h5>');
                    echo ('<select name="Validade" form="relatorio">');
                    echo ('<option value="todos">Ambos</option>');
                    echo ('<option value="VALIDO">Ingressos Válidos</option>');
                    echo ('<option value="INVALIDO">Ingressos Inválidos</option>');
                    echo ('</select><br><br>');
                    
                    echo ('<button type="submit" name="emitir" class="btn">Emitir Relatório</button>');
                echo('</form>');
                echo ('<br><a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>');
            echo ('</div>');
        echo ('</div>');
    
    } else {
        header('Location: http://arkun.com.br/apk/login/');
    }

    function itemSelect($atual, $x, $produtor, $label){
        include('../includes/db_valores.php');
        $conexao = mysqli_connect($servidor, $usuario, $senha, $bdados);
    
        $consulta = "SELECT * FROM $atual WHERE produtor='$produtor'";
    
        $gravacoes = mysqli_query($conexao, $consulta);
        $dados = array();
        while($linha = mysqli_fetch_assoc($gravacoes)){
            $dados[] = $linha; 
        }
    
        mysqli_close($conexao);
    
        $size = sizeof($dados);
        echo('<select name="'.$atual.'" form="relatorio">');
        echo ('<option value="todos">Todos os '.$x.'</option>');
        for ($i = 0; $i < $size; $i++){
            $obj = $dados[$i];
            //echo json_encode($primeiro);
            //echo "<br>";
            $act = $obj[$label];
            echo ('<option value="'.$act.'">'.$act.'</option>');
            $count++;
        }
        echo('</select><br>');
       
    }
    

    include_once '../includes/footer.php';
?>