<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function aviso()
    {
        // Certifique-se de que o arquivo está em app/Views/pages/aviso.php
        return view('pages/aviso');
    }
}
