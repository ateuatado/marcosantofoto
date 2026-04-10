<?php
// Diagnóstico SMTP — rodar via: php /tmp/teste_smtp.php
// Apagar após uso!

define('FCPATH', __DIR__ . '/public/');
require __DIR__ . '/vendor/autoload.php';

// Lê o .env manualmente
$env = parse_ini_file(__DIR__ . '/.env', false, INI_SCANNER_RAW);

$host   = trim($env['email.SMTPHost']   ?? 'smtppro.zoho.com');
$port   = (int) trim($env['email.SMTPPort']   ?? 587);
$user   = trim($env['email.SMTPUser']   ?? '');
$pass   = trim(trim($env['email.SMTPPass']  ?? ''), '"\'');
$crypto = strtolower(trim($env['email.SMTPCrypto'] ?? 'tls'));

echo "=== Configuração lida do .env ===\n";
echo "Host:   $host\n";
echo "Port:   $port\n";
echo "User:   $user\n";
echo "Pass:   " . str_repeat('*', strlen($pass)) . " (" . strlen($pass) . " chars)\n";
echo "Crypto: $crypto\n\n";

echo "=== Teste de conexão TCP (porta $port) ===\n";
$conn = @fsockopen(($crypto === 'ssl' ? 'ssl://' : '') . $host, $port, $errno, $errstr, 5);
if ($conn) {
    echo "Conexão TCP: OK ✅\n\n";
    fclose($conn);
} else {
    echo "Conexão TCP: FALHOU ❌ ($errno: $errstr)\n";
    echo "Provável causa: VPS bloqueando saída na porta $port.\n\n";
}

echo "=== Teste PHPMailer ===\n";
$mail = new PHPMailer\PHPMailer\PHPMailer(true);
try {
    $mail->SMTPDebug   = 2;
    $mail->isSMTP();
    $mail->Host        = $host;
    $mail->SMTPAuth    = true;
    $mail->Username    = $user;
    $mail->Password    = $pass;
    $mail->Port        = $port;
    $mail->SMTPSecure  = ($crypto === 'ssl')
        ? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS
        : PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPOptions = ['ssl' => ['verify_peer' => false, 'allow_self_signed' => true]];
    $mail->CharSet     = 'UTF-8';
    $mail->isHTML(true);
    $mail->setFrom($user, 'Teste');
    $mail->addAddress($user);
    $mail->Subject = 'Teste SMTP - ' . date('H:i:s');
    $mail->Body    = '<p>Se chegou aqui, o SMTP funciona.</p>';
    $mail->send();
    echo "\n✅ E-mail enviado com sucesso!\n";
} catch (Exception $e) {
    echo "\n❌ Erro: " . $mail->ErrorInfo . "\n";
}
