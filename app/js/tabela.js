var tbody = document.getElementById('tbody');
var total = document.getElementById('total');
var soma = 0;
var filtro;
let perPage = 10;



$(document).ready(function(){
    var elements = document.getElementsByClassName("header");

    for (var i = 0; i < elements.length; i++) {
        elements[i].addEventListener('click', reordenar, false);
        console.log("Add Event Listener");
    }
});
  
var reordenar = function() {
    setTimeout(function () {
        console.log('atualizando');
        update();
    }, 200);
    
};

const estado = {
    page: 1,
    perPage,
    totalPage: 0
}
const controls =  {
    next(){
        estado.page ++
        
        if(estado.page > estado.totalPage){
            estado.page = 1;
        }
        update()
    },
    prev(){
        estado.page --
        
        if(estado.page < 1){
            estado.page = estado.totalPage;
        }
        update()
    },
    goTo(page){
        if(page <= 0){
            estado.page = 1
        }else if(page > estado.totalPage){
            estado.page = estado.totalPage
        }else{
            estado.page = page
        }
        update()
    }
}
const html = {
    get(element) {
        return document.querySelector(element)
    }
}
const tabela = html.get('.table-responsive');
function createButtons(){
    const buttons = document.createElement('div');
    buttons.classList.add('btnsPaginacao');

    const first = document.createElement('div');
    first.classList.add('btnPaginacao');
    first.id = 'first';
    first.innerHTML = '<i class="fas fa-fast-backward"></i>';
    first.addEventListener('click', (event) => {
        controls.goTo(1);
    })
    buttons.appendChild(first);

    const prev = document.createElement('div');
    prev.classList.add('btnPaginacao');
    first.id = 'prev';
    prev.innerHTML = '<i class="fas fa-step-backward"></i>';
    prev.addEventListener('click', (event) => {
        controls.prev();
    })
    buttons.appendChild(prev);


    const atual = document.createElement('div');
    atual.classList.add('btnPaginacao');
    atual.id = "paginaAtual";
    atual.innerHTML = estado.page;
    buttons.appendChild(atual);

    const next = document.createElement('div');
    next.classList.add('btnPaginacao');
    next.innerHTML = '<i class="fas fa-step-forward"></i>';
    next.addEventListener('click', (event) => {
        controls.next();
    })
    buttons.appendChild(next);

    const last = document.createElement('div');
    last.classList.add('btnPaginacao');
    last.innerHTML = '<i class="fas fa-fast-forward"></i>';
    last.addEventListener('click', (event) => {
        controls.goTo(estado.totalPage);
    })
    buttons.appendChild(last);

    tabela.appendChild(buttons);
}

function update(){
    html.get('#paginaAtual').innerHTML = estado.page;
    filtrarTabela(filtro);
}

function initPaginacao(){
    createButtons();
}

initPaginacao();
filtrarTabela("");
function filtrarTabela(pesquisa){
    filtro = pesquisa;
    var minPaginacao = ((estado.page - 1)*estado.perPage)+1;
    console.log("Min Pagina: " + minPaginacao);
    var maxPaginacao = (estado.page*estado.perPage);
    console.log("Max Pagina: " + maxPaginacao);
    soma = 0;
    countPage = 0;
    for(var i = 1; i < tbody.childNodes.length; i++){
        var achou = false;
        var tr = tbody.childNodes[i];
        var td = tr.childNodes;

        for(var j = 1; j < td.length - 1; j++){
            var value = td[j].childNodes[0].nodeValue.toLowerCase();
            // alert("Valor: "+ preco);
            if(value.indexOf(pesquisa) >= 0){
                achou = true;
            }
        }
        try{
            if (achou){
                countPage++
                console.log("Count Page: "+countPage);
                if(countPage>= minPaginacao && countPage<=maxPaginacao){
                    tr.style.display = "table-row";
                }else{
                    tr.style.display = "none";
                }   
                if (total.innerHTML !=""){
                    var preco = td[2].childNodes[0].nodeValue.toLowerCase();
                    totalTabela(preco);
                }
            }else{
                tr.style.display = "none";
            }
        }
        catch(e){
            console.log(e);
        }
    }
    estado.totalPage = Math.ceil(countPage/perPage);
    
}

function buscar(){
    var busca = document.getElementById('buscar').value.toLowerCase();
    filtrarTabela(busca);
}


function fnExcelReport(id){
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; 
    var j=0;
    var tab = document.getElementById(id); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}

function totalTabela(preco){
    preco = preco.replace(/[^\d]+/g,'');
    preco = parseInt(preco);
    soma = (soma + preco);
    somaFianl = soma/100;
    total.innerHTML = somaFianl.toLocaleString('pt-br',{style: 'currency', currency: 'BRL'});
}

function criarPaginacao(){
    
}
function excluir(id){
    href = window.location.href
    var res = href.split("index");
    if(confirm("Confirmar exclusão?")){
        window.location.href = res[0] + "excluir.php?id="+id;
    }
}