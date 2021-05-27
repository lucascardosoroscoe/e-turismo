<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/headerLogin.php');

/*
    $idFicha = carregarSaldo($id, $idProdutor);
    $produtos = selecionarProdutos($idProdutor);
    carregarCategorias($produtos);
    carregarProdutos($produtos, $idFicha);

    function carregarCategorias($produtos){
        $categoriaAnterior = "";
        $size = sizeof($produtos);
        echo('<div class="menuCat">');
        for ($i = 0; $i < $size; $i++){
            $produto = $produtos[$i];
            $categoria = $produto['categoria'];
            if($categoriaAnterior != $categoria){
                echo ('<a class="cat" href="#'.$categoria.'">'.$categoria.'</a>');
            }
            $categoriaAnterior = $categoria;
        }
        echo('</div>');
    }
    function carregarSaldo($id, $produtor){
        $consulta = "SELECT * FROM `Fichas de Bar` WHERE `codigoQR` = '$id' AND `usuarioProdutor` = '$produtor'";
        $dados = selecionar($consulta);
        $saldo = $dados[0]['valor'];
        $idFicha = $dados[0]['idFicha'];
        echo ('<br><h3>Ficha nº '. $idFicha .', Saldo:R$ '. number_format($saldo, 2, ',', '.') .'</h3>');
        return $idFicha;
    }
    function carregarProdutos($produtos, $idFicha){

        
        $categoriaAnterior = "";
        $size = sizeof($produtos);
        echo ('<div class="row">');
            for ($i = 0; $i < $size; $i++){
                $produto = $produtos[$i];
                $nome = $produto['nome'];
                $idProduto = $produto['idProduto'];
                $valor = $produto['valor'];
                $idImagem = $produto['idImagem'];
                $categoria = $produto['categoria'];
                    if($categoriaAnterior != $categoria){
                        echo ('<a name="'.$categoria.'"></a>');
                    }
                    $categoriaAnterior = $categoria;
                    
                    echo('<div class="col s4 m2 push-m3">');  
                        echo('<div class="produto">');  
                            echo ('<a name="'.$idProduto.'" href="venda.php?idProduto='.$idProduto.'&idFicha='.$idFicha.'&id='.$id.'">');
                            echo('<h5 style="margin: 0 0 0 0.3em;width: 98px;height: 65px;font-size: large;">'.$nome.'</h5>');
                            if ($idImagem != 0){
                            echo('<div style="margin: auto;width:100px;height:100px;overflow: hidden;border: solid black 1px;border-radius: 8px;">');
                            echo ("<img style='height: 98px;width: 98px;}' src='getImagem.php?id=$idImagem'>");
                            echo('</div>');
                            }
                            echo('<h5 style="color: green;text-align: end;margin-bottom: auto;font-size: medium;">Valor: R$'.$valor.'</h5>');
                            echo ('</a>');
                        echo('</div>');
                    echo('</div>');
                    

                    
                }    
        echo ('</div>');

    }
    function selecionarProdutos($idProdutor){
        $consulta = "SELECT * FROM `Produto` WHERE `usuario` = '$idProdutor' ORDER BY categoria, nome";
        $dados = selecionar($consulta);
        return $dados;
    }
    */

?>
    <script src="loja.js"></script>
<?php
    include('../includes/footer.php');
?>