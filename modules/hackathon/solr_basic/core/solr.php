<?php

class solr extends oxBase
{
    public function solrConnection()
    {
        $configSolr = array(
            'endpoint' => array(
                'localhost' => array(
                    'schema' => 'http',
                    'core' => 'hackathon',
                    'host' => '192.168.99.100',
                    'port' => 8983,
                    'path' => '/oxhackathon/',
                )
            )
        );

        return $configSolr;
    } //function
} //class