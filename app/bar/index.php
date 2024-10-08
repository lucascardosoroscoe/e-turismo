<?php
    include('../includes/verificarAcesso.php');
    verificarAcesso(2);
    include('../includes/headerLogin.php');

    $idIngresso = $_GET['id'];
?>
    <div class="container-fluid">
    <!-- Tabela dos veículos-->
    <div class="card mb-4">
        <div class="card-header" style="padding-bottom:0px;">
            <?php 
                $idCarteira = carregarSaldo($idIngresso);
                $produtos = selecionarProdutos($idUsuario);
                carregarCategorias($produtos);
            ?>
        </div>
        <div class="card-body">
            <?php
                carregarProdutos($produtos, $idCarteira);
            ?>
        </div>
    </div>
</div>
<?php
    function carregarSaldo($id){
        $consulta = "SELECT * FROM Carteira WHERE idIngresso = $id";
        $fichas = selecionar($consulta);
        $saldo = $fichas[0]['saldo'];
        $idCarteira = $fichas[0]['id'];
        echo ('<br><h3>Saldo:R$ '. number_format($saldo, 2, ',', '.') .'<br>Ficha nº '. $id .'</h3>');
        return $idCarteira;
    }

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
    
    function selecionarProdutos($idProdutor){
        $consulta = "SELECT * FROM `Produto` WHERE `produtor` = '$idProdutor' AND `validade` = 'VALIDO' ORDER BY categoria, nome";
        $dados = selecionar($consulta);
        return $dados;
    }

    function carregarProdutos($produtos, $idCarteira){
        global $id;
        
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
                
                echo('<div class="col s4 m2 push-m3" style="padding-left: 1px;padding-right: 1px;">');  
                    echo('<div class="produto">');  
                        echo ('<a name="'.$idProduto.'" href="venda.php?idProduto='.$idProduto.'&idCarteira='.$idCarteira.'&id='.$id.'">');
                        echo('<h5 style="margin: 0 0 0 0;width: 100%;height: 45px;font-size: initial;text-transform: uppercase;text-align: center;">'.$nome.'</h5>');
                        if ($idImagem != 0){
                        echo('<div style="margin: auto;width:130px;height:130px;overflow: hidden;border: solid black 1px;border-radius: 8px;">');
                        echo ("<img style='height: 130px;width: 130px;}' src='https://ingressozapp.com/app/bar/getImagem.php?id=$idImagem'>");
                        echo('</div>');
                        }
                        echo('<h5 style="color: green;text-align: center;margin-bottom: auto;font-size: medium;">Valor: R$'.number_format($valor, 2, ',', '.').'</h5>');
                        echo ('</a>');
                    echo('</div>');
                echo('</div>');
            }    
        echo ('</div>');

    }
    
    include('../includes/footer.php');
?>