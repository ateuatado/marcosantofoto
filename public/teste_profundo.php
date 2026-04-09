<?php
/**
 * Diagnóstico Profundo - Fineart System
 * Este script define as constantes de ambiente para evitar o erro FCPATH.
 */

// 1. Definir constantes vitais que o index.php normalmente definiria
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('ROOTPATH', realpath(FCPATH . '../') . DIRECTORY_SEPARATOR);

// 2. Carregar a configuração de caminhos
require_once ROOTPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();

// 3. Inicializar o Bootstrapper do CodeIgniter 4.5+
require_once $paths->systemDirectory . '/Boot.php';
CodeIgniter\Boot::bootWeb($paths);

echo "<html><body style='background:#000; color:#0f0; font-family:monospace; padding:30px;'>";
echo "<h1>🩻 Raio-X da Classe de Imagem (CI 4.5+)</h1>";

$imagePath = FCPATH . 'teste.jpg';

if (!file_exists($imagePath)) {
    die("❌ Ficheiro teste.jpg não encontrado em: " . $imagePath);
}

// 4. Instanciar o serviço de imagem
$imageService = \Config\Services::image();
$handler = $imageService->withFile($imagePath);

echo "<h2>1. Metadados Calculados (CodeIgniter)</h2>";
echo "<pre>";
print_r([
    'Handler'           => get_class($handler),
    'Largura Informada' => $handler->getWidth(),
    'Altura Informada'  => $handler->getHeight(),
    'Mime Type'         => $handler->getMime(),
]);
echo "</pre>";

echo "<h2>2. Explosão EXIF (Dados Brutos do Sensor)</h2>";
if (function_exists('exif_read_data')) {
    // Lendo com seções explodidas
    $exif = @exif_read_data($imagePath, 0, true);
    if ($exif) {
        echo "<pre>";
        print_r($exif);
        echo "</pre>";
    } else {
        echo "<p style='color:orange'>⚠️ O PHP não encontrou metadados EXIF neste arquivo.</p>";
    }
}

echo "<h2>3. Propriedades Internas da Classe</h2>";
$reflection = new \ReflectionClass($handler);
$props = $reflection->getProperties();
echo "<ul>";
foreach ($props as $prop) {
    $prop->setAccessible(true);
    $valor = $prop->getValue($handler);
    echo "<li><b>{$prop->getName()}:</b> " . (is_array($valor) || is_object($valor) ? json_encode($valor) : $valor) . "</li>";
}
echo "</ul>";

echo "</body></html>";