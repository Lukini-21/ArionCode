#!/bin/sh
set -e

cd /app

if [ ! -f .env ]; then
    echo ".env not found. Copying from .env.example..."
    cp .env.example .env
    echo ".env file created from .env.example"
else
    echo ".env file already exists"
fi

exec "$@"