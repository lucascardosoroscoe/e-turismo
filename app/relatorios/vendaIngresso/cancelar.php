<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);
include('../../includes/header.php');
$id = $_GET['id'];
?>      
    <div style='background-image: url("../../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Ingresso</h3></div>
                        <div class="card-body">
                            <form action="invalidar.php" id="invalidar" method="POST" enctype="multipart/form-data">
                                <input  name="codigo" type="hidden" value="<?php echo $id; ?>" required/>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="selectMotivo">Selecione o Motivo do Cancelamento*</label>
                                            <?php motivo(); ?>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Editar</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
function motivo(){
    echo('<select class="form-control" name="selectMotivo" id="selectMotivo" form="invalidar" required>');
      echo('<option value="">Selecione o Motivo</option>');
      echo('<option value="Ingresso Emitido no número de telefone errado.">Ingresso Emitido no número de telefone errado.</option>');
      echo('<option value="Ingresso Emitido duas vezes.">Ingresso Emitido duas vezes.</option>');
      echo('<option value="Ingresso Emitido para teste.">Ingresso Emitido para teste.</option>');
      echo('<option value="Ingresso Emitido para o Evento Errado.">Ingresso Emitido para o Evento Errado.</option>');
      echo('<option value="Ingresso Emitido no Lote Errado.">Ingresso Emitido no Lote Errado.</option>');
      echo('<option value="Desistência do cliente.">Desistência do cliente.</option>');
      echo('<option value="Ausência de Pagamento.">Ausência de Pagamento.</option>');
      echo('<option value="Cliente indesejado (Black List).">Cliente indesejado (Black List).</option>');
      echo('<option value="Outro motivo de cancelamento.">Outro motivo de cancelamento.</option>');
    echo('</select>');
}

    $id = $_GET['id'];
    $consulta = "UPDATE `Ingresso` SET `validade`='CANCELADO' WHERE `codigo` = '$id'";
    $msg = executar($consulta);

    header('Location: index.php?msg='.$msg);
?>