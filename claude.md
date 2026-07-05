# CLAUDE.md

## Project

This is a Laravel 13 application built with PHP 8.3.

Always follow Laravel 13 conventions and modern PHP best practices.

---

# Development Rules

- Use Laravel 13 features whenever possible.
- Never create duplicate functionality.
- Follow SOLID principles.
- Follow PSR-12 coding standards.
- Keep code clean and maintainable.
- Avoid unnecessary abstractions.
- Prefer dependency injection over facades when appropriate.
- Use typed properties and return types everywhere.
- Use readonly properties when applicable.
- Prefer constructor property promotion.

---

# Architecture

Follow Laravel's default folder structure.

Controllers
- Keep controllers thin.
- Controllers should only validate requests and call services/actions.

Business Logic
- Place business logic inside Services or Actions.
- Never place complex logic inside controllers.

Models
- Keep models focused.
- Use relationships.
- Avoid fat models.

Requests
- Always create FormRequest classes for validation.
- Never validate directly inside controllers.

Resources
- Always use API Resources for JSON responses.

Events
- Use Events and Listeners when appropriate.

Queues
- Queue long-running jobs.

Notifications
- Use Laravel Notifications.

Mail
- Use Mailables.

---

# Database

- Use Eloquent ORM.
- Avoid raw SQL unless necessary.
- Prefer relationships over manual joins.
- Use eager loading to prevent N+1 queries.
- Always create migrations.
- Never modify existing migrations after production.
- Use seeders and factories.

---



# Routes

- Keep routes clean.
- Group routes logically.
- Use route model binding.
- Prefer resource controllers.

---

# Blade

- Keep Blade templates simple.
- Move complex logic into View Models or Components.
- Use Blade Components whenever possible.

---

# API

- Return consistent JSON.
- Use API Resources.
- Proper HTTP status codes.
- Validation errors should follow Laravel defaults.

---

# Authentication

Prefer Laravel Breeze or Laravel Sanctum.

Use Policies and Gates for authorization.

Never hardcode permissions.

---

---

# Code Style

Always generate:

- strict types
- typed properties
- return types
- meaningful variable names
- meaningful method names

Avoid:

- unnecessary comments
- dead code
- duplicate logic
- magic numbers

---

# Performance

- Cache expensive queries.
- Use pagination.
- Eager load relationships.
- Optimize database queries.
- Avoid loading unnecessary columns.

---

# Security

Always:

- Escape output.
- Validate all input.
- Authorize every action.
- Protect against mass assignment.
- Never expose sensitive data.

Use:

- Hash::make()
- Policies
- CSRF protection
- Signed URLs when needed

---

# Logging

Use Laravel Log facade appropriately.

Never log:

- passwords
- tokens
- secrets

---

# Error Handling

Use Exceptions.

Do not suppress exceptions.

Return meaningful responses.

---

# Frontend

If using:

## Livewire

Prefer Livewire v4 conventions.

## Inertia

Use Inertia best practices.

## Vue

Use Composition API.

## Tailwind

Follow Tailwind utility-first principles.

---

# Commands

Before suggesting code:

1. Understand existing project structure.
2. Reuse existing code.
3. Do not introduce unnecessary packages.
4. Keep implementations Laravel-native.

---

# Preferred Packages

Prefer official Laravel packages first.

Examples:

- Sanctum
- Horizon
- Telescope
- Scout
- Cashier
- Socialite

Avoid third-party packages unless necessary.

---

# Output Expectations

When generating code:

- Show complete files.
- Explain architectural decisions briefly.
- Mention any artisan commands required.
- Include migrations if models change.
- Include tests for new features.
- Follow Laravel 13 conventions exactly.

Always assume this is a production-grade application.


---

# Repository Pattern (Mandatory)

The application must follow the Repository Pattern.

## Controllers

- Controllers must NEVER access Eloquent Models directly.
- Controllers must NEVER contain business logic.
- Controllers should only:
  - Receive requests
  - Validate using FormRequest
  - Call Services
  - Return Resources or Views

❌ Do NOT do:

User::find($id);

✅ Instead:

$user = $this->userService->findById($id);

---

## Services

- Services must NEVER directly access Eloquent Models.
- Services should communicate only with Repositories.
- Services should contain business logic only.

❌ Avoid:

User::create(...)

User::where(...)

Order::find(...)

✅ Use:

$this->userRepository->create(...)

$this->userRepository->findById(...)

$this->orderRepository->update(...)

---

## Repositories

Every Model must have:

- Repository Interface
- Repository Implementation

Example:

app/
    Repositories/
        Contracts/
            UserRepositoryInterface.php
        Eloquent/
            UserRepository.php

Bind repositories inside a Service Provider.

Example:

UserRepositoryInterface::class =>
UserRepository::class

Always inject interfaces instead of concrete classes.

---

## Repository Responsibilities

Repositories are responsible for:

- Database queries
- CRUD operations
- Filtering
- Searching
- Pagination
- Eager loading
- Transactions (when data persistence is involved)

Repositories should NOT contain business logic.

---

## Service Responsibilities

Services are responsible for:

- Business rules
- Validation beyond FormRequests
- Orchestrating multiple repositories
- Calling external APIs
- Dispatching Events
- Dispatching Jobs
- Sending Notifications
- Transaction coordination when multiple repositories are involved

Services should never execute Eloquent queries.

---

## Model Usage

Models should only exist for:

- Relationships
- Attribute Casting
- Accessors & Mutators
- Scopes
- Fillable/Guarded
- Model Events

Business logic should never live inside Models.

---

## Dependency Injection

Always inject:

Controller
    ↓
Service Interface
    ↓
Repository Interface
    ↓
Repository
    ↓
Model

Never inject Models into Controllers or Services.

Never call static Eloquent methods inside Controllers or Services.

---

## Preferred Flow

Request
    ↓
FormRequest
    ↓
Controller
    ↓
Service
    ↓
Repository
    ↓
Eloquent Model
    ↓
Database

This flow must be followed consistently throughout the project.

---