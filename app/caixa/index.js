function adicionar(codigo, idCaixa, valor){
    href = window.location.href
    var res = href.split("index");
    if(confirm("Confirmar Crédito?")){
        window.location.href = res[0] + "credito.php?codigo="+codigo+"&idCaixa="+idCaixa+"&valor="+valor;
    }
}