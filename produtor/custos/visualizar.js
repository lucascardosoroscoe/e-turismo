var table = document.getElementById("tabela"),rIndex,cIndex;
var adicionar = document.getElementById("adicionar");
var excluir = document.getElementById("excluir");
var reativar = document.getElementById("reativar");
var visualizar = document.getElementById("visualizar");
var nome = "";

var somaCustosTotal = document.getElementById("somaCustosTotal").innerHTML;
var somaCustosPlanejado = document.getElementById("somaCustosPlanejado").innerHTML;
var somaCustosPago = document.getElementById("somaCustosPago").innerHTML;

document.getElementById("CustosTotal").innerHTML = "Custo Total: R$" + somaCustosTotal;
document.getElementById("CustosPago").innerHTML = "Total Pago: R$" + somaCustosPago;
document.getElementById("CustosPlanejado").innerHTML = "Total a Pagar: R$" + somaCustosPlanejado;
// table row
for(var i = 1; i < table.rows.length; i++)
{
    // row cells
    for(var j = 0; j < table.rows[i].cells.length - 1 ; j++)
    {
        table.rows[i].cells[j].onclick = function()
        {
            for(var x = 1; x < table.rows.length; x++){
                table.rows[x].style.color = "#000000";
            }
            rIndex = this.parentElement.rowIndex;
            table.rows[rIndex].style.color = "#009000";
            pegarValor(rIndex);
        };
    }
}
function pegarValor(rIndex){
    id = table.rows[rIndex].cells[0].innerHTML;
}

excluir.onclick = function (){
    window.location.replace("../invalidar/custos.php?id="+id);
}
adicionar.onclick = function (){
    window.location.replace("../adicionar/custo.php");
}
reativar.onclick = function (){
    window.location.replace("../reativar/custos.php?id="+id);
}
visualizar.onclick = function (){
    //window.location.replace("../editar/custos.php?id="+id);
    alert ('Disponível em Breve!');
}
function selecionarEvento(){
    var evento = document.getElementById('evento').value;
    window.location.replace("mudarEvento.php?evento="+evento);
}