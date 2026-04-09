<?php
// Arquivo temporário de diagnóstico SMTP — REMOVER após confirmar funcionamento
// Acesse: /admin/testar_email

namespace App\Controllers;

class TesteEmail extends BaseController
{
    public function index()
    {
        if (! auth()->loggedIn() || ! auth()->user()->inGroup('superadmin')) {
            return redirect()->to('login');
        }

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

        echo '<pre style="background:#111;color:#fff;padding:20px;font-size:13px;">';
        echo "=== TESTE COM PHPMAILER ===\n\n";

        try {
            // Configurações do Servidor
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP();
            $mail->Host       = 'smtppro.zoho.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'marcosanto@marcosantofoto.com.br';
            $mail->Password   = 'curEYib00ffd'; // App Password
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS; // Implicit TLS
            $mail->Port       = 465;

            // Workaround para localhost/XAMPP
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Destinatários
            $mail->setFrom('marcosanto@marcosantofoto.com.br', 'FineArt Teste');
            $mail->addAddress('marcosantofoto@gmail.com');

            // Conteúdo
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = 'Teste SMTP Zoho c/ PHPMailer — FineArt';
            $mail->Body    = '<p>Se você está lendo isso, o SMTP via <b>PHPMailer</b> está funcionando na porta 465 SSL! ✅</p>';

            $mail->send();
            echo "\n-------------------------------------------------\n";
            echo "Sucesso: O email foi enviado corretamente! ✅\n";
            echo "Verifique a caixa de entrada de marcosantofoto@gmail.com\n";
            echo "-------------------------------------------------\n";

        } catch (\Exception $e) {
            echo "\n-------------------------------------------------\n";
            echo "Erro ao enviar: {$mail->ErrorInfo} ❌\n";
            echo "-------------------------------------------------\n";
        }

        echo '</pre>';
    }
}
