#!/usr/bin/env sh
set -eu

BASE_DIR="$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)"
MYSQL_BASE="/var/tmp/clothing-web-mysql"
DATA_DIR="$MYSQL_BASE/data"
SOCKET="$MYSQL_BASE/mysql.sock"
PID_FILE="$MYSQL_BASE/mysql.pid"
LOG_FILE="$MYSQL_BASE/mysql.log"
INIT_LOG="$MYSQL_BASE/init.log"

HOST="${DB_HOST:-127.0.0.1}"
PORT="${DB_PORT:-3307}"
USER="${DB_USER:-root}"

mkdir -p "$MYSQL_BASE"

if [ ! -d "$DATA_DIR/mysql" ]; then
  echo "Initializing dedicated MySQL data directory..."
  rm -rf "$DATA_DIR"
  mysqld --no-defaults --initialize-insecure --datadir="$DATA_DIR" >"$INIT_LOG" 2>&1
fi

if [ -f "$PID_FILE" ]; then
  PID="$(cat "$PID_FILE" 2>/dev/null || true)"
  if [ -n "${PID:-}" ] && kill -0 "$PID" 2>/dev/null; then
    echo "MySQL is already running on $HOST:$PORT"
    echo "Data directory: $DATA_DIR"
    echo "Socket: $SOCKET"
    exit 0
  fi
  rm -f "$PID_FILE"
fi

echo "Starting dedicated MySQL on $HOST:$PORT ..."
mysqld \
  --no-defaults \
  --datadir="$DATA_DIR" \
  --socket="$SOCKET" \
  --pid-file="$PID_FILE" \
  --log-error="$LOG_FILE" \
  --port="$PORT" \
  --bind-address="$HOST" \
  --mysqlx=0 \
  --daemonize

for _ in 1 2 3 4 5 6 7 8 9 10; do
  if mysqladmin -h "$HOST" -P "$PORT" -u "$USER" ping >/dev/null 2>&1; then
    echo "Dedicated MySQL is ready."
    echo "Host: $HOST"
    echo "Port: $PORT"
    echo "User: $USER"
    echo "Password: (empty)"
    echo "Data directory: $DATA_DIR"
    exit 0
  fi
  sleep 1
done

echo "MySQL did not become ready in time."
echo "Check log: $LOG_FILE"
exit 1
