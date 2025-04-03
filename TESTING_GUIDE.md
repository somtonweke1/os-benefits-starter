# OS BENEFiTS Starter Kit - Validation Protocol

## 1. Verify API Performance

```bash
# Uncached response (slow)
curl http://localhost:8000/api/benefits

# Cached response (fast)
curl -H "Authorization: Bearer [JWT_TOKEN]" http://localhost:8000/api/benefits
```

✅ **Expected**: Cached response completes in <800ms (40% faster)

## 2. Test Security Controls

```bash
# Attempt admin access with editor credentials
curl -H "Authorization: Bearer $EDITOR_TOKEN" http://localhost:8000/api/admin/stats
```

✅ **Expected**: 403 Forbidden error

## 3. Validate CMS Sync

1. Edit content in Directus (http://localhost:8055)
2. Check frontend (http://localhost:3000)

✅ **Expected**: Changes appear within 2 minutes

## Detailed Test Cases

### API Performance Testing

```bash
# Generate test load
ab -n 1000 -c 50 http://localhost:8000/api/benefits

# Expected Results:
# - First request: ~2200ms
# - Cached: ~800ms
# - 99th percentile: <1000ms
```

### Security Validation

```bash
# 1. Get editor token
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"email": "editor@example.com", "password": "password"}'

# 2. Test role boundaries
curl -H "Authorization: Bearer $EDITOR_TOKEN" \
  http://localhost:8000/api/admin/users

# 3. Verify rate limiting
for i in {1..100}; do
  curl http://localhost:8000/api/benefits
done
```

### CMS Integration Testing

1. **Content Update Test**
   ```bash
   # Monitor webhook endpoint
   curl -N http://localhost:8000/api/webhook-status
   ```

2. **Cache Invalidation Check**
   ```bash
   # Check cache status
   redis-cli get "benefits:cache"
   ```

## Automated Test Suite

Run the full test suite:

```bash
cd backend
composer test
```

This will execute:
- API performance tests
- Security validation
- CMS sync verification
- Integration tests

## Common Issues & Solutions

1. **Slow API Response**
   - Verify Redis is running
   - Check cache hit ratio
   - Monitor database queries

2. **Auth Failures**
   - Ensure JWT secret is set
   - Check token expiration
   - Verify role assignments

3. **CMS Sync Delays**
   - Check webhook connectivity
   - Verify queue worker status
   - Monitor sync logs 