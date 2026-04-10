<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CandidaturaModel;

class Candidaturas extends BaseController
{
    /**
     * Página editorial da candidatura + formulário
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string
     */
    public function index()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('login');
        }

        return view('pages/candidatura');
    }

    /**
     * Processa e salva a candidatura enviada
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function enviar()
    {
        if (! auth()->loggedIn()) {
            return redirect()->to('login');
        }

        $rules = [
            'nome'     => 'required|min_length[3]|max_length[200]',
            'email'    => 'required|valid_email|max_length[254]',
            'telefone' => 'permit_empty|max_length[30]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('erros', $this->validator->getErrors());
        }

        $dados = [
            'nome'          => $this->request->getPost('nome'),
            'email'         => $this->request->getPost('email'),
            'telefone'      => $this->request->getPost('telefone'),
            'nascimento'    => $this->request->getPost('nascimento') ?: null,
            'sexo'          => $this->request->getPost('sexo'),
            'redes_sociais' => $this->request->getPost('redes_sociais'),
            'lattes'        => $this->request->getPost('lattes'),
            'historia'      => $this->request->getPost('historia'),
            'status'        => 'pendente',
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        $model = new CandidaturaModel();
        $model->insert($dados);

        try {
            $mail = $this->criarMailer();

            // --- EMAIL 1: Notificação para o artista ---
            $mail->addAddress('marcosantofoto@gmail.com');
            $mail->Subject = 'Nova submissão recebida: ' . $dados['nome'];
            $mail->Body    = view('emails/candidatura_artista', $dados);
            $mail->send();

            // Reseta destinatários para o próximo envio
            $mail->clearAddresses();

            // --- EMAIL 2: Confirmação para o candidato ---
            $mail->addAddress($dados['email']);
            $mail->Subject = 'Sua submissão ao projeto marcosantofoto.com.br';
            $mail->Body    = view('emails/candidatura_confirmacao', $dados);
            $mail->send();

        } catch (\Exception $e) {
            log_message('error', 'Falha ao enviar e-mail de candidatura (PHPMailer): ' . $e->getMessage());
        }

        return redirect()->to('candidatura')
                         ->with('sucesso', 'Candidatura recebida. Obrigado pela coragem de se apresentar.');
    }
}
