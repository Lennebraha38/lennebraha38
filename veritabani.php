<?php
// Quantro — Health Check + Legacy API
// Supabase entegrasyonu sonrasi bu dosya sadece health-check amaciyla kullaniliyor.
// Tum veri islemleri dogrudan frontend -> Supabase uzerinden yapiliyor.

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

echo json_encode([
    'status'  => 'ok',
    'app'     => 'Quantro',
    'version' => '2.0.0',
    'backend' => 'Supabase (dogrudan baglanti)',
    'message' => 'Bu API artik kullanilmiyor. Frontend dogrudan Supabase JS SDK uzerinden calisiyor.'
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
