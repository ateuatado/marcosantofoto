<?php
define('FCPATH', __DIR__ . '/public/');
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . '/bootstrap.php';

$imagePath = FCPATH . 'test_image.jpg'; // We don't have this, let's just make a stub

$image = \Config\Services::image();

// Let's create a red image using GD to test behavior, but it won't have EXIF.
// Actually, let's just look at the code of CodeIgniter 4's rotate method.
// I will output the source code of BaseHandler's rotate method to see if width/height are updated.
$code = file_get_contents(SYSTEMPATH . 'Images/Handlers/BaseHandler.php');
if (preg_match('/public function rotate.*?\{.*?\}/s', $code, $matches)) {
    echo $matches[0];
}
