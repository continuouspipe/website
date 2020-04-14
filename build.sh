#!/bin/bash
set -e
# docker run --rm -v "$(pwd):/app" node:6 bash -c "cd /app; npm install; ./node_modules/.bin/gulp sass"
rsync -avph --delete --exclude /sass/ --exclude /vendor/ --exclude '*.sketch' --exclude '*.php' web/ docs/
docker-compose -f docker-compose.yml build --pull
docker-compose -f docker-compose.yml up -d
sleep 10
curl -f -H "X-Forwarded-Proto: https" http://localhost:90 -o docs/index.html
mkdir -p docs/features/
curl -f -H "X-Forwarded-Proto: https" http://localhost:90/features/developers -o docs/features/index.html
curl -f -H "X-Forwarded-Proto: https" http://localhost:90/features/developers -o docs/features/developers.html
curl -f -H "X-Forwarded-Proto: https" http://localhost:90/features/ops -o docs/features/ops.html
curl -f -H "X-Forwarded-Proto: https" http://localhost:90/features/business -o docs/features/business.html
curl -H "X-Forwarded-Proto: https" http://localhost:90/404 -o docs/404.html
