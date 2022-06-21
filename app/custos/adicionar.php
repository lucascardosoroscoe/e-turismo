<?php
include('../includes/verificarAcesso.php');
verificarAcesso(2);
include('../includes/header.php');
?>     
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7"> 
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Adicionar Custo</h3></div>
                        <div class="card-body">
                            <form action="create.php" id="create" method="POST">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="categoria">Categoria*</label>
                                            <?php addCategoria(); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputDescricao">Descrição*</label>
                                            <textarea class="form-control" id="inputDescricao"  name="inputDescricao" rows="5" placeholder="Descritivo do Custo" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputValor">Valor*</label>
                                            <input class="form-control py-4" id="inputValor"  name="inputValor" type="text" placeholder="Valor do Custo em R$XX,XX" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="status">Status do Custo*</label>
                                            <?php addStatus(); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Adicionar Custo</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
function addCategoria(){
    echo ('<select class="form-control" name="categoria" form="create" style="height: 50px;" required>');
    $consulta = "SELECT * FROM Categorias ORDER BY categoria";
    $dados = selecionar($consulta);
    echo ('<option value="">Selecione a Categoria</option>');
    foreach ($dados as $obj) {
        echo ('<option value="'.$obj['id'].'">'.$obj['categoria'].'</option>');
    }
    echo('</select>');
}
function addStatus(){
    echo ('<select class="form-control" name="status" form="create" style="height: 50px;" required>');
    echo ('<option value="1">Planejado</option>');
    echo ('<option value="2">Pago</option>');
    echo('</select>');
}

include('../includes/footer.php');
?>