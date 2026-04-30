# Security Controls & Hardening Document

This document outlines the specific security controls implemented within this Laravel E-Commerce Proof of Concept repository.

## 1. Password Hashing (Argon2id)
To secure user credentials against modern offline cracking attempts, the default `bcrypt` hashing algorithm has been upgraded to **Argon2id**. This is configured via the `.env` parameter `HASH_DRIVER=argon2id`. Argon2id is the industry standard recommendation for secure password hashing, providing robust resistance against both GPU-based and side-channel attacks by tuning memory and time costs.

## 2. Brute-Force Protection & Rate Limiting
The authentication module utilizes Laravel's robust `RateLimiter` mechanism inside the `LoginRequest`.
- **Threshold**: Users are limited to 5 login attempts per minute based on their IP and Email combination.
- **Lockout**: Exceeding the threshold triggers an `Illuminate\Auth\Events\Lockout` event and denies further requests with a `429 Too Many Requests` HTTP response, effectively preventing automated brute-force and credential stuffing attacks.

## 3. Cross-Site Request Forgery (CSRF) Protection
Laravel's native CSRF protection is fully active on all state-mutating POST/PUT/PATCH/DELETE routes.
- **Strict Rejection**: Submitting a form without the generated `@csrf` token (or with a forged token) will be caught by the application's exception handler. 
- **Configuration**: The `TokenMismatchException` has been strictly bound in `bootstrap/app.php` to immediately abort and return a `403 Forbidden` response instead of a generic page expired notice, satisfying rigid compliance checks.

## 4. HTTP Security Headers
A custom global middleware (`app/Http/Middleware/SecurityHeaders.php`) intercepts all outbound HTTP responses and injects standard security headers to secure the client browser session:
- `X-Frame-Options: DENY` (Prevents Clickjacking)
- `X-Content-Type-Options: nosniff` (Prevents MIME-sniffing)
- `Strict-Transport-Security: max-age=31536000; includeSubDomains` (Enforces HTTPS)
- `X-XSS-Protection: 1; mode=block` (Legacy but useful XSS guard)
- `Content-Security-Policy: default-src 'self'...` (Mitigates Cross-Site Scripting by whitelisting trusted domains)
