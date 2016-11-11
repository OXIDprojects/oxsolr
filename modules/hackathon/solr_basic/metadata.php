<?php

$aModule = array(
    'id' => 'solr_basic',
    'title' => 'Solr für Oxid',
    'description' => 'Solr-Suche für Oxid',
    'author' => 'Oxid Hackthon',
    'version' => '1.0',
    'extend'      => array(
        'oxsearch' => 'hackathon/solr_basic/modules/solr_oxsearch',
    ),
    'blocks' => array(
       // array('template' => 'page/list/list.tpl', 'block'=>'page_list_listhead', 'file'=> '/views/blocks/page_list_listhead.tpl'),
    ),
);