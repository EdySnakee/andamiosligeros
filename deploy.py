#!/usr/bin/env python3
"""
Script de despliegue FTP automatizado para Andamios Ligeros.
Sube cambios a producción dividiendo el código en:
  - Core Laravel -> andamiosmx/ (o REMOTE_CORE_DIR configurado)
  - Assets públicos -> public_html/ (o REMOTE_PUBLIC_DIR configurado)
"""

import os
import sys
import argparse
import subprocess
import ftplib
import ssl
from pathlib import Path

# Colores para la terminal
GREEN = "\033[92m"
YELLOW = "\033[93m"
RED = "\033[91m"
BLUE = "\033[94m"
CYAN = "\033[96m"
BOLD = "\033[1m"
RESET = "\033[0m"

CONFIG_FILE = ".deploy.env"
STATE_FILE = ".deploy_state"

IGNORED_PATTERNS = [
    ".git",
    ".github",
    ".env",
    ".deploy",
    "node_modules",
    "vendor",
    "composer.phar",
    "LocalValetDriver.php",
    ".DS_Store",
    "storage/framework",
    "storage/logs",
    "Homestead",
    ".valetphprc",
    "error_log",
    ".ftpquota",
    "andamios_app.sql",
    "*.sql",
    "*.zip",
    "*.mp4",
]


def load_config():
    """Carga configuración desde .deploy.env"""
    config = {
        "FTP_HOST": "",
        "FTP_USER": "",
        "FTP_PASS": "",
        "FTP_PORT": "21",
        "FTP_SSL": "false",
        "REMOTE_CORE_DIR": "andamiosmx",
        "REMOTE_PUBLIC_DIR": "public_html",
    }
    if not os.path.exists(CONFIG_FILE):
        return None

    with open(CONFIG_FILE, "r", encoding="utf-8") as f:
        for line in f:
            line = line.strip()
            if line and not line.startswith("#") and "=" in line:
                k, v = line.split("=", 1)
                config[k.strip()] = v.strip().strip('"').strip("'")
    return config


def create_default_config():
    """Crea la plantilla .deploy.env si no existe"""
    template = """# Configuración de despliegue FTP a producción para Andamios Ligeros
FTP_HOST=ftp.andamiosligeros.com
FTP_USER=usuario_cpanel
FTP_PASS=tu_contraseña
FTP_PORT=21
FTP_SSL=false

# Rutas en el servidor de hosting
REMOTE_CORE_DIR=andamiosmx
REMOTE_PUBLIC_DIR=public_html
"""
    with open(CONFIG_FILE, "w", encoding="utf-8") as f:
        f.write(template)
    print(f"{YELLOW}Se ha creado el archivo de configuración {BOLD}{CONFIG_FILE}{RESET}.")
    print(f"Por favor edítalo con tus credenciales FTP de cPanel antes de continuar.{RESET}")


def is_ignored(path_str):
    """Verifica si un archivo debe ser excluido del despliegue"""
    norm = path_str.replace("\\", "/")
    for pattern in IGNORED_PATTERNS:
        if pattern.startswith("*."):
            ext = pattern[1:]
            if norm.endswith(ext):
                return True
        elif pattern in norm.split("/") or norm.startswith(pattern):
            return True
    return False


def get_git_output(cmd):
    """Ejecuta un comando git y devuelve la salida limpia"""
    try:
        res = subprocess.run(cmd, shell=True, check=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE, text=True)
        return res.stdout.strip()
    except subprocess.CalledProcessError:
        return ""


def get_changed_files(base_commit=None, force_all=False):
    """Obtiene la lista de archivos modificados según Git"""
    current_commit = get_git_output("git rev-parse HEAD")
    
    if force_all or not base_commit:
        main_ref = "main"
        if not get_git_output("git rev-parse --verify main 2>/dev/null"):
            main_ref = "origin/main"
        
        # Si estamos en main y no hay base_commit previo, tomar los del último commit
        current_branch = get_git_output("git rev-parse --abbrev-ref HEAD")
        if current_branch == "main" and not force_all:
            files_raw = get_git_output("git diff-tree --no-commit-id --name-only -r HEAD")
        else:
            files_raw = get_git_output(f"git diff --name-only {main_ref}...HEAD")
    else:
        files_raw = get_git_output(f"git diff --name-only {base_commit} HEAD")

    # También incluir cambios locales no commiteados si existen
    uncommitted = get_git_output("git diff --name-only HEAD")
    staged = get_git_output("git diff --cached --name-only")
    
    all_files = set()
    for raw in [files_raw, uncommitted, staged]:
        for line in raw.split("\n"):
            line = line.strip()
            if line and os.path.exists(line) and not is_ignored(line):
                all_files.add(line)

    return sorted(list(all_files)), current_commit


def map_remote_path(local_path, core_dir, public_dir):
    """Calcula la ruta remota en el servidor según si es public/ o core"""
    norm = local_path.replace("\\", "/")
    if norm.startswith("public/"):
        rel = norm[len("public/"):]
        remote = f"{public_dir.rstrip('/')}/{rel}"
        category = "PUBLIC"
    else:
        remote = f"{core_dir.rstrip('/')}/{norm}"
        category = "CORE"
    return remote, category


def connect_ftp(config):
    """Establece conexión FTP con el servidor"""
    host = config["FTP_HOST"]
    port = int(config.get("FTP_PORT", 21))
    user = config["FTP_USER"]
    passwd = config["FTP_PASS"]
    use_ssl = config.get("FTP_SSL", "false").lower() in ("true", "1", "yes")

    print(f"{CYAN}Conectando a {host}:{port} ({'FTPS' if use_ssl else 'FTP'})...{RESET}")
    if use_ssl:
        ftp = ftplib.FTP_TLS()
        ftp.connect(host, port, timeout=30)
        ftp.login(user, passwd)
        ftp.prot_p()
    else:
        ftp = ftplib.FTP()
        ftp.connect(host, port, timeout=30)
        ftp.login(user, passwd)

    return ftp


def ensure_remote_dir(ftp, remote_dir_path):
    """Crea recursivamente los directorios remotos si no existen"""
    parts = [p for p in remote_dir_path.strip("/").split("/") if p]
    current = ""
    for part in parts:
        current += "/" + part
        try:
            ftp.cwd(current)
        except ftplib.error_perm:
            try:
                ftp.mkd(current)
                ftp.cwd(current)
            except ftplib.error_perm:
                pass
    ftp.cwd("/")


def upload_file(ftp, local_path, remote_path):
    """Sube un archivo individual por FTP"""
    remote_dir = os.path.dirname(remote_path)
    remote_filename = os.path.basename(remote_path)
    
    ensure_remote_dir(ftp, remote_dir)
    ftp.cwd("/" + remote_dir.lstrip("/"))
    
    with open(local_path, "rb") as f:
        ftp.storbinary(f"STOR {remote_filename}", f)


def test_connection(config):
    """Prueba la conexión FTP y verifica existencia de carpetas remotas"""
    try:
        ftp = connect_ftp(config)
        print(f"{GREEN}✓ Conexión FTP exitosa con el usuario '{config['FTP_USER']}'{RESET}")
        
        # Verificar core_dir
        core_dir = config["REMOTE_CORE_DIR"].strip("/")
        try:
            ftp.cwd("/" + core_dir)
            print(f"{GREEN}✓ Directorio Core encontrado: /{core_dir}{RESET}")
        except Exception as e:
            print(f"{YELLOW}⚠ Advertencia: No se pudo acceder a /{core_dir} ({e}). Se intentará crear al subir.{RESET}")

        # Verificar public_dir
        pub_dir = config["REMOTE_PUBLIC_DIR"].strip("/")
        try:
            ftp.cwd("/" + pub_dir)
            print(f"{GREEN}✓ Directorio Público encontrado: /{pub_dir}{RESET}")
        except Exception as e:
            print(f"{YELLOW}⚠ Advertencia: No se pudo acceder a /{pub_dir} ({e}). Se intentará crear al subir.{RESET}")

        ftp.quit()
        print(f"\n{BOLD}{GREEN}¡Todo listo para desplegar!{RESET}\n")
        return True
    except Exception as e:
        print(f"\n{RED}✗ Error al conectar con el servidor FTP:{RESET} {e}")
        if "530" in str(e):
            print(f"{YELLOW}Consejo: Revisa que el usuario y la contraseña en {CONFIG_FILE} sean correctos.{RESET}")
        return False


def main():
    parser = argparse.ArgumentParser(description="Despliegue FTP inteligente para Andamios Ligeros")
    parser.add_argument("--test", action="store_true", help="Probar conexión FTP con el servidor")
    parser.add_argument("--dry-run", action="store_true", help="Simular subida sin transferir archivos")
    parser.add_argument("--yes", "-y", action="store_true", help="Confirmar subida sin preguntar")
    parser.add_argument("--all-changed", action="store_true", help="Subir todos los cambios entre main y la rama actual")
    parser.add_argument("--files", nargs="+", help="Subir archivos específicos manualmente")
    args = parser.parse_args()

    config = load_config()
    if not config:
        create_default_config()
        sys.exit(1)

    if not config["FTP_HOST"] or config["FTP_USER"] in ("", "usuario_cpanel"):
        print(f"{RED}Configura las credenciales reales en {CONFIG_FILE} antes de continuar.{RESET}")
        sys.exit(1)

    if args.test:
        test_connection(config)
        return

    # Determinar qué archivos subir
    if args.files:
        files = [f for f in args.files if os.path.exists(f) and not is_ignored(f)]
        current_commit = get_git_output("git rev-parse HEAD")
    else:
        last_deployed = None
        if os.path.exists(STATE_FILE) and not args.all_changed:
            with open(STATE_FILE, "r") as f:
                last_deployed = f.read().strip()
        files, current_commit = get_changed_files(last_deployed, force_all=args.all_changed)

    if not files:
        print(f"{GREEN}✓ No hay cambios pendientes por subir. Todo está al día con el servidor.{RESET}")
        return

    print(f"\n{BOLD}{CYAN}=== ARCHIVOS PREPARADOS PARA DESPLIEGUE ==={RESET}")
    core_files = []
    public_files = []

    for f in files:
        remote, cat = map_remote_path(f, config["REMOTE_CORE_DIR"], config["REMOTE_PUBLIC_DIR"])
        if cat == "PUBLIC":
            public_files.append((f, remote))
        else:
            core_files.append((f, remote))

    if core_files:
        print(f"\n{BOLD}📁 Core Laravel -> {config['REMOTE_CORE_DIR']}/{RESET}")
        for loc, rem in core_files:
            print(f"  • {loc}  {CYAN}-> /{rem}{RESET}")

    if public_files:
        print(f"\n{BOLD}🌐 Archivos Públicos -> {config['REMOTE_PUBLIC_DIR']}/{RESET}")
        for loc, rem in public_files:
            print(f"  • {loc}  {CYAN}-> /{rem}{RESET}")

    total = len(files)
    print(f"\n{BOLD}Total de archivos a sincronizar:{RESET} {CYAN}{total}{RESET}")

    if args.dry_run:
        print(f"\n{YELLOW}[MODO SIMULACIÓN] No se subió ningún archivo.{RESET}\n")
        return

    if not args.yes:
        confirm = input(f"\n¿Deseas iniciar la subida al servidor? [{BOLD}S/n{RESET}]: ").strip().lower()
        if confirm not in ("", "s", "si", "y", "yes"):
            print(f"{YELLOW}Despliegue cancelado.{RESET}")
            return

    # Conectar y subir
    try:
        ftp = connect_ftp(config)
    except Exception as e:
        print(f"\n{RED}Error al conectar por FTP:{RESET} {e}")
        sys.exit(1)

    print(f"\n{BOLD}Iniciando transferencia...{RESET}")
    success_count = 0
    error_count = 0

    all_items = core_files + public_files
    for idx, (loc, rem) in enumerate(all_items, 1):
        try:
            upload_file(ftp, loc, rem)
            print(f"  [{idx}/{total}] {GREEN}✓ Subido:{RESET} {loc} {CYAN}-> /{rem}{RESET}")
            success_count += 1
        except Exception as e:
            print(f"  [{idx}/{total}] {RED}✗ Error en {loc}:{RESET} {e}")
            error_count += 1

    try:
        ftp.quit()
    except Exception:
        pass

    if error_count == 0:
        if current_commit:
            with open(STATE_FILE, "w") as f:
                f.write(current_commit)
        print(f"\n{BOLD}{GREEN}✓ ¡Despliegue completado exitosamente! ({success_count} archivos actualizados){RESET}\n")
    else:
        print(f"\n{YELLOW}Despliegue finalizado con advertencias: {success_count} subidos, {error_count} errores.{RESET}\n")


if __name__ == "__main__":
    main()
