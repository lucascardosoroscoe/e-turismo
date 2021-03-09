<?php

    session_start();
    /*session created*/
    $idProdutor = $_SESSION["usuario"];
    include_once '../../includes/header.php';
    $idProduto = $_GET['id'];

    $consulta = "SELECT * FROM Produto WHERE `idProduto`='$idProduto'";
    $dados = selecionar($consulta);
    $first = $dados[0];
    $categoria = $first['categoria'];
    $nome = $first['nome'];
    $valor = $first['valor'];
    $estoque = $first['estoque'];
    
    echo ('<div class="row">');
        echo ('<div class="col s12 m6 push-m3 ">');
            echo ('<h4 class="light">Editar Produto</h4>');
            echo ('<p><?php echo $msg?></p>');
                echo ('<form action="edit_produto.php" id="edit_produto" method="POST" enctype="multipart/form-data">');
                    echo ('<input type="hidden" name="idProduto" value="'.$idProduto.'">');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="nome" id="nome" value="'.$nome.'" required>');
                        echo ('<label for="nome">Nome do Produto</label>');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="categoria" id="categoria" value="'.$categoria.'" required>');
                        echo ('<label for="categoria">Descrição</label>');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<p>Imagem:</p>');
                        echo ('<input type="file" name="imagem" id="imagem">');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="valor" id="valor" value="'.$valor.'" required>');
                        echo ('<label for="valor">Valor</label>');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="estoque" id="estoque" value="'.$estoque.'" required>');
                        echo ('<label for="estoque">Estoque</label>');
                    echo ('</div>');

                    echo ('<button type="submit" name="btn-cadastrar" class="btn">Editar Produto</button>');
                echo ('</form>');
            echo ('<br>');
            echo ('<a href="index.php" class="btn">Voltar</a>');
        echo ('</div>');
    echo ('</div>');

    include_once '../../includes/footer.php';
    
    
    function addCategoria($selected){    
        $consulta = "SELECT * FROM Categoria WHERE `validade`='VALIDO' ORDER BY `nome`";
        $dados = selecionar($consulta);
        $size = sizeof($dados);
    
        for ($i = 0; $i < $size; $i++){
            $obj = $dados[$i];
            //echo json_encode($primeiro);
            //echo "<br>";
            $nome = $obj['nome'];
            $idCategoria = $obj['idCategoria'];
            $prioridade = $obj['prioridade'];
            if ($idCategoria == $selected){
                echo ('<option value="'.$idCategoria.'" selected>'.$nome.'</option>');
            }else{
                echo ('<option value="'.$idCategoria.'">'.$nome.'</option>');
            }
        }
        echo('</select>');
       
    }
?>