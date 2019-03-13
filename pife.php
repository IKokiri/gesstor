<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <input type="text" name="sigla" id="sigla" placeholder="SIGLA">
    <input type="text" name="pontos" id="pontos" placeholder="PONTOS">
    <input type="text" name="valor" id="valor" placeholder="VALOR">

    <a href="javascript:void(0)" onclick="adicionarParticipante()">Adicionar</a>
    <a href="javascript:void(0)" onclick="limpar()">Limpar Tudo</a>
    <a href="javascript:void(0)" onclick="calcular()">Atualizar</a>

    <table border='1'>
        <thead>
            <tr>
                <td>-</td>
                <td>Sigla</td>
                <td>Pontos</td>
                <td>Total</td>
                <td>+</td>
            </tr>
        </thead>
        <tbody class="grid">
            
        </tbody>

    </table>
</body>
</html>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
url = "http://localhost/gesstor/pifeServer.php";

function calcular(){

    valor = $("#valor").val().replace(",",".");
    
    data = {  
        func : "calcular",
        valor: valor
    }


    $.post(url,data,function(result){
        tbody = "";
        $.each(result, function (key, value) {
            
            tbody +="<tr>"
                +"<td><a href='javascript:void(0)'class='remover' data-sigla='"+key+"'>-</a></td>"
                +"<td>"+key+"</td>"
                +"<td>"+value.pontos+"</td>"
                +"<td>"+value.total+"</td>"
                +"<td><a href='javascript:void(0)' class='adicionar' data-sigla='"+key+"'>+</a></td>"
                +"</tr>";

        })
        $(".grid").html(tbody);
    },"json")
}


function remover(sigla){    
    sigla = sigla;
    func = "remover";

    data = {     
        func: func,
        sigla : sigla
    }

    $.post(url,data,function(result){
       calcular();
    },"json")
}

function adicionar(sigla){
    sigla = sigla;
    func = "adicionar";

    data = {     
        func: func,
        sigla : sigla
    }

    $.post(url,data,function(result){
       calcular();
    },"json")
}

function adicionarParticipante(){

    sigla = $("#sigla").val();
    pontos = $("#pontos").val();
    func = "addPlayer";

    data = {     
        func: func,
        sigla : sigla,
        pontos : pontos
    }

    $.post(url,data,function(result){
       calcular();
    },"json")
}

function limpar(){

    func = "limpar";

    data = {     
        func: func
    }

    $.post(url,data,function(result){
        
        calcular();
    },"json")
}



$(document).ready(function(){
    
    $(document).on("click",".remover",function(){
        sigla = $(this).data("sigla");
        remover(sigla);
    })
    $(document).on("click",".adicionar",function(){
        sigla = $(this).data("sigla");
        adicionar(sigla);
    })
    
})
</script>