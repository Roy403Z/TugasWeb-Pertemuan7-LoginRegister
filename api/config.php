<?php
$supabase_url = getenv('SUPABASE_URL') ?: $_ENV['SUPABASE_URL'] ?? '';
$supabase_key = getenv('SUPABASE_KEY') ?: $_ENV['SUPABASE_KEY'] ?? '';

define('SUPABASE_URL', $supabase_url);
define('SUPABASE_KEY', $supabase_key);

function supabase_request($endpoint, $method = 'GET', $data = null) {
    if (empty(SUPABASE_URL) || empty(SUPABASE_KEY)) {
        die('Error: Kredensial SUPABASE_URL atau SUPABASE_KEY belum dikonfigurasi di Environment Variables Vercel.');
    }

    $url = rtrim(SUPABASE_URL, '/') . '/rest/v1/' . $endpoint;
    $ch = curl_init($url);
    
    $headers = [
        'apikey: ' . SUPABASE_KEY,
        'Authorization: Bearer ' . SUPABASE_KEY,
        'Content-Type: application/json',
        'Prefer: return=representation'
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>