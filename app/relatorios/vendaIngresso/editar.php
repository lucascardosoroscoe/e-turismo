<?php
include('../../includes/verificarAcesso.php');
verificarAcesso(2);
include('../../includes/header.php');
$id = $_GET['id'];
$consulta = "SELECT  Cliente.nome as cliente, Cliente.telefone as telefone, Cliente.id, Ingresso.lote 
FROM Ingresso
JOIN Cliente ON Ingresso.idCliente = Cliente.id
WHERE Ingresso.codigo = '$id'";
$dados = selecionar($consulta);
$idLote = $dados[0]['lote'];
?>      
    <div style='background-image: url("../../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Editar Ingresso</h3></div>
                        <div class="card-body">
                            <form action="edit.php" id="edit_evento" method="POST" enctype="multipart/form-data">
                                <input  name="codigo" type="hidden" value="<?php echo $id; ?>" required/>
                                <input  name="idCliente" type="hidden" value="<?php echo $dados[0]['id']; ?>" required/>
                                <input  name="telefoneAntigo" type="hidden" value="<?php echo $dados[0]['telefone']; ?>" required/>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="selectLote">Selecione o Lote*</label>
                                            <?php lote(); ?>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome do Cliente*</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" value="<?php echo $dados[0]['cliente']; ?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Telefone*</label>
                                            <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" value="<?php echo $dados[0]['telefone']; ?>" required/>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Editar</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
function lote(){
    global $idEvento, $idLote;
      $consulta = "SELECT * FROM `Lote` WHERE `evento`= '$idEvento' AND `validade`!= 'EXCLUIDO'";
    $dados = selecionar($consulta);
    echo('<select class="form-control" name="selectLote" id="selectLote" form="edit_evento" required>');
      echo('<option value="">Selecione o Lote</option>');
      foreach ($dados as $lote) {
        if($idLote == $lote['id']){
          echo('<option value="'. $lote['id'] .'" selected>'. $lote['nome'] .'</option>');
        }else{
          echo('<option value="'. $lote['id'] .'">'. $lote['nome'] .'</option>');
        }
      }
    echo('</select>');
  }

include('../../includes/footer.php');
?>