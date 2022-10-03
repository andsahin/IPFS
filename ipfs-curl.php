<?php 

    /** create curl file */
    $cFile = curl_file_create($_FILES['logo']['tmp_name'], $_FILES['logo']['type'], $_FILES['logo']['name']);

  if (!empty($cFile)) { 
    /** metakey and meta values */
    $keyvalues = [
      'company' => 'BDTASK',
      'background' => '100% Trait',
      'Color' => 'RED',
    ];
    /** metadata array */
    $metadata = [
      'name' => 'This is test file',
      'keyvalues' => $keyvalues,
    ];

    /** post data array */
    $post = array(
      'file' => $cFile,
      'pinataMetadata' => json_encode($metadata)
    );

    /** header info pinata jwt authentication */
    $headers = array();
    $headers[] = 'Authorization: Bearer your-pinata-jwt';

    $url = "https://api.pinata.cloud/pinning/pinFileToIPFS";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    print_r(json_decode($result)); // get file CID 
  }