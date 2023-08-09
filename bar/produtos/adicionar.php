<?php
    include_once '../../includes/header.php';

        echo ('<div class="row">');
            echo ('<div class="col s12 m6 push-m3 ">');
                echo ('<div class="input-field col s12">');
                    echo ('<h4 class="light">Adicionar Produto</h4>');
                echo ('</div>');
                echo ('<form action="create_produto.php" id="create_produto" method="POST" enctype="multipart/form-data">');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="nome" id="nome" required>');
                        echo ('<label for="nome">Nome do Produto</label>');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="categoria" id="categoria" required>');
                        echo ('<label for="categoria">Categoria</label>');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<p>Imagem:</p>');
                        echo ('<input type="file" name="imagem" id="imagem">');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="valor" id="valor" required>');
                        echo ('<label for="valor">Valor</label>');
                    echo ('</div>');
                    echo ('<div class="input-field col s12">');
                        echo ('<input type="text" name="estoque" id="estoque">');
                        echo ('<label for="estoque">Quantidade em Estoque</label>');
                    echo ('</div>');

                    echo ('<button type="submit" name="btn-cadastrar" class="btn">Cadastrar Produto</button>');
                    echo ('</form>');
                echo ('<br>');
                echo ('<a href="index.php" class="btn">Voltar</a>');
            echo ('</div>');
        echo ('</div>');

    include_once '../../includes/footer.php';
?>