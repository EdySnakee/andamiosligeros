#!/bin/bash
# Wrapper ejecutable para el despliegue FTP de Andamios Ligeros
python3 "$(dirname "$0")/deploy.py" "$@"
