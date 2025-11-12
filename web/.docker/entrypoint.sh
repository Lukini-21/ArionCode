#!/bin/sh
set -e
cd /app

if [ ! -f .env ]; then
  echo ".env not found. Copying from .env.example..."
  install -o node -g node -m 644 .env.example .env
fi

# ✅ Добавь установку зависимостей
if [ ! -d node_modules ]; then
  echo "Installing node dependencies..."
  npm ci || npm install
fi

exec "$@"