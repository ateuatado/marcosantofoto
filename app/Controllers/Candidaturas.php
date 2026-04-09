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

        // Configurações Globais do PHPMailer para o Zoho Pro
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtppro.zoho.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'marcosanto@marcosantofoto.com.br';
            $mail->Password   = 'curEYib00ffd'; // App Password Zoho
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS; // Implicit TLS
            $mail->Port       = 465;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->CharSet = 'UTF-8';
            $mail->isHTML(true);

            // --- EMAIL 1: Notificação para o artista ---
            $corpoArtista = view('emails/candidatura_artista', $dados);
            $mail->setFrom('marcosanto@marcosantofoto.com.br', 'Marco Santo · marcosantofoto.com.br');
            $mail->addAddress('marcosantofoto@gmail.com');
            $mail->Subject = 'Nova submissão recebida: ' . $dados['nome'];
            $mail->Body    = $corpoArtista;
            $mail->send();

            // Reseta destinatários para o próximo envio
            $mail->clearAddresses();

            // --- EMAIL 2: Confirmação para o candidato ---
            $corpoConfirmacao = view('emails/candidatura_confirmacao', $dados);
            $mail->setFrom('marcosanto@marcosantofoto.com.br', 'Marco Santo');
            $mail->addAddress($dados['email']);
            $mail->Subject = 'Sua submissão ao projeto marcosantofoto.com.br';
            $mail->Body    = $corpoConfirmacao;
            $mail->send();

        } catch (\Exception $e) {
            log_message('error', 'Falha ao enviar e-mail de candidatura (PHPMailer): ' . $mail->ErrorInfo);
        }

        return redirect()->to('candidatura')
                         ->with('sucesso', 'Candidatura recebida. Obrigado pela coragem de se apresentar.');
    }
}
