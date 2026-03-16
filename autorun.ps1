# autorun.ps1 - Sobe o ambiente 2easy EDE Web Sprint2 localmente (Docker + Laravel + front)
$ErrorActionPreference = "Stop"
$ProjectRoot = $PSScriptRoot
Set-Location $ProjectRoot

Write-Host "=== 2easy EDE Web Sprint2 - Autorun local ===" -ForegroundColor Cyan

# 1. .env
if (-not (Test-Path ".env")) {
    Write-Host "[1/8] Criando .env a partir de .env.example..." -ForegroundColor Yellow
    Copy-Item ".env.example" ".env"
} else {
    Write-Host "[1/8] .env ja existe." -ForegroundColor Green
}

$envPath = Join-Path $ProjectRoot ".env"
$envContent = Get-Content $envPath -Raw
$updated = $false
# DB_HOST para docker-compose-dev (servico mysql-ede-backend)
if (-not ($envContent -match 'DB_HOST=mysql-ede-backend')) {
    $envContent = $envContent -replace 'DB_HOST=\s*\S+', 'DB_HOST=mysql-ede-backend'
    $updated = $true
}
# APP_URL para porta 27002 (sprint2)
if (-not ($envContent -match 'APP_URL=http://localhost:27002')) {
    $envContent = $envContent -replace 'APP_URL=\s*\S+', 'APP_URL=http://localhost:27002'
    $updated = $true
}
# GATEWAY_* para gateway local (porta 27001)
if (-not ($envContent -match 'GATEWAY_BASEURL=\S')) {
    $envContent = $envContent -replace 'GATEWAY_BASEURL=\s*', "GATEWAY_BASEURL=http://host.docker.internal:27001/api/v1`n"
    $updated = $true
}
if (-not ($envContent -match 'GATEWAY_LOGIN=\S')) {
    $envContent = $envContent -replace 'GATEWAY_LOGIN=\s*', 'GATEWAY_LOGIN=agent@test.com.br'
    $updated = $true
}
if (-not ($envContent -match 'GATEWAY_PASSWORD=\S')) {
    $envContent = $envContent -replace 'GATEWAY_PASSWORD=\s*', 'GATEWAY_PASSWORD=123456'
    $updated = $true
}
if ($updated) {
    Set-Content $envPath -Value $envContent.TrimEnd() -NoNewline
    Write-Host "    .env ajustado (DB_HOST, APP_URL, GATEWAY_*)." -ForegroundColor Gray
}

# 2. Diretorios Laravel
Write-Host "[2/8] Criando diretorios storage e bootstrap/cache..." -ForegroundColor Yellow
@("storage\framework\sessions", "storage\framework\views", "storage\framework\cache", "storage\logs", "bootstrap\cache") | ForEach-Object {
    New-Item -ItemType Directory -Force -Path $_ | Out-Null
}

# 3. Docker
Write-Host "[3/8] Subindo containers (docker-compose-dev.yml)..." -ForegroundColor Yellow
docker-compose -f docker-compose-dev.yml up -d --build
if ($LASTEXITCODE -ne 0) { throw "Falha ao subir Docker." }

Write-Host "    Aguardando containers..." -ForegroundColor Gray
Start-Sleep -Seconds 10

# 4. Composer
Write-Host "[4/8] Instalando dependencias PHP (composer)..." -ForegroundColor Yellow
docker exec 2easy-ede-web-backend composer install --ignore-platform-reqs --no-interaction
if ($LASTEXITCODE -ne 0) { throw "Falha no composer install." }

# 5. APP_KEY
Write-Host "[5/8] Gerando APP_KEY se necessario..." -ForegroundColor Yellow
docker exec 2easy-ede-web-backend php artisan key:generate --force 2>$null

# 6. NPM + build
Write-Host "[6/8] Instalando dependencias e build do frontend (npm)..." -ForegroundColor Yellow
npm install --silent
npm run build
if ($LASTEXITCODE -ne 0) { throw "Falha no npm run build." }

# 7. Migrations
Write-Host "[7/8] Rodando migrations..." -ForegroundColor Yellow
Start-Sleep -Seconds 5
docker exec 2easy-ede-web-backend php artisan migrate --force
if ($LASTEXITCODE -ne 0) { Write-Host "    Aviso: migrate falhou. Rode depois: docker exec 2easy-ede-web-backend php artisan migrate" -ForegroundColor Yellow }

# 8. Pronto
Write-Host "[8/8] Pronto." -ForegroundColor Green
Write-Host ""
Write-Host "Aplicacao: http://localhost:27002" -ForegroundColor Cyan
Start-Process "http://localhost:27002"
