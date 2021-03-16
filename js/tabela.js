function filtrarTabela(status){
    var pesquisa = status.toLowerCase();
    var tbody = document.getElementById('tbody');
    for(var i = 1; i < tbody.childNodes.length; i++){
        var achou = false;
        var tr = tbody.childNodes[i];
        var td = tr.childNodes;

        for(var j = 1; j < td.length - 1; j++){
            var value = td[j].childNodes[0].nodeValue.toLowerCase();
            if(value.indexOf(pesquisa) >= 0){
                achou = true;
            }
        }

        if (achou){
            tr.style.display = "table-row";
        }else{
            tr.style.display = "none";
        }
    }
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