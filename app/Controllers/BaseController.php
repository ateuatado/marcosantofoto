<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    /**
     * Cria e configura uma instância do PHPMailer lendo as credenciais do .env.
     *
     * Uso:
     *   $mail = $this->criarMailer();
     *   $mail->addAddress($destinatario);
     *   $mail->Subject = '...';
     *   $mail->Body    = '...';
     *   $mail->send();
     *
     * @return \PHPMailer\PHPMailer\PHPMailer
     */
    protected function criarMailer(): \PHPMailer\PHPMailer\PHPMailer
    {
        // Usa o Config\Email que o CI4 popula automaticamente a partir do .env
        // Mais confiável do que chamar env() diretamente em todos os ambientes
        $cfg = config('Email');

        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host     = $cfg->SMTPHost    ?: 'smtppro.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = $cfg->SMTPUser    ?: '';
        $mail->Password = $cfg->SMTPPass    ?: '';
        $mail->Port     = (int) ($cfg->SMTPPort ?: 587);

        $crypto = strtolower((string) ($cfg->SMTPCrypto ?: 'tls'));
        $mail->SMTPSecure = ($crypto === 'ssl')
            ? \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS
            : \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->setFrom(
            $cfg->fromEmail ?: $cfg->SMTPUser,
            $cfg->fromName  ?: 'Marco Santo'
        );

        return $mail;
    }
}

