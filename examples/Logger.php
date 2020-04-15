<?php

require_once __DIR__ . '/../vendor/autoload.php'; 

use Storyteq\CloudLoggerTrait;

class Logger
{
    use CloudLoggerTrait;

    /**
     * Undocumented function
     */
    public function __construct()
    {
        $this->initCloudLogger(
            [
                'entity' => 'media',
                'id' => 20,
            ],
            'google-cloud-project-id',
            'your-app-name',
            '127.0.0.1',
            ['type' => 'gce_instance'],
            ['zone' =>  'europe-west-4a'],
            json_decode(file_get_contents(__DIR__.'/../credentials.json'), true)
        );

        // Sending a log with loglevel info
        $this->info('Creating a log');

        // Adding more context parameters
        $this->context(['more' => 'context']);

        // Sending a log with loglevel warning and updated context
        $this->warn('Creating another log!');
    }
}

new Logger();
?>