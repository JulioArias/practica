# generate_deploy_key.ps1
# Genera un par de llaves ed25519 para GitHub Actions y copia las llaves al portapapeles.
# Uso: Ejecutar en PowerShell (abrir PowerShell como usuario):
#   powershell -ExecutionPolicy Bypass -File .\generate_deploy_key.ps1

$sshDir = Join-Path $env:USERPROFILE ".ssh"
$privateKey = Join-Path $sshDir "id_deploy"
$publicKey = "$privateKey.pub"

function Abort([string]$msg){ Write-Host $msg -ForegroundColor Red; exit 1 }

if (-not (Get-Command ssh-keygen -ErrorAction SilentlyContinue)){
    Write-Host "No se encontró 'ssh-keygen' en el PATH. Instala OpenSSH Client o usa WSL." -ForegroundColor Yellow
    Write-Host "En Windows 10/11: Settings → Apps → Optional Features → OpenSSH Client" -ForegroundColor Yellow
    Pause
    exit 1
}

if (-not (Test-Path $sshDir)){
    New-Item -ItemType Directory -Path $sshDir | Out-Null
    Write-Host "Creado directorio: $sshDir"
}

if (Test-Path $privateKey){
    $ans = Read-Host "La llave ya existe en $privateKey. Sobrescribir? (y/N)"
    if ($ans -ne 'y' -and $ans -ne 'Y'){
        Write-Host "Operación cancelada. Si quieres conservar la llave existente, usa esa." -ForegroundColor Yellow
        exit 0
    }
}

# Generar la llave ed25519 sin passphrase (Start-Process para evitar problemas de parsing)
# Construir comando y ejecutarlo con cmd.exe para evitar problemas de parsing
$cmd = "ssh-keygen -t ed25519 -C `"github-actions-deploy`" -f `"$privateKey`" -N `"`""
$proc = Start-Process -FilePath "cmd.exe" -ArgumentList '/c', $cmd -NoNewWindow -Wait -PassThru
if ($proc.ExitCode -ne 0){ Abort "ssh-keygen falló con código $($proc.ExitCode)" }

# Leer contenidos
$priv = Get-Content -Raw -ErrorAction Stop $privateKey
$pub = Get-Content -Raw -ErrorAction Stop $publicKey

# Copiar privada al portapapeles (para pegar en GitHub Secrets)
try{
    $priv | Set-Clipboard
    Write-Host "Contenido de la llave privada copiado al portapapeles. (Pega en GitHub secret: SSH_PRIVATE_KEY)" -ForegroundColor Green
} catch {
    Write-Host "No se pudo copiar al portapapeles automáticamente. Encontrarás la llave en: $privateKey" -ForegroundColor Yellow
}

# Mostrar rutas y ejemplo corto
Write-Host "\nRuta privada: $privateKey" -ForegroundColor Cyan
Write-Host "Ruta pública:  $publicKey" -ForegroundColor Cyan
Write-Host "\nContenido (pública):\n" -NoNewline
Write-Host $pub -ForegroundColor White

Write-Host "\nSiguientes pasos:" -ForegroundColor Green
Write-Host "1) En GitHub → Repo → Settings → Secrets and variables → Actions → New repository secret" -ForegroundColor White
Write-Host "   - Nombre: SSH_PRIVATE_KEY" -ForegroundColor White
Write-Host "   - Valor: pega el contenido de la llave privada (ya copiado al portapapeles si la copia funcionó)." -ForegroundColor White
Write-Host "2) Instala la llave pública en el servidor remoto (en DEPLOY_USER@DEPLOY_HOST):" -ForegroundColor White
Write-Host "   - Usa ssh-copy-id si está disponible: ssh-copy-id -i $publicKey DEPLOY_USER@DEPLOY_HOST" -ForegroundColor White
Write-Host "   - O manualmente: cat $publicKey | ssh DEPLOY_USER@DEPLOY_HOST 'mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys'" -ForegroundColor White
Write-Host "3) Crea los otros secrets en GitHub: DEPLOY_HOST, DEPLOY_USER, DEPLOY_DIR" -ForegroundColor White

Write-Host "\nVerificación local rápida:" -ForegroundColor Green
Write-Host "ssh -i $privateKey DEPLOY_USER@DEPLOY_HOST 'echo OK && ls -la DEPLOY_DIR'" -ForegroundColor White

Write-Host "\nListo." -ForegroundColor Green
