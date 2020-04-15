<?php

namespace Storyteq;

trait CloudLoggerTrait {
    
    /**
     * Undocumented function
     *
     * @param [type] $context
     * @param [type] $name
     * @param [type] $hostName
     * @param [type] $resource
     * @param [type] $labels
     * @return void
     */
    public function initCloudLogger($context, $projectId, $name, $hostName, $resource, $labels, $keyFile = null, $verbose = false)
    {
        $logger = new CloudLogger(
            $context,
            $projectId,
            $name,
            $hostName,
            $resource,
            $labels,
            $keyFile,
            $verbose
        );

        $GLOBALS['cloud_logger'] = $logger;
        return $GLOBALS['cloud_logger'];
    }

    /**
     * Undocumented function
     *
     * @param [type] $context
     * @return void
     */
    public function context($context = null)
    {
        $logger = $GLOBALS['cloud_logger'];      
        $logger->context($context);
        $GLOBALS['cloud_logger'] = $logger;
        return $logger->context();
    }

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param array $context
     * @return void
     */
    public function debug($message, $context = []) {
        $GLOBALS['cloud_logger']->log($message, $context, 'debug');
    }

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param array $context
     * @return void
     */
    public function info($message, $context = []) {
        $GLOBALS['cloud_logger']->log($message, $context, 'info');
    }

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param array $context
     * @return void
     */
    public function warn($message, $context = []) {
        $GLOBALS['cloud_logger']->log($message, $context, 'warn');
    }

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param array $context
     * @return void
     */
    public function error($message, $context = []) {
        $GLOBALS['cloud_logger']->log($message, $context, 'error');
    }

    /**
     * Undocumented function
     *
     * @param [type] $message
     * @param array $context
     * @return void
     */
    public function fatal($message, $context = []) {
        $GLOBALS['cloud_logger']->log($message, $context, 'fatal');
    }

    /**
     * Undocumented function
     *
     * @param [type] $context
     * @return void
     */
    public function child($context) {
        return $GLOBALS['cloud_logger']->child($context);
    }
}