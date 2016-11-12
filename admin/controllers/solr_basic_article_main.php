<?php

class solr_basic_article_main extends solr_basic_article_main_parent {
    const OXARTICLES = 'oxarticles__';

    /**
     * isVisable
     * Updates article changes to solr.
     */
    public function save() {
        $oConfig = $this->getConfig();
        $sOxId = $this->getEditObjectId();
        $aParams = $oConfig->getRequestParameter("editval");
        $oArticle = oxNew('oxArticle');
        $oArticle->load($sOxId);

        $oConfig = oxRegistry::get("oxConfig");
        $aFieldsToExport=$oConfig->getConfigParam("ATRICLE_FIELDS_TO_EXPORT");
        foreach ($aFieldsToExport as $sFieldName){
            var_dump(self::OXARTICLES . $sFieldName);
            var_dump($aParams[self::OXARTICLES .mb_strtolower($sFieldName)]);
        }

    }

}