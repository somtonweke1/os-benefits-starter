#!/bin/bash

echo "🔍 Testing OS BENEFiTS Starter Kit Setup..."

# 1. Validate Docker Configuration
echo "\n1. Checking Docker Configuration..."
if docker-compose config > /dev/null; then
    echo "✅ Docker Compose configuration is valid"
else
    echo "❌ Docker Compose configuration error"
    exit 1
fi

# 2. Start Services
echo "\n2. Starting services..."
docker-compose up -d --build --force-recreate

# Wait for services to be ready
echo "Waiting for services to be healthy..."
sleep 30

# 3. Test Service Health
echo "\n3. Checking service health..."

# Test Laravel
if curl -s -I http://localhost:8000/api/health | grep "200 OK" > /dev/null; then
    echo "✅ Laravel API is healthy"
else
    echo "❌ Laravel API is not responding"
fi

# Test Nuxt
if curl -s -I http://localhost:3000 | grep "200 OK" > /dev/null; then
    echo "✅ Nuxt frontend is healthy"
else
    echo "❌ Nuxt frontend is not responding"
fi

# Test Directus
if curl -s -I http://localhost:8055 | grep "200 OK" > /dev/null; then
    echo "✅ Directus CMS is healthy"
else
    echo "❌ Directus CMS is not responding"
fi

# 4. Test API Performance
echo "\n4. Testing API Performance..."
start=$(date +%s%N)
curl -o /dev/null -s http://localhost:8000/api/benefits
end=$(date +%s%N)
response_time=$(($(($end - $start)) / 1000000))
echo "API Response Time: ${response_time}ms"
if [ $response_time -lt 800 ]; then
    echo "✅ API performance meets target (<800ms)"
else
    echo "❌ API performance needs optimization"
fi

# 5. Test CMS Sync
echo "\n5. Testing CMS Sync..."
sync_start=$(date +%s)
docker-compose exec -T directus npx directus schema apply ./schema.yaml
until docker-compose logs laravel | grep -q "ContentSynced"; do
    if [ $(($(date +%s) - sync_start)) -gt 120 ]; then
        echo "❌ CMS sync timeout"
        exit 1
    fi
    sleep 1
done
echo "✅ CMS sync successful (${$(($(date +%s) - sync_start))}s)"

echo "\n🎉 All tests completed!" 