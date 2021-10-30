<?php
class NewTel
{
  function __construct(array $config)
  {
    $this->config = $config;
  }
  public function getKey(
    $methodName,
    $params
  ) {
    $time = time();
    return $this->config['keyNewtel'] . $time . hash(
      'sha256',
      $methodName . "\n" . $time . "\n" . $this->config['keyNewtel'] . "\n" .
        $params . "\n" . $this->config['writeKey']
    );
  }
  public function make_request(string $method, array $data)
  {
    $resId = curl_init('https://api.new-tel.net/' . $method);
    $data = json_encode($data);
    $key = $this->getKey($method, $data);

    curl_setopt_array($resId, [
      CURLINFO_HEADER_OUT => true,
      CURLOPT_HEADER => 0,
      CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $key,
        'Content-Type: application/json',
      ],
      CURLOPT_POST => true,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_POSTFIELDS => $data,
    ]);

    $response = curl_exec($resId);
    $info = curl_getinfo($resId);
    curl_close($resId);

    return ['data' => json_decode($response), 'info' => $info];
  }
}
