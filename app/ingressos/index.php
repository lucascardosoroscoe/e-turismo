<?php
include('../includes/verificarAcesso.php');
include('../includes/header.php');
?>
    <div style='background-image: url("./img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                <?php
                    $hash = $_GET['hash'];
                    $msg = $_GET['msg'];
                    // $id = $_GET['id'];
                    $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.validade, Ingresso.motivoInvalidar, Ingresso.horaLeitura, Ingresso.msgTitularidade,
                    Evento.id as idEvento, Evento.nome as evento, Evento.descricao as descricaoEvento,
                    Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Cliente.telefone as idCliente, Lote.nome as lote, Lote.id as idLote
                    FROM Ingresso 
                    JOIN Evento ON Evento.id = Ingresso.evento
                    JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
                    JOIN Cliente ON Cliente.id = Ingresso.idCliente
                    JOIN Lote ON Lote.id = Ingresso.lote
                    WHERE Ingresso.hash = '$hash' ORDER BY Ingresso.codigo";
                    // echo "Teste: ".$consulta;
                    // $consulta = "SELECT Ingresso.codigo, Ingresso.valor, Ingresso.validade, Ingresso.data, Ingresso.validade, Ingresso.msgTitularidade,
                    // Evento.id as idEvento, Evento.nome as evento, Evento.descricao as descricaoEvento,
                    // Vendedor.nome as vendedor, Cliente.nome as cliente, Cliente.telefone, Cliente.telefone as idCliente, Lote.nome as lote
                    // FROM Ingresso 
                    // JOIN Hash ON Hash.hash = Ingresso.hash 
                    // JOIN Evento ON Evento.id = Ingresso.evento
                    // JOIN Vendedor ON Vendedor.id = Ingresso.vendedor
                    // JOIN Cliente ON Cliente.id = Ingresso.idCliente
                    // JOIN Lote ON Lote.id = Ingresso.lote
                    // WHERE Hash.hash = '$hash' AND Hash.id = '$id'";
                    $ingressos = selecionar($consulta);
                    // echo json_encode($ingressos);
                    $contagem = 1;
                    // echo '<h5 class="text-center">'. $consulta .'</h5>';
                    foreach ($ingressos as $ingresso) {
                        $evento = $ingresso['evento'];
                        $codigo = $ingresso['codigo'];
                        $validade = $ingresso['validade'];
                        $motivoInvalidar = $ingresso['motivoInvalidar'];
                        $horaLeitura = $ingresso['horaLeitura'];
                        $msgTitularidade = $ingresso['msgTitularidade'];
                        $cliente = $ingresso['cliente'];
                        $idCliente = $ingresso['idCliente'];
                        $telefone = $ingresso['telefone'];
                        $descricaoEvento = $ingresso['descricaoEvento'];
                        $evento = $ingresso['evento'];
                        $idEvento = $ingresso['idEvento'];
                        $lote = $ingresso['lote'];
                        $idLote = $ingresso['idLote'];
                        $aux = '../qr_img0.50j/php/qr_img.php?';
                        $aux .= 'd='.$codigo.'&';
                        $aux .= 'e=H&';
                        $aux .= 's=4&';
                        $aux .= 't=P';
                        
                        echo'<div class="card shadow-lg border-0 rounded-lg mt-5">';
                            
                            echo'<div class="card-header">';
                                echo'<h3 class="text-center font-weight-light my-4">'.$evento.'</h3>';
                                echo'<h6 class="font-weight-light" style="text-align: center;">Ingresso nº '.$contagem.'</h6>';
                            echo'</div>';
                            echo'<div class="card-body">';
                                echo '<h6>'.$msgTitularidade.'</h6>';
                                echo ("<img style='width: 100%;' src='../getImagem.php?id=$idEvento'/>");
                                if($validade == 'VALIDO'){
                                    echo ('<img style="margin-left: 25%;" src="'.$aux.'" alt="" width="50%">');
                                    echo ('<h6 style="text-align: center;">CODIGO: '.$codigo.'</h6><br>');
                                    echo ('<h6 style="text-align: center;">'.$descricaoEvento.'</h6><br>');
                                    echo ('<h6>Lote: '.$lote.'</h6><br>');
                                    if($idLote == 7982){ 
                                        echo ('<h6>Nome do Titular do Ingresso: '.$cliente.'</h6>');
                                        echo ('<h6>Telefone: '.$telefone.'</h6>');
                                        echo ('<h6>Atenção!!! O ingresso de cortesia é pessoal e intransferível, por favor lembre-se de apresentar seu documento.</h6><br>');
                                    
                                    }else{ 
                                        echo ('<form action="edit.php" id="edit_evento" method="POST" enctype="multipart/form-data">');
                                            echo ('<input  name="codigo" type="hidden" value="'.$codigo.'" required/>');
                                            echo ('<input  name="id" type="hidden" value="'.$id.'" required/>');
                                            echo ('<input  name="hash" type="hidden" value="'.$hash.'" required/>');
                                            echo ('<input  name="idCliente" type="hidden" value="'.$idCliente.'" required/>');
                                            echo ('<input  name="telefoneAntigo" type="hidden" value="'.$telefone.'" required/>');
                                            echo ('<input  name="nomeAntigo" type="hidden" value="'.$cliente.'" required/>');
                                            echo ('<div class="form-row">');
                                                echo ('<div class="col-md-6">');
                                                    echo ('<div class="form-group">');
                                                        echo ('<label class="small mb-1" for="inputName">Nome do Cliente*</label>');
                                                        echo ('<input class="form-control py-4" id="inputName"  name="inputName" type="text" value="'.$cliente.'" required/>');
                                                    echo ('</div>');
                                                echo ('</div>');
                                                echo ('<div class="col-md-6">');
                                                    echo ('<div class="form-group">');
                                                        echo ('<label class="small mb-1" for="inputTelefone">Telefone*</label>');
                                                        echo ('<input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" value="'.$telefone.'" required/>');
                                                    echo ('</div>');
                                                echo ('</div>');
                                            echo ('</div>');
                                            echo('Altere o nome e o número de telefone a cima em seguida clique em "Solicitar Modificação de Titularidade" para mudar a titularidade de seu ingresso.
                                                Atenção: Para mudar a titularidade é obrigatório que também mude o telefone, por quetões de segurança apenas a primeira troca de titularidade é automatizada e gratuita, muita atenção ao realizar este procedimento.');
                                            if($msgTitularidade == ""){
                                                echo ('<div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit" >Solicitar Modificação de Titularidade</button></div>');
                                            }else{
                                                echo ('<h6>Por motivos de segurança apenas a 1ª transferência é gratiuta, e simplificada. As demais transferências devem passar por uma supervisão da equipe IngressoZapp<br>
                                                Por gerar um suporte extra, essa mudança vai ter um custo de R$5,00, pago via PIX.</h6>');
                                                echo ('<a href="https://api.whatsapp.com/send?phone=5567993481631&text=Ol%C3%A1%2C%20tudo%20bem%3F%20Gostaria%20de%20solicitar%20uma%20transfer%C3%AAncia%20de%20titularidade%20do%20meu%20ingresso." class="btn btn-primary" type="submit" >Solicitar Modificação de Titularidade</a>');
                                            }
                                        echo ('</form>');
                                    }
                                }else if($validade == 'USADO'){
                                    echo ('<br><h3 style="text-align: center;">Ingresso Já usado Anteriormente</h3><br>');
                                    $hora = gmdate('d-m-Y H:i:s', strtotime( $horaLeitura ) - 7200);
                                    echo ('<h6 style="text-align: center;">Hora de Uso: '.$hora.' (Brasília)</h6><br>');
                                }else if($validade == 'CANCELADO'){
                                    echo ('<br><h3 style="text-align: center;">Ingresso Cancelado</h3><br>');
                                    echo ('<h6 style="text-align: center;">'. $motivoInvalidar .'</h6><br>');
                                }else{
                                    echo ('<h6 style="text-align: center;">Erro no ingresso</h6><br>');
                                }
                                
                            echo'</div>';
                        echo'</div>';
                        $contagem ++;
                    }
                ?>
                </div>
            </div>
        </div>
    </div>
<?php
include('../includes/footer.php');
?>