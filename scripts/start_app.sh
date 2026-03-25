#!/usr/bin/env sh
set -eu

APP_DIR="$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)"
HOST="${APP_HOST:-127.0.0.1}"
PORT="${APP_PORT:-8000}"

export DB_HOST="${DB_HOST:-127.0.0.1}"
export DB_PORT="${DB_PORT:-3307}"
export DB_NAME="${DB_NAME:-login_db}"
export DB_USER="${DB_USER:-root}"
export DB_PASSWORD="${DB_PASSWORD:-}"

echo "Starting PHP app..."
echo "App URL: http://$HOST:$PORT"
echo "Database: ${DB_USER}@${DB_HOST}:${DB_PORT}/${DB_NAME}"

cd "$APP_DIR"
exec php -S "$HOST:$PORT" -t .
