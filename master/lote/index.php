
<?php
include_once '../includes/header.php';
include 'selecionar_evento.php';
?>
<div class="row">
<div class="col s12 m6 push-m3 ">
    <br>
    <h3>Selecione o Evento</h3><br>
        <?php
        $size = sizeof($dados);

        for ($i = 0; $i < $size; $i++){
            $obj = $dados[$i];
            $nome = $obj['nome'];
            $url = "visualizar.php?evento=".$nome;
            echo ("<h5><a href='".$url."'>".$nome."</a></h5><br>");
        }
        ?>
        </tbody>
    </table>
    <a href="https://ingressozapp.com/produtor/" class="btn">Voltar</a>
</div>
</div>

<?php
include_once '../includes/footer.php';
?>

