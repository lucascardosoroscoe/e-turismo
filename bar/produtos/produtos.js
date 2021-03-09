var table = document.getElementById("tabela"),rIndex,cIndex;
var adicionar = document.getElementById("adicionar");
var excluir = document.getElementById("excluir");
var reativar = document.getElementById("reativar");
var editar = document.getElementById("editar");
var id = "";

console.log("OK");
// table rows
for (var i = 1; i < table.rows.length; i++){
    // row cells
    for (var j = 0; j < table.rows[i].cells.length - 1 ; j++){
        table.rows[i].cells[j].onclick = function(){
        
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
    window.location.replace("invalidar.php?id="+id);
}
adicionar.onclick = function (){
    window.location.replace("adicionar.php");
}
reativar.onclick = function (){
    window.location.replace("revalidar.php?id="+id);
}
editar.onclick = function (){
    window.location.replace("editar.php?id="+id);
}