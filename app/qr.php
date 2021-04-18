<?php
include('includes/verificarAcesso.php');
include('./includes/header.php');

$codigo    = $_GET['codigo'];
$consulta = "SELECT Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.validade,
Evento.id as idEvento, Evento.nome as evento, Evento.descricao as descricaoEvento,
Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Lote.nome as lote
FROM Ingresso 
JOIN Evento ON Evento.id = Ingresso.evento
JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
JOIN Cliente ON Cliente.id = Ingresso.idCliente
JOIN Lote ON Lote.id = Ingresso.lote
WHERE Ingresso.codigo = $codigo";

$ingresso = selecionar($consulta);
$ingresso = $ingresso[0];
$evento = $ingresso['evento'];
$cliente = $ingresso['cliente'];
$descricaoEvento = $ingresso['descricaoEvento'];
$evento = $ingresso['evento'];
$idEvento = $ingresso['idEvento'];
$aux = 'qr_img0.50j/php/qr_img.php?';
$aux .= 'd='.$codigo.'&';
$aux .= 'e=H&';
$aux .= 's=4&';
$aux .= 't=P';
?>
<div style='background-image: url("./img/fundoLogin.jpeg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4"><?php echo $evento;?></h3>
                            <h6 class="font-weight-light" style="text-align: center;">Ingresso individual</h6>
                        </div>
                        <div class="card-body">
                        <?php
                            echo ("<img style='width: 100%;' src='getImagem.php?id=$idEvento'/>");
                            echo ('<img style="margin-left: 25%;" src="'.$aux.'" alt="" width="50%">');
                            echo ('<p class="font-weight-light">Cliente: '.$cliente.'</p>');
                            echo ('<p class="font-weight-light">Descrição do Evento: '.$descricaoEvento.'</p>');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
include('./includes/footer.php');
?>