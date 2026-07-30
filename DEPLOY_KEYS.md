Generar llaves SSH para GitHub Actions (ed25519)

Windows (PowerShell):

1) Generar par de llaves (sin passphrase):

```powershell
ssh-keygen -t ed25519 -C "github-actions-deploy" -f "$env:USERPROFILE\.ssh\id_deploy" -N ""
```

2) Ver el contenido de la llave privada (para pegar en el secret `SSH_PRIVATE_KEY`):

```powershell
Get-Content -Raw $env:USERPROFILE\.ssh\id_deploy
# O copiar al portapapeles
Get-Content -Raw $env:USERPROFILE\.ssh\id_deploy | Set-Clipboard
```

3) Ver el contenido de la llave pública (para instalar en el servidor):

```powershell
Get-Content $env:USERPROFILE\.ssh\id_deploy.pub
# O copiar al portapapeles
Get-Content $env:USERPROFILE\.ssh\id_deploy.pub | Set-Clipboard
```

Linux / macOS:

```bash
ssh-keygen -t ed25519 -C "github-actions-deploy" -f ~/.ssh/id_deploy -N ""
cat ~/.ssh/id_deploy
cat ~/.ssh/id_deploy.pub
```

Instalar la pública en el servidor (opciones):

- Si tienes `ssh-copy-id` (Linux/macOS):

```bash
ssh-copy-id -i ~/.ssh/id_deploy.pub ${DEPLOY_USER}@${DEPLOY_HOST}
```

- Método manual (funciona desde PowerShell, Linux o macOS):

```bash
# Reemplaza DEPLOY_USER y DEPLOY_HOST
type $env:USERPROFILE\.ssh\id_deploy.pub | ssh ${DEPLOY_USER}@${DEPLOY_HOST} "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys"
# En Linux/macOS usar `cat ~/.ssh/id_deploy.pub | ssh ...`
```

Añadir secret en GitHub (Repository → Settings → Secrets and variables → Actions → New repository secret):

- `SSH_PRIVATE_KEY`: pega TODO el contenido del archivo privado (`id_deploy`).
- `DEPLOY_HOST`: host o IP (ej. `mi-servidor.ejemplo.com`).
- `DEPLOY_USER`: usuario SSH (ej. `deploy`).
- `DEPLOY_DIR`: ruta absoluta al directorio de despliegue (ej. `/var/www/inventario-boutique`).

Verificación rápida:

```bash
# Probar acceso sin contraseña
ssh -i ~/.ssh/id_deploy ${DEPLOY_USER}@${DEPLOY_HOST} "echo OK && ls -la ${DEPLOY_DIR}"
```

Notas de seguridad:

- NO compartas la llave privada en canales inseguros.
- Guarda la llave privada en un lugar seguro; si se expone, revócala borrando la pública del `~/.ssh/authorized_keys` del servidor y genera un nuevo par.

Si quieres, puedo:
- Generar un pequeño script `generate_deploy_key.ps1` para Windows que automatice los pasos anteriores (no ejecuta nada, sólo crea el par con `ssh-keygen`).
- O crear instrucciones adaptadas a tu servidor si me dices sistema operativo y usuario.
