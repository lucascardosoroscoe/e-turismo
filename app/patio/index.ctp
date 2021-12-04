<style>
    .input-search {
            height: 33px;
            padding: 5px !important;
            border-bottom: 1px solid #DDDDDD !important;
            color: #7F8C8C;
            margin: 30px auto 0 auto;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
            <div class="lojas index"> 
                <div class="subtitulo">
                    <i class="glyphicon glyphicon-user"> </i>	
                    Listar clientes / 
                    <a href="<?php echo $this->webroot; ?>clientes/add" data-toggle="tooltip" data-placement="right" title="Clique aqui para cadastrar novos clientes">
                        Cadastrar clientes
                    </a>
                </div>
                <h1 class="title-list">
                    CLIENTES CADASTRADOS
                </h1> 
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="" method="get" >
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            <?php echo $this->Form->input("busca_nome", array("label" => false, "id" => "busca","class" => "form-control input-search", "placeholder" => "busca aqui")); ?> 
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-g btn-buscar"> BUSCAR </button>

                </form>
                <button class="btn-grey btn-buscar" style="margin-right:10px; margin-top:-10px;"> 
                    <a href="<?php echo $this->webroot; ?>clientes" style="color:#FFF;"> LISTAR TODOS </a>
                </button>

                
            </div>

            <div class="clearfix"></div>
            <br><br>

            <div class="clientes index uppercase">
                <table  class="table tablesorter table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?php echo $this->Paginator->sort('nome'); ?></th>
                            <th><?php echo $this->Paginator->sort('cidade'); ?></th>
                            <th><?php echo $this->Paginator->sort('estado'); ?></th>
                            <th><?php echo $this->Paginator->sort('bairro'); ?></th>
                            <th><?php echo $this->Paginator->sort('sexo'); ?></th>
                            <th>CELULAR | TELEFONE</th>
                            <th><?php echo $this->Paginator->sort('cpf'); ?></th>
                            <th><?php echo $this->Paginator->sort('rg'); ?></th>
                            <th><?php echo $this->Paginator->sort('created'); ?></th>
                            <th class="actions"><?php echo __('Ações'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                        if (!empty($clientes)) {
                            foreach ($clientes as $cliente):
                                ?>
                                <tr>
                                    <td><?php echo h($cliente['Cliente']['nome']); ?>&nbsp;</td>
                                    <td><?php echo h($cliente['Cliente']['cidade']); ?>&nbsp;</td>
				                    <td><?php echo h($cliente['Cliente']['estado']); ?>&nbsp;</td>
                                    <td><?php echo h($cliente['Cliente']['bairro']); ?>&nbsp;</td>
                                    <td><?php echo h($cliente['Cliente']['sexo']); ?>&nbsp;</td>
                                    <td><?php echo h($cliente['Cliente']['celular']) . ' | ' .h($cliente['Cliente']['telefone']); ?>&nbsp;</td>
				                    <td><?php echo h($cliente['Cliente']['cpf']); ?>&nbsp;</td>
                                    <td><?php echo h($cliente['Cliente']['rg']); ?>&nbsp;</td>
                                    <td><?php echo h($cliente['Cliente']['created']); ?>&nbsp;</td>
                                    <td class="actions">
                                        <?php
                                            $celular = h($cliente['Cliente']['celular']);
                                            if($celular == ""){
                                                $celular = h($cliente['Cliente']['telefone']);
                                            }
                                            $celular = str_replace(" ", "", $celular);
                                            $celular = str_replace("(", "", $celular);
                                            $celular = str_replace(")", "", $celular);
                                            $celular = str_replace("-", "", $celular);
                                            $celular = str_replace("+55", "", $celular);
                                            $prim = substr($celular,0,1);
                                            if($prim == 0){
                                                $celular = substr($celular,1,11);
                                            }
                                        ?>
					                    <a href="<?php echo 'https://api.whatsapp.com/send?phone=55'. $celular; ?> " data-toggle="tooltip" data-placement="bottom" title="Entrar em Contato via Whatsapp" target="_blank">
                                            Whatsapp
                                        </a>
					&nbsp;&nbsp;&nbsp;
                                        <a href="<?php echo $this->webroot; ?>cupoms/add/?id_cliente=<?php echo h($cliente['Cliente']['id']); ?> " data-toggle="tooltip" data-placement="bottom" title="Cadastrar cupons para esse cliente" target="_blank">
                                            <i class="glyphicon glyphicon-tag"> </i>
                                        </a>

                                        &nbsp;&nbsp;&nbsp;

                                        <?php
                                        echo $this->Html->link(__(' '), array('action' => 'view', $cliente['Cliente']['id']), array('class' => 'glyphicon glyphicon-search'));
                                        ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php
                                        echo $this->Html->link(__(' '), array('action' => 'edit', $cliente['Cliente']['id']), array('class' => 'glyphicon glyphicon-pencil'));
                                        ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <?php echo $this->Form->postLink(__('X'), array('action' => 'delete', $cliente['Cliente']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $cliente['Cliente']['id']))); ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        <?php } else { ?>
                        <td colspan="5" align="center">
                            NENHUM RESULTADO ENCONTRADO
                            <a href="<?php echo $this->webroot; ?>clientes/add/" data-toggle="tooltip" data-placement="right" title="Clique aqui para cadastrar novos clientes" style="color:red; text-decoration:underline;"> Clique aqui para cadastrá-lo</a>
                        </td>
                    <?php } ?>
                    </tbody>
                </table>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2>Exporta Excel</h2>
                <form action="../../cliente/excel.php" method="get" >   
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dataInicial">Data de Cadastro (mínimo)</label>
                            <input type="date" class="form-control input-search" name="dataInicial" id="dataInicial">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dataFinal">Data de Cadastro (Máximo)</label>
                                <input type="date" class="form-control input-search" name="dataFinal" id="dataFinal">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-g btn-buscar"> EXPORTAR DADOS DO PERÍODO </button>

                </form>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="paginar">

            <?php
            echo $this->Paginator->numbers(
                    array(
                        'separator' => '',
                        'modulus ' => 5,
                        'before' => '<li>',
                        'after' => '</li>'
                    )
            );
            ?>
        </div>
    </div>
</div>
<script>
    jQuery(function ($) {
        
        if ($(".op-busca").val() == "cpf") {
            $("#busca").mask("999.999.999-99");
        } else {
            $("#busca").unmask("999.999.999-99");
        }

        $(".op-busca").change(function () {

            if ($(this).val() == "cpf") {
                $("#busca").mask("999.999.999-99");
            } else {
                $("#busca").unmask("999.999.999-99");
            }

        });

    });
</script>