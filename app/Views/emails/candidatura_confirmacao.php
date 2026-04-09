<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<style>
  body { background: #000; color: #fff; font-family: Georgia, serif; margin: 0; padding: 40px 20px; }
  .container { max-width: 580px; margin: 0 auto; }
  .linha { width: 40px; height: 1px; background: #c8a96e; margin: 24px 0; }
  .label { font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: rgba(255,255,255,0.3); }
  .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: rgba(255,255,255,0.25); }
</style>
</head>
<body style="margin: 0; padding: 0; background-color: #080808;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #080808; width: 100%;">
  <tr>
    <td align="center" style="padding: 40px 20px; background-color: #080808;">
      <div class="container" style="max-width: 580px; margin: 0 auto; text-align: left; font-family: Georgia, serif; color: #ffffff;">
  <div class="label">marcosantofoto.com.br</div>
  <div class="linha"></div>

  <h1 style="font-size:20px; font-weight:normal; font-style:italic; margin:0 0 8px; color:#c8a96e;">
    <?= esc($nome) ?>,
  </h1>
  <p style="color:rgba(255,255,255,0.7); font-size:14px; line-height:1.9; margin: 16px 0 24px;">
    Sua proposta de candidatura para o projeto de Marco Santo foi registrada com sucesso.
  </p>

  <p style="color:rgba(255,255,255,0.5); font-size:13px; line-height:1.9; margin-bottom: 24px;">
    Agradecemos a disposição em compartilhar sua história e o interesse em participar desta investigação artística. 
    A fotografia <i>fine art</i> exige uma conexão profunda com o tema retratado, e é por isso que cada submissão é lida e avaliada com imenso respeito.
  </p>

  <p style="color:rgba(255,255,255,0.5); font-size:13px; line-height:1.9; margin-bottom: 32px;">
    Devido à natureza orgânica e não-comercial do projeto, o processo de curadoria é rigoroso e limitado.
    Entraremos em contato exclusivamente caso sua trajetória esteja alinhada com as pesquisas e ensaios atualmente em desenvolvimento.
  </p>

  <div style="margin-top:32px;">
    <a href="<?= site_url('metodo') ?>" 
       style="display:inline-block; padding:12px 24px; background:transparent; border:1px solid rgba(255,255,255,0.2); color:rgba(255,255,255,0.5); text-decoration:none; font-size:10px; letter-spacing:2px; text-transform:uppercase;">
      Conheça o Método →
    </a>
  </div>

  <div class="footer">
    Marco Santo · marcosantofoto.com.br<br>
    marcosanto@marcosantofoto.com.br
  </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
