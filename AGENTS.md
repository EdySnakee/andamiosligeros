# Guía y Reglas del Proyecto Andamios Ligeros

## Entorno Local
- **PHP:** 7.4.33 ejecutado con Laravel Valet (`.valetphprc` con `php@7.4`).
- **Base de Datos:** MySQL local base `andamios_app` (usuario `root`, sin contraseña).
- **Dominio local:** `http://andamiosligeros.test`.

## Flujo de Git y Ramas
- La rama de trabajo habitual es **`dev`**.
- La rama de producción es **`main`**.
- Repositorio remoto: `https://github.com/EdySnakee/andamiosligeros.git`.

## Protocolo de Despliegue a Producción ("Sube a prod")
Siempre que el usuario solicite subir o desplegar a producción:
1. Asegurar que los cambios en **`dev`** estén commiteados y limpios.
2. Sincronizar **`dev`** a **`main`**:
   ```bash
   git checkout main && git merge dev
   ```
3. Subir ambas ramas a GitHub:
   ```bash
   git push origin main && git push origin dev
   ```
4. Ejecutar el script de despliegue FTP:
   ```bash
   ./deploy.sh --yes
   ```
5. Regresar a la rama **`dev`**:
   ```bash
   git checkout dev
   ```

## Protocolo para "Sube a dev"
Siempre que el usuario solicite subir a dev:
1. Asegurar que los cambios en **`dev`** estén commiteados y limpios.
2. Subir únicamente a la rama remota de desarrollo en GitHub:
   ```bash
   git push origin dev
   ```
3. Mantenerse en **`dev`** sin tocar **`main`** ni ejecutar el script de despliegue FTP a producción.

## Seguridad y Credenciales
- Las credenciales FTP residen únicamente en `.deploy.env` (ignorado en `.gitignore`). Nunca incluir contraseñas reales en `.deploy.env.example`.
- Evitar credenciales o tokens en código fuente rastreado (usar `env(...)`).
