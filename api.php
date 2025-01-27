<?php

// Configuração do CPF e idioma fixos
define('CPF', '00000000001');
define('LANG_TYPE', 'PT');

define('API_URL', 'https://official.jtjms-br.com/official/logisticsTracking/v2/getDetailByWaybillNo');

// Verifica se o número de rastreio foi enviado via GET
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['waybillNo'])) {
    $waybillNo = $_GET['waybillNo'];

    // Valida se o número de rastreio não está vazio
    if (empty($waybillNo)) {
        http_response_code(400);
        echo json_encode(["error" => "Número de rastreio inválido ou não fornecido."]);
        exit;
    }

    // Cria o payload para a requisição
    $payload = [
        'waybillNo' => $waybillNo,
        'cpf' => CPF,
        'langType' => LANG_TYPE
    ];

    // Inicializa o cURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, API_URL);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json, text/plain, */*',
    'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
    'countryId: 1',
    'langType: PT',
    'timestamp: ' . round(microtime(true) * 1000), // Calcula o timestamp atual
    'timezone: GMT-3, GMT-3'
]);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    // Executa a requisição
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Fecha a conexão cURL
    curl_close($ch);

    // Verifica se houve erro na requisição
    if ($response === false || $http_code !== 200) {
        http_response_code($http_code);
        echo json_encode(["error" => "Erro na comunicação com o servidor."]);
        exit;
    }

    // Retorna a resposta da API
    header('Content-Type: application/json');
    echo $response;
} else {
    // Retorna erro se o número de rastreio não foi fornecido
    http_response_code(400);
    echo json_encode(["error" => "Por favor, forneça um número de rastreio no formato correto."]);
}
