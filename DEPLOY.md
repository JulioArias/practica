Verificación y rollback del despliegue

Objetivo
- Comprobar que la aplicación funciona tras el despliegue automático y dar pasos para rollback si algo falla.

Antes de empezar
- Asegúrate de haber creado los secrets en GitHub: `SSH_PRIVATE_KEY`, `DEPLOY_HOST`, `DEPLOY_USER`, `DEPLOY_DIR`.
- Asegúrate de que `DEPLOY_USER` tiene permisos para `DEPLOY_DIR` y, si vas a reiniciar servicios, permisos `sudo` para `systemctl` o `supervisorctl`.

Pasos para probar después del deploy (presencial)
1) Revisar el pipeline en GitHub Actions
   - Repo → Actions → seleccionar el workflow run → confirmar que `test` y `deploy` pasaron.

2) Verificar versión y migraciones en servidor
```bash
ssh -i ~/.ssh/id_deploy DEPLOY_USER@DEPLOY_HOST "cd DEPLOY_DIR && php artisan --version && php artisan migrate:status"
```

3) Comprobar endpoints clave (desde navegador o curl)
```bash
curl -I https://tu-dominio/  # Busca HTTP/1.1 200 OK o 302 según config
curl -I https://tu-dominio/login
```

4) Crear/editar un registro de prueba via UI
- Accede a la app, crea una `Categoria` o `Producto` y verifica que aparece en la lista y persiste tras recargar.

5) Revisar logs
```bash
ssh -i ~/.ssh/id_deploy DEPLOY_USER@DEPLOY_HOST "tail -n 200 DEPLOY_DIR/storage/logs/laravel.log"
```
- Busca errores fatales, excepciones repetidas, o stack traces.

6) Verificar colas (si aplica)
```bash
ssh -i ~/.ssh/id_deploy DEPLOY_USER@DEPLOY_HOST "cd DEPLOY_DIR && php artisan queue:failed --quiet; php artisan queue:work --once"
```

Reinicio manual de servicios (si no se reiniciaron)
```bash
ssh -i ~/.ssh/id_deploy DEPLOY_USER@DEPLOY_HOST "sudo systemctl restart php8.2-fpm || sudo systemctl restart php8.1-fpm || sudo systemctl restart php-fpm"
ssh -i ~/.ssh/id_deploy DEPLOY_USER@DEPLOY_HOST "sudo systemctl restart supervisor || sudo supervisorctl restart all"
```

Plan de rollback rápido
1) Desde servidor vuelve a la versión anterior (si usas `rsync` sin snapshots, mantener releases es ideal). Si no tienes releases, restaura desde un backup o rollback del repo:
```bash
ssh -i ~/.ssh/id_deploy DEPLOY_USER@DEPLOY_HOST "cd DEPLOY_DIR && git fetch --all && git checkout <previous-tag-or-commit> && composer install --no-dev --optimize-autoloader && php artisan migrate:rollback --step=1 || true"
```
2) Reinicia servicios:
```bash
ssh -i ~/.ssh/id_deploy DEPLOY_USER@DEPLOY_HOST "sudo systemctl restart php-fpm || true"
```
3) Informar a los stakeholders y abrir incidencia con logs y pasos para reproducir.

Notas y recomendaciones
- Implementa strategy de releases (por ejemplo `deploy` dir con `releases/` timestamped and `current` symlink) para rollbacks rápidos.
- Considera usar `rsync` hacia un `releases/` y cambiar `current` symlink en el servidor.
- Otorga `sudo` sin contraseña sólo para los comandos necesarios si quieres que Actions reinicie servicios.

Si quieres, puedo:
- Añadir manejo de releases en el workflow (crear releases dir y cambiar `current` symlink).
- Añadir notificaciones a Slack/Email en caso de fallo de `deploy`.
