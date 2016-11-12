<?php

$aModule = array(
        'id' => 'solr_basic',
        'title' => 'Solr für Oxid',
        'description' => 'Solr-Suche für Oxid',
        'author' => 'Oxid Hackthon',
        'version' => '1.0',
        'extend' => array(
                'oxsearch' => 'hackathon/solr_basic/models/solr_oxsearch',
                'article_main' => 'hackathon/solr_basic/admin/controllers/solr_basic_article_main',
        ),
        'files' => array(
                'solr' => 'hackathon/solr_basic/core/solr.php',
        ),
        'blocks' => array(// array('template' => 'page/list/list.tpl', 'block'=>'page_list_listhead', 'file'=> '/views/blocks/page_list_listhead.tpl'),
        ),
        'settings' => array(
                array(
                        'group' => 'SOLR_CONFIG',
                        'name' => 'CORE',
                        'type' => 'str',
                        'value' => ''
                ),
                array(
                        'group' => 'SOLR_CONFIG',
                        'name' => 'HOST',
                        'type' => 'str',
                        'value' => ''
                ),
                array(
                        'group' => 'SOLR_CONFIG',
                        'name' => 'PORT',
                        'type' => 'str',
                        'value' => ''
                ),
                array(
                        'group' => 'SOLR_CONFIG',
                        'name' => 'PATH',
                        'type' => 'str',
                        'value' => ''
                ),
                array(
                        'group' => 'SOLR_EXPORT',
                        'name' => 'ONLY_ARTICLES',
                        'type' => 'bool',
                        'value' => '0'
                ),
                array(
                        'group' => 'SOLR_EXPORT',
                        'name' => 'ONLY_CATEGORIES',
                        'type' => 'bool',
                        'value' => '0'
                ),
                array( 'group' => 'SOLR_EXPORT',  'name' => 'ATRICLE_FIELDS_TO_EXPORT',      'type' => 'arr',  'value' => '' ),
                array( 'group' => 'SOLR_EXPORT',  'name' => 'CATEGORY_FIELDS_TO_EXPORT',      'type' => 'arr',  'value' => '' ),
                array( 'group' => 'SOLR_EXPORT',  'name' => 'STOPWORDS',      'type' => 'arr',  'value' => '' ),
        )
);