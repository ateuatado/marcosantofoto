<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<style>
  body { background: #000; color: #fff; font-family: Georgia, serif; margin: 0; padding: 40px 20px; }
  .container { max-width: 580px; margin: 0 auto; }
  .linha { width: 40px; height: 1px; background: #c8a96e; margin: 24px 0; }
  .label { font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: rgba(255,255,255,0.3); }
  .campo { margin-bottom: 16px; }
  .valor { color: rgba(255,255,255,0.7); font-size: 14px; line-height: 1.7; }
  .historia { border-left: 2px solid rgba(200,169,110,0.3); padding-left: 16px; font-style: italic; color: rgba(255,255,255,0.55); line-height: 1.8; }
  .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: rgba(255,255,255,0.25); }
</style>
</head>
<body style="margin: 0; padding: 0; background-color: #080808;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #080808; width: 100%;">
  <tr>
    <td align="center" style="padding: 40px 20px; background-color: #080808;">
      <div class="container" style="max-width: 580px; margin: 0 auto; text-align: left; font-family: Georgia, serif; color: #ffffff;">
  <div class="label">marcosantofoto.com.br · Nova Candidatura</div>
  <div class="linha"></div>
  <h1 style="font-size:22px; font-weight:normal; font-style:italic; margin:0 0 8px;">Nova submissão de perfil.</h1>
  <p style="color:rgba(255,255,255,0.4); font-size:13px; margin:0 0 32px;">Uma nova candidatura para o projeto marcosantofoto.com.br foi recebida e aguarda sua curadoria.</p>

  <div class="campo">
    <div class="label">Nome</div>
    <div class="valor"><?= esc($nome) ?></div>
  </div>
  <div class="campo">
    <div class="label">E-mail</div>
    <div class="valor"><?= esc($email) ?></div>
  </div>
  <?php if (!empty($telefone)): ?>
  <div class="campo">
    <div class="label">Telefone</div>
    <div class="valor"><?= esc($telefone) ?></div>
  </div>
  <?php endif; ?>
  <?php if (!empty($nascimento)): ?>
  <div class="campo">
    <div class="label">Nascimento</div>
    <div class="valor"><?= date('d/m/Y', strtotime($nascimento)) ?></div>
  </div>
  <?php endif; ?>
  <?php if (!empty($sexo)): ?>
  <div class="campo">
    <div class="label">Identidade</div>
    <div class="valor"><?= esc($sexo) ?></div>
  </div>
  <?php endif; ?>
  <?php if (!empty($redes_sociais)): ?>
  <div class="campo">
    <div class="label">Redes sociais</div>
    <div class="valor"><?= nl2br(esc($redes_sociais)) ?></div>
  </div>
  <?php endif; ?>
  <?php if (!empty($lattes)): ?>
  <div class="campo">
    <div class="label">Lattes</div>
    <div class="valor"><a href="<?= esc($lattes) ?>" style="color:#c8a96e;"><?= esc($lattes) ?></a></div>
  </div>
  <?php endif; ?>
  <?php if (!empty($historia)): ?>
  <div class="campo" style="margin-top:24px;">
    <div class="label" style="margin-bottom:10px;">História</div>
    <div class="historia"><?= nl2br(esc($historia)) ?></div>
  </div>
  <?php endif; ?>

  <div style="margin-top:32px;">
    <a href="<?= site_url('admin/candidaturas') ?>" 
       style="display:inline-block; padding:14px 32px; background:transparent; border:1px solid rgba(255,255,255,0.25); color:#fff; text-decoration:none; font-size:11px; letter-spacing:3px; text-transform:uppercase;">
      Ver no Painel →
    </a>
  </div>

  <div class="footer">
    Marco Santo · marcosantofoto.com.br<br>
    Esta mensagem foi gerada automaticamente ao receber uma nova candidatura.
  </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
