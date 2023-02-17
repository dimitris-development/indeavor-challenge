## Coding Challenge for Indeavor

#### Introduction

This is a cloud-native project written in Laravel 9 (PHP 8.2.2) /MySQL and Vue 3/Vuetify/Vite with Swagger/Redoc documentation for the backend API. The backend has 3 micro-services: core, crust and mysql. Every service has its own container and we use Docker for containerization. Our backend is state-less to allow for horizontal scaling, and we authenticate our user-base with a simplified version of JWT authentication.

#### How to run

To run this application, you need Docker installed. Just open a terminal and type
`./core/vendor/bin/sail up -d `
This application uses ports 80 and 3000 to run the core and crust service respectively and you can access the mysql service at port 3306. This of course is configurable if there are other services running at these ports.

The swagger documentation is at the core service at http://localhost:80/swagger-ui and there's also http://localhost:80/redoc if you prefer Redoc.
The front end is at http://localhost:3000

#### Known issues:

1. Normally you need Composer installed to run this app (That's because Laravel Sail injects environment variables in the core container (laravel.test) that Laravel needs to run. This can be easily resolved by setting the correct WWWGROUP/WWWUSER UIDs in the .env file, but I didn't have the time to do that). To accomodate for that, in the tar.gz file I have included the vendor folder that you need to run the app.
2. This should have been a multitenant application, however there's not enough time for this implementation
3. This application has .env files but not .env.example
4. There's no indexing in the database
5. There is pagination for the Skills and Employees but it's currently not documented
6. Re-attaching a skill the belongs to an employee is handled incorrectly (Again I didn't have enough time)
