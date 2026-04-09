<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('ROOTPATH', realpath(FCPATH . '../') . DIRECTORY_SEPARATOR);

// Tenta localizar o WRITEPATH manualmente
$writePath = ROOTPATH . 'writable/';
$pastaDestino = $writePath . 'uploads/originals/ensaios/';

echo "<html><body style='background:#111; color:#0f0; font-family:monospace; padding:30px;'>";
echo "<h1>🕵️ Diagnóstico de Identidade e Escrita</h1>";

// 1. Quem é o PHP?
echo "<h3>1. Identidade do Processo:</h3>";
echo "Usuário que executa o PHP: <b>" . exec('whoami') . "</b><br>";
echo "ID do Usuário (UID): " . getmyuid() . "<br>";

// 2. Caminhos
echo "<h3>2. Verificação de Caminhos:</h3>";
echo "Raiz do Site (ROOTPATH): <code>" . ROOTPATH . "</code><br>";
echo "Pasta Destino Alvo: <code>" . $pastaDestino . "</code><br>";

if (is_dir($pastaDestino)) {
    echo "✅ A pasta existe fisicamente.<br>";
    echo "Permissões da pasta: " . substr(sprintf('%o', fileperms($pastaDestino)), -4) . "<br>";
} else {
    echo "❌ A pasta NÃO existe. Tentando criar...<br>";
    if (mkdir($pastaDestino, 0775, true)) {
        echo "✅ Pasta criada com sucesso via PHP!<br>";
    } else {
        echo "❌ Falha ao criar pasta. Problema de permissão na pasta pai.<br>";
    }
}

// 3. Teste de Escrita Real
echo "<h3>3. Teste de Escrita:</h3>";
$arquivoTeste = $pastaDestino . 'teste_escrita.txt';
if (@file_put_contents($arquivoTeste, "Teste de escrita em: " . date('Y-m-d H:i:s'))) {
    echo "<b style='color:white; background:green; padding:5px;'>✅ SUCESSO! O PHP conseguiu escrever o arquivo.</b><br>";
    unlink($arquivoTeste); // Limpa o teste
} else {
    echo "<b style='color:white; background:red; padding:5px;'>❌ FALHA TOTAL! O PHP não tem permissão de escrita nessa pasta.</b><br>";
}

// 4. Limites do PHP
echo "<h3>4. Limites de Upload (php.ini):</h3>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";

echo "</body></html>";