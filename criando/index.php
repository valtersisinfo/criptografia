<?php

  $remote_public_key = "00b4cb2f6ee18d7defca6a2d2bd26563d74d981405e2180ba98e22a8d96e93f24e2f0750ad1d00d35a0379fa3736cc7b5e8f0e6d1718cb829a33e3b12cc6c8447b4c760f14e013385ab62de4ddc5f45b608aa4fef0c9e06b832f573e7c9a895a0d00f1be40528854bf1d37e7c87e255f5f892f00e7e5848b850eb46e5aef337ff212d12e114e44660ba040690f38d293e79ab781e629e2153f5f324789196505f132680dc97ea0b4f306ab4f7d027c5c294932cbce7ca49c818d29acf9f7a977c83a36cff9a0571cff020f21dd2eda5ee20942e05fea32b26896b6e7f3af92eed3e0701b02741c0ff7aa699ff01cb71f8144f27b0e43041dc96d9d4af279aec9b3";

  $local_priv_key = openssl_pkey_get_private("file://exemplo/privatekey.pem");
  var_dump($local_priv_key);

  $shared_secret = openssl_dh_compute_key(hex2bin($remote_public_key), $local_priv_key);
  var_dump($shared_secret);


  $config = array(
      "digest_alg" => "sha512",
      "private_key_bits" => 4096,
      "private_key_type" => OPENSSL_KEYTYPE_RSA,
  );

  // Create the private and public key
  $res = openssl_pkey_new($config);

  // Extract the private key from $res to $privKey
  openssl_pkey_export($res, $privKey);

  // Extract the public key from $res to $pubKey
  $pubKey = openssl_pkey_get_details($res);
  $pubKey = $pubKey["key"];

  $data = 'plaintext data goes here';

  // Encrypt the data to $encrypted using the public key
  openssl_public_encrypt($data, $encrypted, $pubKey);

  // Decrypt the data using the private key and store the results in $decrypted
  openssl_private_decrypt($encrypted, $decrypted, $privKey);

  echo $decrypted;

  $pkey = openssl_pkey_new("TESTE");
  $spkac = openssl_spki_new($pkey, 'testing');

  if ($spkac !== NULL) {
      echo $spkac;
  } else {
      echo "SPKAC generation failed";
  }
?>