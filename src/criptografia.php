<?php
  // Chamar a funcao especificada
  call_user_func($_POST["funcao"], $_POST["parametros"]);

  function criptografar($parametros)
  {
    // Mesagem recebida pelo AJAX
    $mensagem = $parametros["mensagem"];

    // HASH - Codificar para ser praticamente impossível inverter. Será utilizado por BCript
    // SHA2 - SHA512 -Hash de 64 bytes - 128 caracteres
    $sha512 = hash("sha512", $mensagem);

    // Custo - Custo do processador para criar uma criptografia BCript
    // Custo pode ser de 04 a 31 - Deve ter 2 dígitos (04, 05, ..., 31)
    // Lembrando que custo é a potência de 2, ou seja, quanto maior o custo, maior a segurança e o processamento
    // 2¹³ = 8.192 ciclos
    // 13 - https://www.dicionariodesimbolos.com.br/numero-13/
    $custo = "13";

    // Salt - Dado aleatório
    // Definir Salt sem informação
    $salt = "";
    // Definir o tamanho do salt (22 caracteres para usar no BCript)
    $tamanhoSalt = 22;
    // Criar um array de amostra com 62 caracteres (a-z, A-Z, 0-9)
    $amostra = array_merge(range("a", "z"),range("A", "Z"),range("0", "9"));
    // Embaralhar a amostra
    shuffle($amostra);
    // Obter itens aleatórios da amostra
    $aleatorio = array_rand($amostra, $tamanhoSalt);
    // For para pecorrer a amostra e obter uma letra ou número aleatório
    for ($i = 0; $i < $tamanhoSalt; $i++){
      $salt .= $amostra[$aleatorio[$i]];
    }

    // BCript/Blowfish - Encriptação por custo de processamento
    // $2a$ = Codificação BCript/Blowfish para obter 64 caracteres
    $bcrypt = crypt($sha512, "$2a$".$custo."$".$salt."$");

    // Elimino a codificação BCript e o custo
    $criptografado = str_replace("$2a$13$", "", $bcrypt);

    // Nesta parte será necessário salvar no BD, mas para teste salvarei em sessão e vou retornar o criptografado
    session_start();
    $_SESSION["criptografado"] = $criptografado;
    echo $criptografado;
    // Nesta parte será necessário salvar no BD, mas para teste salvarei em sessão e vou retornar o criptografado
  }

  function validar($parametros)
  {
    // Mesagem recebida pelo AJAX
    $mensagem = $parametros["mensagem"];

    // HASH - Codificar para ser praticamente impossível inverter. Será utilizado por BCript
    // SHA2 - SHA512 -Hash de 64 bytes - 128 caracteres
    $sha512 = hash("sha512", $mensagem);

    // Nesta parte deve ir no banco e buscar o BCript/Blowfish, mas para teste pegarei da sessão
    session_start();
    $senhabd = $_SESSION["criptografado"];
    // Nesta parte deve ir no banco e buscar o BCript/Blowfish, mas para teste pegarei da sessão

    $criptografada = "$2a$13$".$senhabd;
    echo json_encode(crypt($sha512, $criptografada) === $criptografada);
  }