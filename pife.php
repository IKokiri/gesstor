<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <title>PIFE</title>
    
</head>
<body>
<br>
<div class="container">

    <div class="text-center">
        <h1>PIFE</h1>
    </div>
    
    <div class="form-row">
    <div class="form-group col-3">
            <input type="text" class="form-control" name="jogo" id="jogo" placeholder="JOGO Nº">
        </div>
        <div class="form-group col-3">
            <input type="text" class="form-control" name="sigla" id="sigla" placeholder="SIGLA">
        </div>
        <div class="form-group col-6">
            <input type="number" class="form-control" name="pontos" value="0" id="pontos" placeholder="PONTOS">
        </div>
    </div>
  <div class="form-group">
    <input type="text" class="form-control" name="valor" id="valor" value="0,5" placeholder="VALOR">
  </div>
  <div class="form-row text-center">
        <div class="form-group col-4">
        <a href="javascript:void(0)" onclick="adicionarParticipante()"><i class="fas fa-plus"></i></a>
        </div>
        <div class="form-group col-4">
        <a href="javascript:void(0)" onclick="limpar()"><i class="fas fa-trash-alt"></i></a>
        </div>
        <div class="form-group col-4">
        <a href="javascript:void(0)" onclick="calcular()"><i class="fas fa-sync-alt"></i></a>
        </div>
    </div>
    
    <table class="table table-striped">
  <thead>
    <tr>
      <th scope="col"><i class="fas fa-arrow-up"></i></th>
      <th scope="col">Sigla</th>
      <th scope="col">Pontos</th>
      <th scope="col">Total</th>
      <th scope="col"><i class="fas fa-arrow-down"></i></th>
    </tr>
  </thead>
  <tbody class="grid">

  </tbody>
</table>
    
</div>

</body>
</html>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>

url = "http://localhost/gesstor/pifeServer.php";
// url = "http://201.49.127.157:9003/gesstor/pifeServer.php";
// url = "http://10.0.0.252:8090/gesstor/pifeServer.php";

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
                +"<td><a href='javascript:void(0)'class='remover' data-sigla='"+key+"'><i class='fas fa-arrow-down'></i></a></td>"
                +"<td>"+key+"</td>"
                +"<td>"+value.pontos+"</td>"
                +"<td>"+value.total+"</td>"
                +"<td><a href='javascript:void(0)' class='adicionar' data-sigla='"+key+"'><i class='fas fa-arrow-up'></i></a></td>"
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