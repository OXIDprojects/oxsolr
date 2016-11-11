<?php

class solr_oxsearch extends solr_oxsearch_parent
{
    protected $searchCount = 0;

    /**
     * @return int
     */
    public function getSearchCount()
    {
        return $this->searchCount;
    }

    /**
     * @param int $searchCount
     */
    public function setSearchCount($searchCount)
    {
        $this->searchCount = $searchCount;
    }

    /**
     * Returns a list of articles according to search parameters. Returns matched
     *
     * @param string $sSearchParamForQuery       query parameter
     * @param string $sInitialSearchCat          initial category to seearch in
     * @param string $sInitialSearchVendor       initial vendor to seearch for
     * @param string $sInitialSearchManufacturer initial Manufacturer to seearch for
     * @param string $sSortBy                    sort by
     *
     * @return oxarticlelist
     */
    public function getSearchArticles($sSearchParamForQuery = false, $sInitialSearchCat = false, $sInitialSearchVendor = false, $sInitialSearchManufacturer = false, $sSortBy = false)
    {
        $oArtList = oxNew('oxArticleList');
        $aSearchOxid = array();

        $configSolr = array(
            'endpoint' => array(
                'localhost' => array(
                    'schema' => 'http',
                    'core' => 'hackathon',
                    'host' => '192.168.99.100',
                    'port' => 8983,
                    'path' => '/solr/',
                )
            )
        );

        $client = new Solarium\Client($configSolr);
        $query = $client->createSelect();
        $query->setQuery('title:*'.$sSearchParamForQuery.'*');

        $query->setFields(array('id','title'));
        $query->addSort('id', $query::SORT_ASC);
        $resultset = $client->select($query);

        $this->setSearchCount($resultset->getNumFound());

        foreach ($resultset as $document) {

            // the documents are also iterable, to get all fields
            foreach ($document as $field => $value) {
                // this converts multivalue fields to a comma-separated string
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }

                if($field == 'id') {
                    array_push($aSearchOxid, $value);
                }
            }
        }

        if(sizeof($aSearchOxid) > 0) {
            $sql = "SELECT * FROM oxarticles WHERE oxid IN ('".implode("','", $aSearchOxid)."')";
            $oArtList->selectString($sql);
        }

        return $oArtList;
    }

    /**
     * @param bool $sSearchParamForQuery
     * @param bool $sInitialSearchCat
     * @param bool $sInitialSearchVendor
     * @param bool $sInitialSearchManufacturer
     * @return int
     */
    public function getSearchArticleCount($sSearchParamForQuery = false, $sInitialSearchCat = false, $sInitialSearchVendor = false, $sInitialSearchManufacturer = false) {
        return $this->getSearchCount();
    }
}