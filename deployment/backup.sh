#!/bin/bash
set -eo pipefail

BACKUP_DIR="/var/backups/postgresql/my_daily_life"
DATE=$(date +"%Y%m%d_%H%M%S")
FILENAME="mdl_backup_${DATE}.sql.gz"

mkdir -p "$BACKUP_DIR"

# Perform compressed dump
pg_dump -U mdl_prod_user -h 127.0.0.1 my_daily_life | gzip > "${BACKUP_DIR}/${FILENAME}"
chmod 600 "${BACKUP_DIR}/${FILENAME}"

# Delete backups older than 14 days
find "$BACKUP_DIR" -type f -name "mdl_backup_*.sql.gz" -mtime +14 -delete

echo "Backup created: ${FILENAME} at $(date)"
