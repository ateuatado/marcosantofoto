<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
</head>
<body style="margin: 0; padding: 0; background-color: #080808;">
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #080808; width: 100%;">
  <tr>
    <td align="center" style="padding: 40px 20px; background-color: #080808;">
      <div class="container" style="max-width: 580px; margin: 0 auto; text-align: left; font-family: Georgia, serif; color: #ffffff;">
        <div class="label" style="font-size: 10px; letter-spacing: 4px; text-transform: uppercase; color: rgba(255,255,255,0.3);">marcosantofoto.com.br</div>
        <div class="linha" style="width: 40px; height: 1px; background: #c8a96e; margin: 24px 0;"></div>

        <h1 style="font-size:20px; font-weight:normal; font-style:italic; margin:0 0 8px; color:#c8a96e;">
          Prezado(a) <?= esc($nome) ?>,
        </h1>
        <p style="color:rgba(255,255,255,0.7); font-size:14px; line-height:1.9; margin: 16px 0 24px;">
          Agradeço sinceramente sua candidatura para o projeto.
        </p>

        <p style="color:rgba(255,255,255,0.5); font-size:13px; line-height:1.9; margin-bottom: 24px;">
          Após analisar cuidadosamente o seu perfil e sua história, concluí que, neste momento específico, minha curadoria e direção de pesquisa estão trilhando caminhos distintos, impossibilitando que eu dê andamento ao projeto fotográfico proposto.
        </p>

        <p style="color:rgba(255,255,255,0.5); font-size:13px; line-height:1.9; margin-bottom: 32px;">
          Esta não é uma avaliação de mérito sobre você; cada obra nasce a partir de convergências pontuais e do momento atual da minha pesquisa visual. Fico profundamente honrado pela sua disposição em se abrir para este processo.
        </p>

        <div style="margin-top:32px;">
          <a href="<?= site_url('ensaios') ?>" 
             style="display:inline-block; padding:12px 24px; background:transparent; border:1px solid rgba(255,255,255,0.2); color:rgba(255,255,255,0.5); text-decoration:none; font-size:10px; letter-spacing:2px; text-transform:uppercase;">
            Ver Portfólio →
          </a>
        </div>

        <div class="footer" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.08); font-size: 11px; color: rgba(255,255,255,0.25);">
          Marco Santo · marcosantofoto.com.br<br>
          Desejo-lhe todo o sucesso em sua jornada.
        </div>
      </div>
    </td>
  </tr>
</table>
</body>
</html>
