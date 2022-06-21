<?php
include('../includes/header.php');
$msg = $_GET['msg']; 
$email = $_GET['email'];
?>     
    <link href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    
    <div style='background-image: url("../img/fundoLogin.jpg"); background-size: cover;height: 100%;'>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Agendar Consultoria Gratuita</h3><br><h6><?php echo $msg;?></h6></div>
                        <div class="card-body">
                            <form action="createAgendamento.php" id="createAgendamento" method="POST">
                                <div class="form-row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmailAddress">E-mail</label>
                                            <input class="form-control py-4" id="inputEmailAddress"  name="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Digite o e-mail" value="<?php echo $email;?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputName">Nome</label>
                                            <input class="form-control py-4" id="inputName"  name="inputName" type="text" placeholder="Digite o nome/razão social" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputTelefone">Telefone</label>
                                            <input class="form-control py-4" id="inputTelefone"  name="inputTelefone" type="text" placeholder="Digite o telefone" required/>
                                        </div>
                                    </div>
                                    <p class="small mb-1">Agende para uma data entre 01 e 30 de junho com pelo menos 1 dia útil de antecedência</p>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputData">Data</label>
                                            <input class="form-control py-4" id="inputData" onchange="datepicker()" min="<?php $tomorrow = new DateTime('tomorrow'); echo $tomorrow->format('Y-m-d');?>" name="inputData" type="date" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputHora">Hora (brasília)</label>
                                            <input class="form-control py-4" id="inputHora"  name="inputHora" type="time"  min="10:00" max="18:00" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" onclick="enviarForm()" >Confirmar Inscrição</button></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function datepicker(){
            var inputData = document.getElementById('inputData').value;
            var data = new Date(inputData);
            var diaSemana = data.getDay();
            if(diaSemana >= 0 && diaSemana < 5){
                console.log("Dia de Semana");
            }else if(diaSemana == 5){
                alert("Infelizmente não podemos agendar seu horário no fim de semana. Selecione outra data para a sua consultoria.");
                data.setDate(data.getDate() + 2);
                document.getElementById('inputData').value = data.toString();
            }else if(diaSemana == 6){
                alert("Infelizmente não podemos agendar seu horário no fim de semana. Selecione outra data para a sua consultoria.");
                data.setDate(data.getDate() + 1);
                document.getElementById('inputData').value = data.toString();
            }{
                inputData = "";
            }
        }
    </script>
<?php
include('../includes/footer.php');
?>