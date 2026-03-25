#!/usr/bin/env sh
set -eu

BASE_DIR="$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)"
DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3307}"
DB_NAME="${DB_NAME:-login_db}"
DB_USER="${DB_USER:-root}"
DB_PASSWORD="${DB_PASSWORD:-}"
SCHEMA_FILE="$BASE_DIR/database/schema.sql"

if [ ! -f "$SCHEMA_FILE" ]; then
  echo "Schema file not found: $SCHEMA_FILE" >&2
  exit 1
fi

echo "Importing schema into MySQL..."
echo "Host: $DB_HOST"
echo "Port: $DB_PORT"
echo "Database: $DB_NAME"
echo "User: $DB_USER"

if [ -n "$DB_PASSWORD" ]; then
  MYSQL_PWD="$DB_PASSWORD" mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" < "$SCHEMA_FILE"
else
  mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" < "$SCHEMA_FILE"
fi

echo "Database setup complete."
echo "You can verify with:"
echo "mysql -h $DB_HOST -P $DB_PORT -u $DB_USER -e \"USE $DB_NAME; SHOW TABLES;\""
