<?php

namespace Storyteq;

use Carbon\Carbon;
use Google\Cloud\Logging\LoggingClient;

class CloudLogger
{
    protected $client;
    protected $logger;
    protected $context;
    protected $name;
    protected $hostName;
    protected $resource;
    protected $labels;
    protected $projectId;

    /**
     * Undocumented function
     *
     * @param [type] $projectId
     * @param [type] $context
     * @param [type] $name
     * @param [type] $hostName
     * @param [type] $resource
     * @param [type] $labels
     */
    public function __construct($context, $projectId, $name, $hostName, $resource, $labels, $keyFile = null, $verbose = false)
    {
        $this->projectId = $projectId;
        $this->context = $context;
        $this->name = $name;
        $this->hostName = $hostName;
        $this->resource = $resource;
        $this->labels = $labels;
        $this->verbose = $verbose;

        $client = [
            'projectId' => $this->projectId,
        ];

        if ($keyFile) {
            $client['keyFile'] = $keyFile;
        }

        $this->client = new LoggingClient($client);

        $this->logger = $this->client->logger('php-cloud-logger', [
            'resource' => $this->resource,
            'labels' => $this->labels,
        ]);
    }

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param [type] $context
     * @param [type] $type
     * @return void
     */
    public function log($message, $context, $type)
    {
        $formatted = $this->format($message, $context, $type);
        $entry = $this->logger->entry(
            $formatted['message'],
            $formatted['args']
        );
        $this->logger->write($entry);

        if ($this->verbose){
            echo $message.PHP_EOL;
        }
    }

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param [type] $context
     * @param [type] $type
     * @return void
     */
    public function format($message, $context, $type) {

        $levels = [
            'debug' => [
                'level' => 20,
                'severity' => $this->logger::DEBUG,
            ],
            'info' => [
                'level' => 30,
                'severity' => $this->logger::INFO,
            ],
            'warn' => [
                'level' => 40,
                'severity' => $this->logger::WARNING,
            ],
            'error' => [
                'level' => 50,
                'severity' => $this->logger::ERROR,
            ],
            'fatal' => [
                'level' => 60,
                'severity' => $this->logger::EMERGENCY,
            ],
        ];

        $message = [
            'msg' => $message,
            'context' => array_merge($this->context, $context),
            'level' => $levels[$type]['level'],
            'levelName' => $type,
            'name' => $this->name,
            'hostname' => $this->hostName,
            'v' => 0,
            'time' => Carbon::now()->toISOString()
        ];

        $args = [
            'severity' => $levels[$type]['severity'],
        ];

        return [
            'message' => $message,
            'args' => $args
        ];
    }

    /**
     * Undocumented function
     *
     * @param [type] $context
     * @return void
     */
    public function child($context){
        $child = clone $this;
        $child->context($context);
        return $child;
    }

    /**
     * Undocumented function
     *
     * @param [type] $context
     * @return void
     */
    public function context($context = null){
        if(!$context) {
            return $this->context;
        }
        $this->context = array_merge($this->context, $context);
        return $this->context;
    } 
}