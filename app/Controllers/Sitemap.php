<?php

namespace App\Controllers;

use App\Models\EnsaioModel;

class Sitemap extends BaseController
{
    public function index()
    {
        $urls = [];

        // Static Public URLs
        $urls[] = [
            'loc' => base_url('/'),
            'priority' => '1.0',
            'changefreq' => 'weekly'
        ];

        $urls[] = [
            'loc' => base_url('login'),
            'priority' => '0.8',
            'changefreq' => 'monthly'
        ];

        $urls[] = [
            'loc' => base_url('register'),
            'priority' => '0.8',
            'changefreq' => 'monthly'
        ];

        // Ensaios Publicados (Note: Currently protected by auth, but listed for SEO structure if made public later)
        $ensaioModel = new EnsaioModel();
        $ensaiosPublicados = $ensaioModel->where('status', 'publicado')->findAll();

        foreach ($ensaiosPublicados as $ensaio) {
            $urls[] = [
                'loc' => base_url('ensaios/ver/' . $ensaio->slug),
                'priority' => '0.9',
                'changefreq' => 'monthly',
                'lastmod' => date('Y-m-d', strtotime($ensaio->updated_at ?? date('Y-m-d')))
            ];
        }

        // Render XML
        $this->response->setContentType('text/xml');
        return view('sitemap/index', ['urls' => $urls]);
    }
}
