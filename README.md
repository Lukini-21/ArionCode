## Arioncoder test api

#### Task includes only API without frontend (I had only 2 days for this task). Some features are not ready. App has scheduler and queue worker. Queue and cache drivers - Redis
## Current Status & Future Improvements

**Completed:**
- Core framework features implemented
- Business logic separated into service layer
- Basic functionality operational

**Pending Implementation:**
- Comprehensive test coverage
- Frontend development
- Detailed code documentation
- Dedicated cache management service
- Localization system
- Message template editor
- SSL certificate generation

**Technical Debt:**
- Requires additional code comments
- Missing unit/integration tests
- Frontend components incomplete
- Localization not implemented
- SSL configuration pending

### App start for local development (with xdebug)

docker compose -f docker-compose-local.yml up -d

When application run first time in database migrations and seeders will run
automatically.

### [Postman collection](ArionCoder.postman_collection.json)
### [Postman environment](Arion.postman_environment.json)
### [DB Diagram](diagram.drawio) (*https://app.diagrams.net/*)
### [Mocked User Credentials](api/config/demo.php)
#### When user is logged in used first organization from organization list. Switch organizations by */switch* route.
### WEB is available on http://localhost:5173 (local)
### API is available on http://localhost:8080 (local)