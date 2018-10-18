<?php

$mensagem = "O rato roeu a roupa do rei de roma";
echo $mensagem . "<br>";
$key = openssl_random_pseudo_bytes(22);
echo $key . "<br>";


echo "<table><tbody>";
foreach (openssl_get_cipher_methods() as $method) {
  // Obter o tamanho iv da cifra
  $ivlen = openssl_cipher_iv_length($method);
  // Gerar uma string pseudo-aleatória de bytes
  $iv = openssl_random_pseudo_bytes($ivlen);
  $encrypt = openssl_encrypt($mensagem, $method, $key, OPENSSL_RAW_DATA, $iv);
  $decrypt = openssl_decrypt($encrypt, $method, $key, OPENSSL_RAW_DATA, $iv);
  echo "<tr><td><b>".$method."</b></td><td>".strlen($encrypt)."</td><td>".$encrypt."</td><td>".$decrypt."</td></tr>";
}
echo "</tbody></table>";

echo "<table><tbody>";
foreach (hash_algos() as $hash)
{
  $hash_result = hash($hash, $mensagem);
  echo "<tr><td><b>".$hash."</b></td><td>".strlen($hash_result)."</td><td>".$hash_result."</td></tr>";
}
echo "</tbody></table>";
?>