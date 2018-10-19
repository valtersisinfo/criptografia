<?php

  // Salt - Dado aleatório - pattern: ./A-Za-z0-9
  function salt($parametros) {
    // Gerar uma string pseudo-aleatória de bytes
    $string = openssl_random_pseudo_bytes($parametros->quantidade);
    // Codificar o pseugo-aleatório para a base 64
    $base64 = base64_encode($string);
    // Obter apenas os primeiros 22 dígitos
    $substr = substr($base64, 0, $parametros->quantidade);
    // Substituir + por .
    $salt = str_replace("+", ".", $substr);
    // Retornar o resultado
    $retorno = new stdClass();
    $retorno->salt = $salt;
    return $salt;
  }

  function blowfish($parametros) {
    switch ($parametros->opcao) {
      case 'criptografar':
        // Parâmetros recebidos
        $criptografar = $parametros->criptografar;
        // HASH - SHA2 - SHA512 -Hash de 64 bytes - 128 caracteres
        $sha512 = hash("sha512", $criptografar);
        // Respeitar 22 digitos - pattern: ./A-Za-z0-9
        $parametros->quantidade = 22;
        $salt = salt($parametros);
        // Custo - Custo do processador para criar uma criptografia BCript
        // Custo pode ser de 04 a 31 - Deve ter 2 dígitos (04, 05, ..., 31)
        // Lembrando que custo é a potência de 2, ou seja, quanto maior o custo, maior a segurança e o processamento
        // 2¹³ = 8.192 ciclos
        // 13 - https://www.dicionariodesimbolos.com.br/numero-13/
        $custo = "13";
        // BCript/Blowfish - Encriptação por custo de processamento
        // $2a$ = Codificação BCript/Blowfish para obter 64 caracteres
        $bcrypt = crypt($sha512, "$2a$".$custo."$".$salt."$");
        // Retornar o resultado
        $retorno = new stdClass();
        $retorno->criptografado = $bcrypt;
        return $retorno;
      break;
      case 'validar':
        // Parâmetros recebidos
        $validar = $parametros->validar;
        $criptografado = $parametros->criptografado;
        // HASH - Codificar para poder comparar com o hash
        // SHA2 - SHA512 -Hash de 64 bytes - 128 caracteres
        $sha512 = hash("sha512", $validar);
        $validado = crypt($sha512, $criptografado) === $criptografado;
        // Retornar o resultado
        $retorno = new stdClass();
        $retorno->validado = $validado;
        return $retorno;
      break;
    }
  }

  function encriptacaoSimetrica($parametros) {
    // Dados a serem encriptados
    $dados = $parametros->dados;
    // Metodo que será utilizado
    $metodo = $parametros->metodo;
    // Chave para comunicação
    $parametros->quantidade = 22;
    $chave = salt($parametros);
    // Opção a ser utilizada base64 = 0
    $opcao = 0;
    // Vetor de inicialização
    $vilen = openssl_cipher_iv_length($metodo);
    $parametros->quantidade = $vilen;
    $vi = salt($parametros);
    // Encriptação dos dados
    $encrypt = openssl_encrypt($dados, $metodo, $chave, $opcao, $vi);
    // Retornar o resultado
    $retorno = new stdClass();
    $retorno->encriptado = $encrypt;
    $retorno->chave = $chave.$vi;
    return $retorno;
  }

  function descriptacaoSimetrica($parametros) {
    // Metodo que será utilizado
    $metodo = $parametros->metodo;
    // Vetor de inicialização
    $vi = substr($parametros->chave, 22);
    // Classe de retorno
    $retorno = new stdClass();
    $retorno->descriptado = false;
    // Verifica se bate o tamanho do vetor de inicialização
    if (strlen($vi) == openssl_cipher_iv_length($metodo)) {
      // Dados a serem descriptados
      $dados = $parametros->dados;
      // Chave para comunicação
      $chave = substr($parametros->chave, 0, 22);
      // Opção a ser utilizadad
      $opcao = 0;
      // Descriptação dos dados
      $decrypt = openssl_decrypt($dados, $metodo, $chave, $opcao, $vi);
      // Retorna a descriptação
      $retorno->descriptado = $decrypt;
    }
    return $retorno;
  }

  function pegarHash($parametros) {
    // Hash requerido
    $hash = $parametros->hash;
    // Dados a serem hashed
    $criptografar = $parametros->criptografar;
    // Gerar o hash
    $hash = hash($hash, $criptografar);
    // Retornar o resultado
    $retorno = new stdClass();
    $retorno->hash = $hash;
    return $retorno;
  }

  function listarMetodos() {
    return openssl_get_cipher_methods();
  }

  function listarHash() {
    return hash_algos();
  }

  function ajax()
  {
    $VResult = call_user_func($_POST["funcao"], (object)$_POST["parametros"]);
    echo json_encode($VResult);
    exit;
  }

  ajax();