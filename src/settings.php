<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // Database settings
        'database_default' => [
            'dbhost' => '.',
            'dbname' => 'ScriptForms',
            'dbuser' => 'sa',
            'dbpasswd' => '123456'
        ],

        // Database settings
        'database_lotes' => [
            'dbhost' => '.',
            'dbname' => 'RENDIMOS',
            'dbuser' => 'sa',
            'dbpasswd' => '123456'
        ],


        //Mailer settings
        'mailer2' => [
            'Host' => 'arauca.tepuyserver.net',
            'SMTPAuth' => true,
            'Username' => 'ezerpa@dosisunitarias.com',
            'Password' => '201619duv',
            'SMTPSecure' => 'tls',
            'Port' => 25,
            'MailerMail' => 'ezerpa@dosisunitarias.com',
            'MailerName' => 'ScriptForms',
            'ReplyToMail' => 'ezerpa@dosisunitarias.com',
            'ReplyToName' => 'Información'
        ],
        
        'mailer' => [
            'SMTPSecure' => 'tls',
            'Username' => 'ebert15@hotmail.com',
            'Password' => '123enclave.21978',
            'MailerMail' => 'ebert15@hotmail.com',
            'MailerName' => 'ScriptForms',
            'Host' => 'smtp.live.com',
            'Port' => 587,
            'SMTPAuth' => true,
            'ReplyToMail' => 'ebertunerg@gmail.com',
            'ReplyToName' => 'Información'
        ],
    ],
];
