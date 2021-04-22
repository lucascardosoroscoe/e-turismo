var eventoatual = document.getElementById("eventoatual").innerHTML;
var table = document.getElementById("tabela"),rIndex,cIndex;
var adicionar = document.getElementById("adicionar");
var editar = document.getElementById("editar");
var excluir = document.getElementById("excluir");
var apagar = document.getElementById("apagar");
var reativar = document.getElementById("reativar");
var nome = "";

// table rows
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
    nome = table.rows[rIndex].cells[0].innerHTML;
    valor = table.rows[rIndex].cells[1].innerHTML;
}

editar.onclick = function (){
    verificarEventoAtual();
    window.location.replace("../editar/lote.php?nome="+nome+"&evento="+eventoatual);
}
excluir.onclick = function (){
    verificarEventoAtual();
    window.location.replace("../invalidar/lote.php?nome="+nome+"&evento="+eventoatual);
}
apagar.onclick = function (){
    verificarEventoAtual();
    window.location.replace("../excluir/lote.php?nome="+nome+"&evento="+eventoatual);
}
    

adicionar.onclick = function (){
    verificarEventoAtual();
    window.location.replace("../adicionar/lote.php?evento="+eventoatual);
}
reativar.onclick = function (){
    verificarEventoAtual();
    window.location.replace("../reativar/lote.php?nome="+nome+"&evento="+eventoatual);
}

function selecionarEvento(){
    var evento = document.getElementById('evento').value;
    window.location.replace("index.php?evento="+evento);
}
function verificarEventoAtual(){
    if(eventoatual == ""){
        alert("Selecione um evento");
    }
}