<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Grandus Docker Test App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg bg-dark navbar-dark shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">GRANDUS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/info.php">PHP Info</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">

    <section id="database" class="mt-5">
        <?php
        // Database configuration
        $host = 'db'; // Database host
        $db = 'grandus'; // Database name
        $user = 'root'; // Database user
        $pass = 'admin'; // Database password
        $charset = 'utf8mb4'; // Character set

        // Data Source Name (DSN)
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        // Options for PDO
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch results as associative arrays
            PDO::ATTR_EMULATE_PREPARES => false,                  // Use native prepared statements
        ];

        $isConnected = false;
        $errorMessage = '';

        try {
            // Create a PDO instance
            $pdo = new PDO($dsn, $user, $pass, $options);
            $isConnected = true;
        } catch (PDOException $e) {
            // Handle connection error
            $errorMessage = $e->getMessage();
        }
        ?>

        <div class="card shadow <?= $isConnected ? 'border-success' : 'border-danger' ?>">
            <div class="card-header text-light <?= $isConnected ? 'bg-success' : 'bg-danger' ?>">
                Database
            </div>
            <div class="card-body">
                <?php if ($isConnected): ?>
                    <p class="leading-2 mb-0 text-success">Successfully connected to MariaDB</p>
                <?php else: ?>
                    <p class="leading-2 mb-0 text-danger"><?= $errorMessage ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <section id="elastic" class="mt-5">
        <?php

        // Elasticsearch host and port
        $host = 'http://elasticsearch:9200'; // Adjust to your setup if necessary

        // Initialize a cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Timeout after 5 seconds

        // Execute the request
        $response = curl_exec($ch);
        $isConnected = false;
        $errorMessage = '';
        $data = [];

        // Check for connection errors
        if (curl_errno($ch)) {
            $errorMessage = "Error: Unable to connect to Elasticsearch. " . curl_error($ch);
        } else {
            // Decode the JSON response
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($statusCode === 200) {
                $data = json_decode($response, true);
                $isConnected = true;
            } else {
                $errorMessage = "Elasticsearch is not responding. HTTP status code: $statusCode\n";
            }
        }

        // Close the cURL session
        curl_close($ch);
        ?>

        <div class="card shadow <?= $isConnected ? 'border-success' : 'border-danger' ?>">
            <div class="card-header text-light <?= $isConnected ? 'bg-success' : 'bg-danger' ?>">
                ElasticSearch
            </div>
            <div class="card-body">
                <?php if ($isConnected): ?>
                    <p class="leading-2 text-success">Successfully connected to ElasticSearch</p>
                    <pre class="text-sm"><code><?= json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?></code></pre>
                <?php else: ?>
                    <p class="leading-2 mb-0 text-danger"><?= $errorMessage ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
</body>
</html>