<?php

// Listar Hash
function listarHash() {
  $VRetorno = new stdClass();
  $VRetorno->listaHash = hash_algos();
  return $VRetorno;
}

// Obter HASH
// $PParametro->hash - Hash escolhido
// $PParametro->criptografar - Informação a ser criptografada
function obterHash($PParametro) {
  $VRetorno = new stdClass();
  $VRetorno->criptografado = hash($PParametro->hash, $PParametro->criptografar);
  return $VRetorno;
}

// Criar senha utilizando método Blowfish
// $PParametro->senha - Senha digitada pelo usuário
function criarSenha($PParametro) {
  // Obter a senha criptografada por HASH
  $VParametro = new stdClass();
  $VParametro->hash = "sha3-512"; // SHA3-512 - 128 caracteres
  $VParametro->criptografar = $PParametro->senha;
  $VParametro = obterHash($VParametro);
  // Custo - Custo do processador para criar a criptografia BCript
  // Custo pode ser de 04 a 31 - Deve ter 2 dígitos (04, 05, ..., 31)
  // Lembrando que custo é a potência de 2, ou seja, quanto maior o custo, maior a segurança E o processamento
  // 2¹³ = 8.192 ciclos
  // 13 - https://www.dicionariodesimbolos.com.br/numero-13/
  $VCusto = "13";
  // BCript/Blowfish - Encriptação por custo de processamento
  // Esta é a chave que você deve gravar no BD
  $VChave = password_hash($VParametro->criptografado, PASSWORD_BCRYPT, ["cost" => $VCusto]);
  // Retorno
  $VRetorno = new stdClass();
  $VRetorno->chave = $VChave;
  return $VRetorno;
}

// Validar senha
// $PParametro->senha - Senha digitada pelo usuário
// $PParametro->chave - Chave salva no BD
function validarSenha($PParametro) {
  // Obter a senha criptografada por HASH
  $VParametro = new stdClass();
  $VParametro->hash = "sha3-512"; // SHA3-512 - 128 caracteres
  $VParametro->criptografar = $PParametro->senha;
  $VParametro = obterHash($VParametro);
  // Valida o HASH com a chave do BD
  $VValida = password_verify($VParametro->criptografado, $PParametro->chave);
  // Retorno
  $VRetorno = new stdClass();
  $VRetorno->valida = $VValida;
  return $VRetorno;
}

// Listar Métodos
function listarMetodos() {
  $VAMetodo = [];
  foreach (openssl_get_cipher_methods() as $VMetodo) {
    // Vetor de inicialização
    // Obter quantidade necessaria para vetor de inicialização
    $ivlen = openssl_cipher_iv_length($VMetodo);
    // Se este valor for diferente de zero
    if ($ivlen != 0) {
      // Gerar uma string pseudo-aleatória de bytes
      if ($iv = @openssl_random_pseudo_bytes($ivlen)) {
        $VAMetodo[] = $VMetodo;
      }
    }
  }

  $VRetorno = new stdClass();
  $VRetorno->listaMetodo = $VAMetodo;
  return $VRetorno;
}

// Encriptação simétrica
// $PParametro->encriptar - Mensagem que deve ser encriptada
// $PParametro->chave - Chave de encriptamento
// $PParametro->metodo - Método que deve ser utilizado,
function encriptacaoSimetrica($PParametro) {
  // Chave para encriptamento
  $VParametro = new stdClass();
  $VParametro->hash = "sha3-512"; // SHA3-512 - 128 caracteres
  $VParametro->criptografar = $PParametro->chave;
  $VParametro = obterHash($VParametro);
  $VBase64 = base64_encode($VParametro->criptografado);
  $VChave = str_replace("+", ".", ($VBase64));
  // Deve ser utilizada a opção 0. base64 = 0
  $VOpcao = 0;
  // Vetor de inicialização
  // Obter quantidade necessaria para vetor de inicialização
  $VVilen = openssl_cipher_iv_length($PParametro->metodo);
  // Completar chave com "." se necessário
  while (strlen($VChave) < $VVilen)
    $VChave .= ".";
  // Selecionar a quantidade necessaria de caracteres do vetor de inicializacao
  $VVi = substr($VChave, 0, $VVilen);
  // Mensagem encriptada
  $VEncriptada = openssl_encrypt($PParametro->encriptar, $PParametro->metodo, $VChave, $VOpcao, $VVi);

  // Retorno
  $VRetorno = new stdClass();
  $VRetorno->encriptada = $VEncriptada;
  return $VRetorno;
}

// Descriptação simétrica
// $PParametro->desencriptar - Mensagem que deve ser desencriptada
// $PParametro->chave - Chave para desencriptar
// $PParametro->metodo - Método que deve ser utilizado,
function descriptacaoSimetrica($PParametro) {
  // Chave para descriptar
  $VParametro = new stdClass();
  $VParametro->hash = "sha3-512"; // SHA3-512 - 128 caracteres
  $VParametro->criptografar = $PParametro->chave;
  $VParametro = obterHash($VParametro);
  $VBase64 = base64_encode($VParametro->criptografado);
  $VChave = str_replace("+", ".", ($VBase64));
  // Deve ser utilizada a opção 0. base64 = 0
  $VOpcao = 0;
  // Vetor de inicialização
  // Obter quantidade necessaria para vetor de inicialização
  $VVilen = openssl_cipher_iv_length($PParametro->metodo);
  // Completar chave com "." se necessário
  while (strlen($VChave) < $VVilen)
    $VChave .= ".";
  // Selecionar a quantidade necessaria de caracteres do vetor de inicializacao
  $VVi = substr($VChave, 0, $VVilen);
  // Mensagem desencriptada
  $VDesencriptada = openssl_decrypt($PParametro->desencriptar, $PParametro->metodo, $VChave, $VOpcao, $VVi);
  // Retorno
  $VRetorno = new stdClass();
  $VRetorno->desencriptada = $VDesencriptada;
  return $VRetorno;
}

// Encriptação Ascii/Hexadecimal
// $PParametro->encriptar - Mensagem que deve ser encriptada
// $PParametro->chave - Chave de encriptamento
function encriptacaoAsciiHexadecimal($PParametro) {
  $VParametro = new stdClass();
  $VParametro->encriptar = $PParametro->encriptar;
  $VParametro->chave = $PParametro->chave;
  $VParametro->metodo = "aes-256-cbc"; // Gosto de trabalhar com este método pois dá 64 caracteres
  $VEncriptar = encriptacaoSimetrica($VParametro);

  $VALetras =  str_split($VEncriptar->encriptada, 1);
  $VEncriptada = "";
  foreach ($VALetras as $VLetra) {
    $VAscii = ord($VLetra);
    $VHexadecimal = dechex($VAscii);
    if (strlen($VHexadecimal) == 1) $VHexadecimal = "0" . $VHexadecimal;
      $VEncriptada .= $VHexadecimal;
  }

  // Retorno
  $VRetorno = new stdClass();
  $VRetorno->encriptada = $VEncriptada;
  return $VRetorno;
}

// Descriptação Ascii/Hexadecimal
function descriptacaoAsciiHexadecimal($PParametro) {
  $VAHexadecimais =  str_split($PParametro->desencriptar, 2);
  $VDescriptografado = "";
  foreach ($VAHexadecimais as $VHexadecimal) {
    $VDecimal = hexdec($VHexadecimal);
    $VLetra = chr($VDecimal);
    $VDescriptografado .= $VLetra;
  }

  $VParametro = new stdClass();
  $VParametro->desencriptar = $VDescriptografado;
  $VParametro->chave = $PParametro->chave;
  $VParametro->metodo = "aes-256-cbc"; // Gosto de trabalhar com este método pois dá 64 caracteres
  $VRetorno = descriptacaoSimetrica($VParametro);
  return $VRetorno;
}

// Salt - Dado aleatório - pattern: ./A-Za-z0-9
// $PParametro->quantidade - Quantidade desejada de caracteres
function salt($PParametro) {
  // Gerar uma string pseudo-aleatória de bytes
  $VString = openssl_random_pseudo_bytes($PParametro->quantidade);
  // Codificar o pseugo-aleatório para a base 64
  $VBase64 = base64_encode($VString);
  // Obtem a quantidade necessária de digitos
  $VSubstr = substr($VBase64, 0, $PParametro->quantidade);
  // Substituir + por . para ficar com pattern ./A-Za-z0-9
  $VSalt = str_replace("+", ".", $VSubstr);

  // Retorno
  $VRetorno = new stdClass();
  $VRetorno->salt = $VSalt;
  return $VRetorno;
}










// Função que executa a solicitação do JQuery (Função e Parâmetros)
function ChamaFuncaoPHP() {
  $VFunc = $_POST["PFuncao"];
  $VParams = new stdClass;
  if (isset($_POST["PParametros"]))
    if (!empty($_POST["PParametros"]))
      $VParams = $_POST["PParametros"];

  $VRetorno = call_user_func($VFunc, (object)$VParams);

  if ($VRetorno == "")
    $VRetorno = "Sem retorno";

  if ($_SERVER["HTTP_ACCEPT"] == "application/json, text/javascript, */*; q=0.01")
    echo json_encode($VRetorno);
  else
    echo $VRetorno;
  exit;
}

// Chamada inicial
ChamaFuncaoPHP();