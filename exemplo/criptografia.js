$(document).ready(function() {

  // Select com hash
  $.ajax({
    url: "../biblioteca/criptografia.php",
    method: "POST",
    data: {
      funcao: "listarHash",
      parametros: ""
    },
    dataType: "json",
    success: function(data, textStatus, jqXHR) {
      $("#hash #hashes").html("");
      for (var i = 0; i < data.length; i++) {
        $("#hash #hashes").append("<option>"+data[i]+"</option>");
      }
    }
  });

  // Select com metodos
  $.ajax({
    url: "../biblioteca/criptografia.php",
    method: "POST",
    data: {
      funcao: "listarMetodos",
      parametros: ""
    },
    dataType: "json",
    success: function(data, textStatus, jqXHR) {
      $("#simetrica #metodo").html("");
      for (var i = 0; i < data.length; i++) {
        $("#simetrica #metodo").append("<option>"+data[i]+"</option>");
      }
    }
  });

  // Exemplo de criptografia por hash
  $("#hash #senha").on("keyup", function() {
    var criptografar = $(this).val();
    if (criptografar != "") {
      var hash = $("#hash #hashes option:selected").html();
      $.ajax({
        url: "../biblioteca/criptografia.php",
        method: "POST",
        data: {
          funcao: "pegarHash",
          parametros: {
            criptografar: criptografar,
            hash: hash
          }
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR) {
          $("#hash #resultado").html("Quantidade de caracteres: " + data.hash.length + "<br>" +
            "Hash: " +data.hash);
        }
      });
    }
    else
    {
      $("#hash #resultado").html("");
    }
  });

  $("#hash #hashes").on("change", function() {
    $("#hash #senha").trigger("keyup");
  });

  // Exemplo de criptografia blowfish
  $("#blowfish #criar #senha").on("keyup", function() {
    var criptografar = $(this).val();
    if (criptografar == "") {
      $("#blowfish #criar #informacao").html("");
      $("#blowfish #criar #criptografado").html("");
    }
    // Window Object Methods - atob e btoa
    // btoa - Codifica para base64
    // atob - Decodifica de base64
    var base64 = btoa(criptografar);
    $("#blowfish #criar #informacao").html("Senha enviada para o servidor - btoa(\"" + criptografar + "\") = " + base64 + " (Confira apertando F12 / Network)<br>");
    $.ajax({
      url: "../biblioteca/criptografia.php",
      method: "POST",
      data: {
        funcao: "blowfish",
        parametros: {
          opcao: "criptografar",
          criptografar: base64
        }
      },
      dataType: "json",
      success: function(data, textStatus, jqXHR) {
        $("#blowfish #criar #criptografado").html("Informação que deve ser salva no banco de dados: "+data.criptografado);
        $("#blowfish #validar #criptografado").val(data.criptografado);
      }
    });
  });
  // Exemplo de validação de criptografia blowfish
  $("#blowfish #validar #valida").on("keyup", function() {
    var validar = $(this).val();
    if (validar == "") {
      $("#blowfish #validar #informacao").css("display", "none");
    }
    else
    {
      $("#blowfish #validar #informacao").css("display", "block");
      var criptografado = $("#blowfish #validar #criptografado").val();
      $("#blowfish #validar #informacao").css("display", valida == "" ? "none" : "block");
      // Window Object Methods - atob e btoa
      // btoa - Codifica para base64
      // atob - Decodifica de base64
      var base64 = btoa(validar);
      $("#blowfish #validar #informacao").html("Senha enviada para o servidor - btoa(\"" + validar + "\") = "+base64);
      $.ajax(
      {
        url: "../biblioteca/criptografia.php",
        method: "POST",
        data: {
          funcao: "blowfish",
          parametros: {
            opcao: "validar",
            validar: base64,
            criptografado: criptografado
          }
        },
        dataType: "json",
        success: function(data, textStatus, jqXHR){
          if (data.validado) $("#blowfish #validar #resultado").html("Senha validada!");
          else $("#blowfish #validar #resultado").html("Senha não validada!");
        }
      });
    }
  });

  $("#blowfish #validar #criptografado").on("keyup", function() {
    $("#blowfish #validar #valida").trigger("keyup");
  });

  $("#simetrica #criar #mensagem").on("keyup", function() {
    var dados = $(this).val();
    var metodo = $("#simetrica #criar #metodo option:selected").html();
    $.ajax(
    {
      url: "../biblioteca/criptografia.php",
      method: "POST",
      data: {
        funcao: "encriptacaoSimetrica",
        parametros: {
          dados: dados,
          metodo: metodo
        }
      },
      dataType: "json",
      success: function(data, textStatus, jqXHR){
        $("#simetrica #criar #resultado").html("Encriptado: "+data.encriptado+"<br>Chave: "+data.chave);
      }
    });
  });

  $("#simetrica #criar #metodo").on("change", function() {
    $("#simetrica #criar #mensagem").trigger("keyup");
  });

  $("#simetrica #validar #criptografado").on("keyup", function() {
    $("#simetrica #validar #resultado").html("");
    var dados = $(this).val();
    var metodo = $("#simetrica #validar #metodo option:selected").html();
    var chave = $("#simetrica #validar #chave").val();
    $.ajax(
    {
      url: "../biblioteca/criptografia.php",
      method: "POST",
      data: {
        funcao: "descriptacaoSimetrica",
        parametros: {
          dados: dados,
          metodo: metodo,
          chave: chave
        }
      },
      dataType: "json",
      success: function(data, textStatus, jqXHR){
        if (data.descriptado != false) $("#simetrica #validar #resultado").html("Descriptografado a mensagem: "+data.descriptado);
        else $("#simetrica #validar #resultado").html("Mensagem e/ou chave está(ão) incorreta(s)!");
      },
      error: function(data)
      {
        console.log(data);
      }
    });
  });

  $("#simetrica #validar #chave").on("keyup", function() {
    $("#simetrica #validar #criptografado").trigger("keyup");
  });

  $("#simetrica #validar #metodo").on("change", function() {
    $("#simetrica #validar #criptografado").trigger("keyup");
  });

});