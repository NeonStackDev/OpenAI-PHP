<?php

require __DIR__ . '/vendor/autoload.php';

// Load .env file manually
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && $line[0] !== '#') {
            [$key, $value] = explode('=', $line, 2);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

$apiKey = getenv('YOUR_API_KEY');

if (!$apiKey) {
    echo "Error: YOUR_API_KEY not set in .env file\n";
    echo "Please fill in YOUR_API_KEY in .env first.\n";
    exit(1);
}

$client = OpenAI::client($apiKey);

echo "Sending request to OpenAI...\n\n";

$response = $client->responses()->create([
    'model' => 'gpt-4o-mini',
    'input' => "You are a helpful assistant. Write a short, polite email to my team explaining that the release date was moved to next Tuesday.",
]);

echo "Response:\n";
echo $response->outputText;
echo "\n\n";
