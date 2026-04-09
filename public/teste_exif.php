<?php
// Script de diagnóstico rápido
$caminho_foto = __DIR__ . '/writable/uploads/originals/ensaios/1771380343_ecf7a9f71840e5b99357.jpg';

echo "<h2>Diagnóstico de Imagem</h2>";

if (!function_exists('exif_read_data')) {
    die("<p style='color:red'>❌ Erro: Função exif_read_data não existe. Verifique o PHP-EXIF.</p>");
}

if (!file_exists($caminho_foto)) {
    die("<p style='color:orange'>⚠️ Aviso: Ficheiro não encontrado. Mude o nome da foto no script para uma que exista em originals/ensaios/.</p>");
}

$exif = @exif_read_data($caminho_foto);
echo "<p>✅ Extensão EXIF: Ativa</p>";
echo "<p>📸 Ficheiro: " . basename($caminho_foto) . "</p>";
echo "<p>🔄 Orientação EXIF detectada: " . ($exif['Orientation'] ?? 'Não encontrada') . "</p>";

if (isset($exif['Orientation'])) {
    echo "<p>💡 <b>Análise:</b> O valor 1 é normal. Valores 6 ou 8 indicam fotos verticais. Se for 6 ou 8 e a foto está deitada, o reorient() do CodeIgniter falhou ao girar os pixels.</p>";
}