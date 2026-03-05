# Docker Deployment Guide

## Prerequisites
- Docker installed
- Docker Compose installed
- Git installed

## Quick Start

### 1. Clone Repository
```bash
git clone <your-repo-url>
cd unlimitedplug-sites
```

### 2. Environment Setup
```bash
cp .env.production .env
```

Edit `.env` and set:
- `APP_KEY` (generate with: `php artisan key:generate`)
- Database credentials
- Flutterwave API keys
- APP_URL to your domain

### 3. Build and Run
```bash
docker-compose up -d --build
```

### 4. Run Migrations
```bash
docker exec -it unlimitedplug-sites php artisan migrate --force
```

### 5. Generate App Key (if not set)
```bash
docker exec -it unlimitedplug-sites php artisan key:generate
```

### 6. Create Storage Link
```bash
docker exec -it unlimitedplug-sites php artisan storage:link
```

### 7. Optimize for Production
```bash
docker exec -it unlimitedplug-sites php artisan config:cache
docker exec -it unlimitedplug-sites php artisan route:cache
docker exec -it unlimitedplug-sites php artisan view:cache
```

## Access Application
- Application: http://localhost:8001
- MySQL: localhost:3307
- Redis: localhost:6380

## Useful Commands

### View Logs
```bash
docker-compose logs -f app
```

### Stop Containers
```bash
docker-compose down
```

### Restart Containers
```bash
docker-compose restart
```

### Access Container Shell
```bash
docker exec -it unlimitedplug-sites bash
```

### Clear Cache
```bash
docker exec -it unlimitedplug-sites php artisan cache:clear
docker exec -it unlimitedplug-sites php artisan config:clear
docker exec -it unlimitedplug-sites php artisan route:clear
docker exec -it unlimitedplug-sites php artisan view:clear
```

## Production Deployment (Coolify/VPS)

### Using Coolify
1. Connect your GitHub repository
2. Set environment variables in Coolify dashboard
3. Deploy using the Dockerfile
4. Run post-deployment commands:
   ```bash
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

### Manual VPS Deployment
1. Install Docker and Docker Compose on VPS
2. Clone repository
3. Set up `.env` file
4. Run `docker-compose up -d --build`
5. Configure nginx reverse proxy (if needed)
6. Set up SSL with Let's Encrypt

## Troubleshooting

### Permission Issues
```bash
docker exec -it unlimitedplug-sites chown -R www-data:www-data /var/www/storage
docker exec -it unlimitedplug-sites chmod -R 775 /var/www/storage
```

### Database Connection Issues
- Check DB_HOST is set to `db` (container name)
- Verify database credentials in `.env`
- Ensure database container is running: `docker ps`

### Port Conflicts
If port 8001 is in use, change in `docker-compose.yml`:
```yaml
ports:
  - "8002:80"  # Change 8001 to any available port
```
