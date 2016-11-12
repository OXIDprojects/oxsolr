<?php

$oModule = oxNew('oxModule');
$sPath = $oModule->getModuleFullPath('oxsolr');

if (file_exists($sPath.'/vendor/autoload.php'))
{
    require_once($sPath.'/vendor/autoload.php');
} //if

class oxsolr extends oxBase
{
    protected $_documentList = array();
    protected $_availableTypes = array('article', 'category');

    /**
     * Get the Connection Parameters
     *
     * @return array Connection Parameters
     */
    private function _solrConnection()
    {
        $oConfig = oxRegistry::getConfig();

        $configSolr = array(
            'endpoint' => array(
                'localhost' => array(
                    'schema'    => 'http',
                    'core'      => $oConfig->getShopConfVar('CORE', $oConfig->getShopId(), 'module:oxsolr'),
                    'host'      => $oConfig->getShopConfVar('HOST', $oConfig->getShopId(), 'module:oxsolr'),
                    'port'      => $oConfig->getShopConfVar('PORT', $oConfig->getShopId(), 'module:oxsolr'),
                    'path'      => $oConfig->getShopConfVar('PATH', $oConfig->getShopId(), 'module:oxsolr'),
                )
            )
        );

        return $configSolr;
    } //function

    /**
     * Set a Document for SOLR
     *
     * @param $type string Document Type
     * @param $oObjectId string Oxid Object ID
     */
    public function setDocument($type, $oObjectId, $action = 'save')
    {
        if (in_array($type, $this->_availableTypes))
        {
            $doc         = new stdClass();
            $doc->type   = $type;
            $doc->id     = $oObjectId;
            $doc->action = $action;

            $this->_documentList[] = $doc;
        } //if
    } //function

    /**
     * Push the Documents to SOLR
     */
    public function pushToSolr()
    {
        $oConfig = oxRegistry::getConfig();
        $client = new Solarium\Client($this->_solrConnection());
        $update = $client->createUpdate();

        var_dump('Hallo');

        foreach ($this->_documentList as $docKey => $docValue)
        {
            // Delete Object
            if ($docValue->action == 'delete')
            {
                $update->addDeleteById($docValue->id);
                $update->addCommit();

                continue;
            } //if

            // Update/Insert Article
            if ($oConfig->getShopConfVar('ONLY_ARTICLES', $oConfig->getShopId(), 'module:oxsolr') && $docValue->type == 'article')
            {
                $oArticle = oxNew('oxArticle');

                if ($oArticle->load($docValue->id))
                {
                    if (!$oArticle->isVisible())
                    {
                        $update->addDeleteById($docValue->id);
                        $update->addCommit();

                        continue;
                    } //if
                }
                else
                {
                    continue;
                } //if

                $document = $update->createDocument();
                $document->id = $oArticle->getFieldData('oxid');
                $document->title = $oArticle->getFieldData('oxtitle');

                if ($oConfig->getShopConfVar('only_attribute', $oConfig->getShopId(), 'module:oxsolr'))
                {

                } //if
            }
            else if ($oConfig->getShopConfVar('ONLY_CATEGORIES', $oConfig->getShopId(), 'module:oxsolr') && $docValue->type == 'category')
            {
                $document = $update->createDocument();

            }
            else
            {
                continue;
            }//if

            $update->addDocuments(array($document));
            $update->addCommit();
        } //foreach

        $result = $client->update($update);

        return $result;
    } //function
} //class
