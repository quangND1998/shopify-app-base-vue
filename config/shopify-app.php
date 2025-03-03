<?php

return [
    /*
    |--------------------------------------------------------------------------
    | App Env
    |--------------------------------------------------------------------------
    |
    | Env app in system
    |
    */
    'app_env' => env('APP_ENV', 'local'),

    /*
    |--------------------------------------------------------------------------
    | App Id
    |--------------------------------------------------------------------------
    |
    | Id app in system
    |
    */
    'app_id' => env('APP_ID', 1),

    /*
    |--------------------------------------------------------------------------
    | App Name
    |--------------------------------------------------------------------------
    |
    | App name Shopify
    |
    */
    'app_name' => env('APP_NAME', 1),

    'app_embed' => env('APP_EMBED', 0),

    /*
    |--------------------------------------------------------------------------
    | After authenticate redirect
    |--------------------------------------------------------------------------
    |
    | Redirect to admin Shopify
    |
    */
    'redirect_after_authenticate' => env('SHOPIFY_REDIRECT_AFTER_AUTHENTICATE', 1),

    /*
    |--------------------------------------------------------------------------
    | After authenticate redirect url
    |--------------------------------------------------------------------------
    */
    'redirect_after_authenticate_url' => env('SHOPIFY_REDIRECT_AFTER_AUTHENTICATE_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | After billing redirect url
    |--------------------------------------------------------------------------
    */
    'redirect_after_billing_url' => env('SHOPIFY_REDIRECT_AFTER_BILLING_URL', ''),

    /*
    |--------------------------------------------------------------------------
    | Running migration default
    |--------------------------------------------------------------------------
    */
    'run_default_migrations' => env('SHOPIFY_RUN_DEFAULT_MIGRATIONS', false),

    /*
    |--------------------------------------------------------------------------
    | Route names
    |--------------------------------------------------------------------------
    |
    | This option allows you to override the package's built-in route names.
    | This can help you avoid collisions with your existing route names.
    |
    */
    'route_names' => [
        'home'            => env('SHOPIFY_ROUTE_NAME_HOME', 'home'),
        'authenticate'    => env('SHOPIFY_ROUTE_NAME_AUTHENTICATE', 'authenticate'),
        'webhook'         => env('SHOPIFY_ROUTE_NAME_WEBHOOK', 'webhook'),
        'billing'         => env('SHOPIFY_ROUTE_NAME_BILLING', 'billing'),
        'billing.process' => env('SHOPIFY_ROUTE_NAME_BILLING_PROCESS', 'billing.process'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Shopify Webhooks
    |--------------------------------------------------------------------------
    |
    | This option is for defining webhooks.
    | Key is for the Shopify webhook event
    | Value is for the endpoint to call
    |
    */
    'webhooks' => [
        [
            'topic' => env('SHOPIFY_WEBHOOK_1_TOPIC', 'app/uninstalled'),
            'address' => env('SHOPIFY_WEBHOOK_1_ADDRESS', env('APP_URL') . '/webhook/app-uninstalled')
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Job Queues
    |--------------------------------------------------------------------------
    |
    | This option is for setting a specific job queue for webhooks, scripttags
    | and after_authenticate_job.
    |
    */
    'job_queues' => [
        'webhooks'           => env('SHOPIFY_WEBHOOKS_JOB_QUEUE', null),
        'script_tags'         => env('SHOPIFY_SCRIPT_TAGS_JOB_QUEUE', null),
        'after_authenticate' => env('SHOPIFY_AFTER_AUTHENTICATE_JOB_QUEUE', null),
        'after_uninstalled' => env('SHOPIFY_AFTER_UNINSTALLED_JOB_QUEUE', null),
        'after_billing' => env('SHOPIFY_AFTER_BILLING_JOB_QUEUE', null),
        'before_authenticate' => env('SHOPIFY_BEFORE_AUTHENTICATE_JOB_QUEUE', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | Shopify ScriptTags
    |--------------------------------------------------------------------------
    |
    | This option is for defining scripttags.
    |
    */
    'script_tags' => [
        // [
        //     'src' => env ( 'SHOPIFY_SCRIPT_TAG_1_SRC' , env( 'MIX_APP_PUBLIC_URL' ). '/js/client.js?v=' . uniqid() ),
        //     'event' => env ( 'SHOPIFY_SCRIPT_TAG_1_EVENT' , 'onload' ),
        //     'display_scope' => env ( 'SHOPIFY_SCRIPT_TAG_1_DISPLAY_SCOPE' , 'online_store' )
        // ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Shopify Jobs Namespace
    |--------------------------------------------------------------------------
    |
    | This option allows you to change out the default job namespace
    | which is \App\Jobs. This option is mainly used if any custom configuration
    | is done in autoload and does not need to be changed unless required.
    |
    */
    'job_namespace' => env('SHOPIFY_JOB_NAMESPACE', '\\App\\Jobs\\'),

    /*
    |--------------------------------------------------------------------------
    | Before Authenticate Job
    |--------------------------------------------------------------------------
    |
    | This option is for firing a job before a shop has been authenticated.
    | This, like webhooks and scripttag jobs, will fire every time a shop
    | authenticates, not just once.
    |
    */
    'before_authenticate_job' => [
        /*
            [
                'job' => env('BEFORE_AUTHENTICATE_JOB'), // example: \App\Jobs\BeforeAuthorizeJob::class
                'inline' => env('BEFORE_AUTHENTICATE_JOB_INLINE', false) // False = dispatch job for later, true = dispatch immediately
            ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | After Authenticate Job
    |--------------------------------------------------------------------------
    |
    | This option is for firing a job after a shop has been authenticated.
    | This, like webhooks and scripttag jobs, will fire every time a shop
    | authenticates, not just once.
    |
    */
    'after_authenticate_job' => [
        /*
            [
                'job' => env('AFTER_AUTHENTICATE_JOB'), // example: \App\Jobs\AfterAuthorizeJob::class
                'inline' => env('AFTER_AUTHENTICATE_JOB_INLINE', false) // False = dispatch job for later, true = dispatch immediately
            ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Uninstall app Job
    |--------------------------------------------------------------------------
    */
    'app_uninstalled_job' => \QuangND\Shopify\Jobs\AppUninstalledJob::class,

    /*
    |--------------------------------------------------------------------------
    | After uninstall app Job
    |--------------------------------------------------------------------------
    */
    'after_uninstalled_job' => [
        /*
            [
                'job' => env('AFTER_UNINSTALLED_JOB'), // example: \App\Jobs\AfterUninstalledJob::class
                'inline' => env('AFTER_UNINSTALLED_JOB_INLINE', false) // False = dispatch job for later, true = dispatch immediately
            ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Billing
    |--------------------------------------------------------------------------
    |
    | Enable billing component to the package.
    |
    */

    'billing_enabled' => (bool) env('SHOPIFY_BILLING_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Billing Plan Default Id
    |--------------------------------------------------------------------------
    |
    | Billing Plan Default.
    |
    */

    'billing_plan_id' => env('SHOPIFY_BILLING_PLAN_ID', false),

    /*
    |--------------------------------------------------------------------------
    | Billing Redirect
    |--------------------------------------------------------------------------
    |
    | Required redirection URL for billing when
    | a customer accepts or declines the charge presented.
    |
    */
    'billing_redirect' => env('SHOPIFY_BILLING_REDIRECT', '/billing/process'),

    /*
    |--------------------------------------------------------------------------
    | After billing app Job
    |--------------------------------------------------------------------------
    */
    'after_billing_job' => [
        /*
            [
                'job' => env('AFTER_BILLING_JOB'), // example: \App\Jobs\AfterBillingJob::class
                'inline' => env('AFTER_BILLING_JOB_INLINE', false) // False = dispatch job for later, true = dispatch immediately
            ],
        */
    ],

    'partner_id' => env('SHOPIFY_PARTNER_ID'),
    'partner_app_id' => env('SHOPIFY_PARTNER_APP_ID'),
    'partner_access_token' => env('SHOPIFY_PARTNER_ACCESS_TOKEN'),

    'theme_app_extension_enabled' => env('SHOPIFY_THEME_APP_EXTENSION_ENABLED', false),
    'app_block_templates' => env('SHOPIFY_APP_BLOCK_TEMPLATES', 'product, collection, index'),


      /*
    |--------------------------------------------------------------------------
    | Manual migrations
    |--------------------------------------------------------------------------
    |
    | This option allows you to use:
    | `php artisan vendor:publish --tag=shopify-migrations` to push migrations
    | to your app's folder so you're free to modify before migrating.
    |
    */

    'manual_migrations' => (bool) env('SHOPIFY_MANUAL_MIGRATIONS', false),
];
