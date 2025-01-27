<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['waybillNo'])) {
    $waybillNo = $_POST['waybillNo'];

    // Verifica se o arquivo api.php existe
    if (!file_exists('api.php')) {
        $trackingData = [
            'error' => 'api.php não encontrada.'
        ];
    } else {
        // Fazendo requisição para o api.php
		//
		//
		// >> ALTERE A URL DA API ($apiUrl) PARA O URL CORRETO <<
        $apiUrl = 'http://localhost/api.php?waybillNo=' . urlencode($waybillNo);
		//
		//
        $response = @file_get_contents($apiUrl);

        if ($response === false) {
            $trackingData = [
                'error' => 'Erro ao conectar-se à API.'
            ];
        } else {
            $trackingData = json_decode($response, true);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastreamento J&T Express</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 70%;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .tracking-info {
            margin-top: 20px;
        }

        .tracking-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .tracking-item:last-child {
            border-bottom: none;
        }

        .scan-time {
            font-weight: bold;
            color: #555;
        }

        .status {
            color: #007BFF;
        }

        .customer-tracking {
            margin-top: 5px;
            color: #333;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Rastreamento J&T Express</h1>
        <form method="POST">
            <input type="text" name="waybillNo" placeholder="Insira o código de rastreio" required>
            <button type="submit">Rastrear</button>
        </form>

        <?php if (isset($trackingData['error'])): ?>
            <p class="error-message">Erro: <?= htmlspecialchars($trackingData['error']) ?></p>
        <?php elseif (isset($trackingData) && $trackingData['succ']): ?>
            <div class="tracking-info">
                <h2>Detalhes do Rastreamento</h2>
                <?php if (!empty($trackingData['data']['details'])): ?>
                    <?php foreach ($trackingData['data']['details'] as $detail): ?>
                        <div class="tracking-item">
                            <div class="scan-time">Data: <?= htmlspecialchars($detail['scanTime']) ?></div>
                            <div class="status">Status: <?= htmlspecialchars($detail['status']) ?></div>
                            <div class="customer-tracking">Descrição: <?= htmlspecialchars($detail['customerTracking']) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="error-message">Nenhum detalhe encontrado para este código de rastreio.</p>
                <?php endif; ?>
            </div>
        <?php elseif (isset($trackingData)): ?>
            <p class="error-message">Código de rastreio inválido ou inexistente.</p>
        <?php endif; ?>
    </div>
</body>
</html>