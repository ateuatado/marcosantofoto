<?php
// 1. Carregar o Bootstrap do CodeIgniter para usar as classes oficiais
require_once __DIR__ . '/../app/Config/Paths.php';
$paths = new Config\Paths();
require_once $paths->systemDirectory . '/bootstrap.php';

echo "<html><body style='background:#000; color:#0f0; font-family:monospace; padding:30px;'>";
echo "<h1>🩻 Raio-X da Classe de Imagem (GDHandler)</h1>";

$imagePath = __DIR__ . '/teste.jpg';

if (!file_exists($imagePath)) {
    die("❌ Ficheiro teste.jpg não encontrado na pasta public.");
}

// 2. Instanciar o serviço de imagem exatamente como o Admin.php faz
$imageService = \Config\Services::image();
$handler = $imageService->withFile($imagePath);

echo "<h2>1. Propriedades do Objeto 'Image' (O que a classe calculou)</h2>";
// A classe Image extrai informações básicas logo no carregamento
$info = [
    'Caminho Real'    => $handler->getPathname(),
    'Largura (px)'    => $handler->getWidth(),
    'Altura (px)'     => $handler->getHeight(),
    'Tipo de Mime'    => $handler->getMime(),
    'Tamanho Arquivo' => filesize($imagePath) . ' bytes'
];
echo "<pre>"; print_r($info); echo "</pre>";

echo "<h2>2. Array Completo de Metadados (EXIF Raw)</h2>";
// Aqui 'explodimos' todos os arrays de metadados que o PHP consegue ler
if (function_exists('exif_read_data')) {
    $exif = @exif_read_data($imagePath);
    if ($exif) {
        echo "<pre>"; print_r($exif); echo "</pre>";
    } else {
        echo "<p style='color:orange'>⚠️ Nenhum metadado EXIF encontrado neste arquivo.</p>";
    }
}

echo "<h2>3. Estado Interno do Handler (Configurações Atuais)</h2>";
// Vamos ver como a classe GDHandler está configurada internamente
// Usamos Reflection para ver propriedades protegidas se necessário, 
// mas aqui pegamos o que é público ou via métodos.
$config = [
    'Handler Ativo'    => get_class($handler),
    'Qualidade Padrão' => \Config\Services::image()->getProperties()['quality'] ?? 'Não definida'
];
echo "<pre>"; print_r($config); echo "</pre>";

echo "<h2>4. Simulação de Reorientação</h2>";
// Verificamos se o parâmetro Orientation está presente para a tese da rotação
if (isset($exif['Orientation'])) {
    $orient = $exif['Orientation'];
    echo "<p>🔎 Valor de Orientação Detectado: <b>$orient</b></p>";
    
    if ($orient == 6 || $orient == 8) {
        echo "<p style='color:yellow'>⚡ TESE CONFIRMADA: A imagem é vertical por software, mas horizontal por pixels.</p>";
    }
}

echo "</body></html>";