<?php

$mensagem = "O rato roeu a roupa do rei de roma";

echo "Mensagem para ser criptografada:<br><b>" . $mensagem . "</b><br><br>";

$string = openssl_random_pseudo_bytes(22);
// Codificar o pseugo-aleatório para a base 64
$base64 = base64_encode($string);
// Obter apenas os primeiros 22 dígitos
$substr = substr($base64, 0, 22);
// Substituir + por .
$key = str_replace("+", ".", $substr);

$arrayMetodos = openssl_get_cipher_methods();

//$arrayMetodos = ["AES-128-CBC", "AES-128-CBC-HMAC-SHA1", "AES-128-CBC-HMAC-SHA256", "AES-192-CBC", "AES-256-CBC", "AES-256-CBC-HMAC-SHA1", "AES-256-CBC-HMAC-SHA256", "CAMELLIA-128-CBC", "CAMELLIA-192-CBC", "CAMELLIA-256-CBC", "SEED-CBC", "aes-128-cbc", "aes-128-cbc-hmac-sha1", "aes-128-cbc-hmac-sha256", "aes-192-cbc", "aes-256-cbc", "aes-256-cbc-hmac-sha1", "aes-256-cbc-hmac-sha256", "camellia-128-cbc", "camellia-192-cbc", "camellia-256-cbc", "seed-cbc"];

echo "<table>

<thead>
<tr>
<th>Método</th>
<th>ivlen</th>
<th>Tamanho</th>
<th>Criptografado</th>
<th>Descriptografado</th>
<tbody>";


foreach ($arrayMetodos as $method) {
  // Obter o tamanho iv da cifra
  $ivlen = openssl_cipher_iv_length($method);
  // Gerar uma string pseudo-aleatória de bytes
  $iv = openssl_random_pseudo_bytes($ivlen);

  $encrypt = openssl_encrypt($mensagem, $method, $key, 0, $iv);
  $decrypt = openssl_decrypt($encrypt, $method, $key, 0, $iv);

 	echo "<tr><td><b>".$method."</b></td><td><b>".$ivlen."</b></td><td>".strlen($encrypt)."</td><td>".$encrypt."</td><td>".$decrypt."</td></tr>";
}

echo "</tbody></table><br>";

echo "<table><tbody>";
foreach (hash_algos() as $hash)
{
  $hash_result = hash($hash, $mensagem);
  echo "<tr><td><b>".$hash."</b></td><td>".strlen($hash_result)."</td><td>".$hash_result."</td></tr>";
}
echo "</tbody></table>";
?>