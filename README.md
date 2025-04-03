# OS Benefits Starter

A modern benefits calculation system built with Laravel, Nuxt.js, and Directus CMS.

## Features

- JWT Authentication
- Role-Based Access Control
- Redis Caching
- Automated CMS Workflow
- Lazy-loaded Components

## Quick Start

1. Clone the repository
2. Run `docker-compose up -d`
3. Access the services:
   - Frontend: http://localhost:3000
   - Backend API: http://localhost:8000
   - Directus CMS: http://localhost:8055

## Architecture

This project uses a microservices architecture with:
- Laravel backend API
- Nuxt.js frontend
- Directus headless CMS
- Redis for caching
- MySQL database

## Performance Benchmarks

See BENCHMARKS.md for detailed performance metrics.

## Case Study

See CASE_STUDY.md for implementation details and results. 