tar -czf update.tar.gz app public system
if ($LASTEXITCODE -eq 0) {
    Write-Host "Enviando arquivo para a pasta raiz (~) temporalmente..."
    scp update.tar.gz marcosantofoto@204.13.232.238:~/
    if ($LASTEXITCODE -eq 0) {
        Write-Host "Conectando via SSH para extrair os arquivos e rodar as Migrations..."
        ssh marcosantofoto@204.13.232.238 "tar -xzf ~/update.tar.gz -C ~/htdocs/www.marcosantofoto.com.br/ && cd ~/htdocs/www.marcosantofoto.com.br/ && php spark migrate && rm ~/update.tar.gz"
    }
}
