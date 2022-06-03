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
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Agendamento criado com Sucesso</h3><br><h6><?php echo $msg;?></h6></div>
                        <div class="card-body">
                                <h6>Entre em contato no whastapp abaixo para falar com nosssa equipe</h6>
                                <div class="form-group mt-4 mb-0"><a  class="btn btn-primary btn-block" href="https://api.whatsapp.com/send?phone=5567999854042&text=Me%20inscrevi%20para%20a%20consultoria%20gratuita%20do%20IngressoZapp%2C%20gostaria%20de%20confirmar%20minha%20inscri%C3%A7%C3%A3o%20e%20saber%20um%20pouco%20mais%20sobre%20o%20app." >Contato no Whatsapp</a></div>
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