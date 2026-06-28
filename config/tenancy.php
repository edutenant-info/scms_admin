<?php

use App\Models\Institution;
use App\Models\Organisation;

return [

    /*
    |--------------------------------------------------------------------------
    | Central Domains
    |--------------------------------------------------------------------------
    | Requests to these domains bypass tenant resolution entirely.
    */
    'central_domains' => [
        'localhost',
        '127.0.0.1',
        // 'yourapp.com',
        // 'admin.yourapp.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant Hierarchy
    |--------------------------------------------------------------------------
    */
    'hierarchy' => [
        Organisation::class => null,
        Institution::class => Organisation::class,
        //     => \SatishSinghDevbha\Multitenancy\Models\Organisation::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Resolvers
    |--------------------------------------------------------------------------
    | Resolvers are tried in order — first match wins.
    | Add PathResolver or HeaderResolver here to enable those strategies.
    */
    'resolvers' => [
        \SatishSinghDevbha\Multitenancy\Resolvers\SubdomainResolver::class,
        \SatishSinghDevbha\Multitenancy\Resolvers\DomainResolver::class,
        // \SatishSinghDevbha\Multitenancy\Resolvers\PathResolver::class,
        // \SatishSinghDevbha\Multitenancy\Resolvers\HeaderResolver::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Bootstrappers
    |--------------------------------------------------------------------------
    | Run in order on tenant init; reverted in reverse order on tenancy end.
    */
    'bootstrappers' => [
        \SatishSinghDevbha\Multitenancy\Bootstrappers\ConfigBootstrapper::class,
        \SatishSinghDevbha\Multitenancy\Bootstrappers\DatabaseBootstrapper::class,
        \SatishSinghDevbha\Multitenancy\Bootstrappers\CacheBootstrapper::class,
        \SatishSinghDevbha\Multitenancy\Bootstrappers\QueueBootstrapper::class,
        \SatishSinghDevbha\Multitenancy\Bootstrappers\FilesystemBootstrapper::class,
        // \SatishSinghDevbha\Multitenancy\Bootstrappers\SessionBootstrapper::class,
        // \SatishSinghDevbha\Multitenancy\Bootstrappers\LogBootstrapper::class,
        // \SatishSinghDevbha\Multitenancy\Bootstrappers\BroadcastBootstrapper::class,
        // \SatishSinghDevbha\Multitenancy\Bootstrappers\MailBootstrapper::class,
        // \SatishSinghDevbha\Multitenancy\Bootstrappers\RedisBootstrapper::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Config Source
    |--------------------------------------------------------------------------
    */
    'config_source' => 'both',

    /*
    |--------------------------------------------------------------------------
    | Resolution Cache
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'ttl'     => 300,
        'store'   => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Tenancy
    |--------------------------------------------------------------------------
    | enabled       — switch DB connections per tenant (multi-database mode)
    | auto_provision — automatically CREATE the tenant database on TenantCreated
    | auto_teardown  — automatically DROP the tenant database on teardown
    | charset/collation — used when auto-creating MySQL/MariaDB databases
    */
    'database' => [
        'enabled'        => false,
        'connection'     => 'tenant',
        'auto_provision' => false,
        'auto_teardown'  => false,
        'charset'        => 'utf8mb4',
        'collation'      => 'utf8mb4_unicode_ci',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Prefix
    |--------------------------------------------------------------------------
    */
    'cache_prefix' => 'tenant_',

    /*
    |--------------------------------------------------------------------------
    | Tenant Migrations
    |--------------------------------------------------------------------------
    | path — directory (relative to the project root) holding tenant-specific
    |        migrations. When set, the tenancy:migrate* commands run ONLY these
    |        migrations inside tenant context. Leave null to run the application's
    |        default migrations.
    */
    'migrations' => [
        'path' => null, // e.g. 'database/migrations/tenant'
    ],

    /*
    |--------------------------------------------------------------------------
    | Mail Isolation  (opt-in bootstrapper: MailBootstrapper)
    |--------------------------------------------------------------------------
    | Overrides the outgoing "from" identity per tenant, read from tenant
    | metadata. Tenants without these metadata keys keep the app defaults.
    */
    'mail' => [
        'enabled'              => false,
        'from_address_meta_key' => 'mail.from.address',
        'from_name_meta_key'    => 'mail.from.name',
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Isolation  (opt-in bootstrapper: RedisBootstrapper)
    |--------------------------------------------------------------------------
    | Prefixes the Redis connection key prefix per tenant, isolating sessions,
    | locks, queues and raw Redis usage. prefix supports {tenant_id}/{tenant_key}.
    */
    'redis' => [
        'enabled' => false,
        'prefix'  => 'tenant_{tenant_id}_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Filesystem
    |--------------------------------------------------------------------------
    */
    'filesystem' => [
        'disk'          => 'local',
        'root_override' => 'tenants/{tenant_id}',
    ],

    /*
    |--------------------------------------------------------------------------
    | Session Isolation
    |--------------------------------------------------------------------------
    | Enabled → must place 'tenancy' middleware BEFORE StartSession.
    | cookie_suffix — appends tenant key to the session cookie name to prevent
    |                 cross-tenant session sharing in the same browser.
    | file_path     — isolates session files into a per-tenant directory
    |                 (only applies to the 'file' session driver).
    */
    'session' => [
        'enabled'       => false,
        'cookie_suffix' => true,
        'file_path'     => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Isolation
    |--------------------------------------------------------------------------
    | Routes log output to a separate file per tenant.
    | path supports {tenant_id} and {tenant_key} placeholders.
    */
    'logging' => [
        'enabled'  => false,
        'channel'  => 'tenant_file',
        'path'     => 'logs/tenants/{tenant_id}/laravel.log',
        'level'    => 'debug',
    ],

    /*
    |--------------------------------------------------------------------------
    | Broadcasting Isolation
    |--------------------------------------------------------------------------
    | Stores a per-tenant broadcast prefix in the container.
    | Use the tenant_channel('my-channel') helper in your broadcast definitions.
    | prefix supports {tenant_id} and {tenant_key} placeholders.
    */
    'broadcasting' => [
        'enabled' => false,
        'prefix'  => 'tenant.{tenant_id}',
    ],

    /*
    |--------------------------------------------------------------------------
    | Path-Based Resolver
    |--------------------------------------------------------------------------
    | Resolves tenant from the URL path: yourapp.com/acme/dashboard
    | segment — zero-based index of the path segment to check
    | use_key — true = match by slug, false = match by ID
    */
    'path_resolver' => [
        'enabled' => false,
        'segment' => 0,
        'use_key' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Header-Based Resolver
    |--------------------------------------------------------------------------
    | Resolves tenant from an HTTP request header (API tenancy).
    | header  — header name to inspect (e.g. 'X-Tenant')
    | use_key — true = match by slug/key, false = match by ID
    */
    'header_resolver' => [
        'enabled' => false,
        'header'  => 'X-Tenant',
        'use_key' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Soft Deletes
    |--------------------------------------------------------------------------
    | When enabled, tenancy:teardown soft-deletes the tenant model (delete())
    | instead of permanently removing it (forceDelete()).
    | Requires the soft-deletes migration to have been run.
    */
    'soft_deletes' => [
        'enabled' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant Impersonation
    |--------------------------------------------------------------------------
    | Allows admins to "act as" a tenant from the central domain.
    | Register the 'tenancy.impersonate' middleware on your admin routes.
    | enabled     — must be true for the middleware to activate context
    | session_key — session key storing the impersonated tenant's ID
    | model_key   — session key storing the impersonated tenant's class
    */
    'impersonation' => [
        'enabled'     => false,
        'session_key' => 'tenancy_impersonating_id',
        'model_key'   => 'tenancy_impersonating_type',
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant URL Generation
    |--------------------------------------------------------------------------
    | Used by TenantUrlGenerator (and the tenant_url() helper).
    | base_domain — your app's root domain (e.g. 'yourapp.com')
    | scheme      — 'https' or 'http'
    */
    'url' => [
        'base_domain' => null,
        'scheme'      => 'https',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cleanup Pipeline
    |--------------------------------------------------------------------------
    | Controls what the TenantCleanupPipeline deletes when tearing down a tenant.
    | steps — array of callables(Tenant $tenant): void for custom cleanup logic.
    */
    'cleanup' => [
        'flush_cache'    => true,
        'delete_files'   => true,
        'drop_database'  => true,
        'delete_domains' => true,
        'delete_configs' => true,
        'steps'          => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tenant-Aware Scheduled Commands
    |--------------------------------------------------------------------------
    | Commands listed here are automatically registered in the scheduler
    | and run inside every root-level tenant's context.
    | Format: 'artisan:command' => 'daily' | 'hourly' | 'everyMinute' | etc.
    */
    'schedule' => [
        'enabled'  => false,
        'commands' => [
            // 'cache:clear' => 'daily',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Not-Found Behaviour
    |--------------------------------------------------------------------------
    */
    'tenant_not_found' => 'abort',

    /*
    |--------------------------------------------------------------------------
    | Suspended Tenant Behaviour
    |--------------------------------------------------------------------------
    */
    'tenant_suspended' => 'abort',

];
