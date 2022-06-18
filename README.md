## Ecommerce API Project

The sql file is present at "database" directory in the root folder.

The API documentation (Postman Collection) is stored at "postman" directory in the root folder.

API Routes:

- User - Registration (public)
- User - Login (public)
- User - Logout (protected, token required)
- Product - Add (protected, token required)
- Product - Update (protected, token required)
- Product - Get one (public)
- Product - Get all (public)
- Product - Delete one (protected, token required)
- Cart - Add cart items (public, x-auth-token / bearer token required)
- Cart - Update cart items quantity (public, x-auth-token / bearer token required)
- Cart - Get cart items by ID (public, x-auth-token / bearer token required)
- Cart - Delete cart items by ID (public, x-auth-token / bearer token required)

Unit Testing Commands:

- php artisan test --testsuite=Unit --filter AuthControllerTest
- php artisan test --testsuite=Unit --filter ProductControllerTest
- php artisan test --testsuite=Unit --filter CartControllerTest
