## Arioncoder test api

#### Task includes API and a part of frontend. Some features are not ready. App has scheduler and queue worker. Queue and cache drivers - Redis
## Current Status & Future Improvements

**Completed:**
- Core framework features implemented
- Business logic separated into service layer
- Basic functionality operational
- Socket connection backend + frontend for notifications
- Queue and worker services for events and notifications
- Data cache with Redis
- Async entity change logging
- Role policies to control access

**Pending Implementation:**
- Comprehensive test coverage
- Full frontend development
- Detailed code documentation
- Dedicated cache management service
- Localization system
- Message template editor
- SSL certificate generation for production server

**Technical Debt:**
- SCRF token check
- Requires additional code comments
- Missing unit/integration tests
- Frontend components incomplete
- Localization not implemented
- Implement socket messaging

**To improve:**
- Create advanced caching system to cache each user data separately
- Make Auth Service for working with users from 3rd party systems
- Make terraform configs for production deployment

### App start for local development (with xdebug)

docker compose -f docker-compose-local.yml up -d

When application run first time in database migrations and seeders will run
automatically.

### [Postman collection](ArionCoder.postman_collection.json)
### [Postman environment](Arion.postman_environment.json)
### [DB Diagram](diagram.drawio) (*https://app.diagrams.net/*)
### [Mocked User Credentials](api/config/demo.php)
#### When user is logged in used first organization from organization list. Switch organizations by */switch* route.
#### Run APP (local) - ``docker compose up -d`` (preferable)
#### Run APP (production) - `` docker compose -f docker-compose-production.yml up -d``
### 
#### After application start ``.env`` files will be created automatically
#### WEB is available on http://localhost:5173 (local)
#### WEB is available on http://localhost:80 (production)
#### API is available on http://localhost:8080
