<?php

class OxSolr_Article_Main extends OxSolr_Article_Main_parent {
    const OXARTICLES = 'oxarticles__';

    /**
     * Updates article changes to solr.
     */
    public function save() {
        $oConfig = $this->getConfig();
        $sOxId = $this->getEditObjectId();
        $aParams = $oConfig->getRequestParameter("editval");
        $oArticle = oxNew('oxArticle');
        $oArticle->load($sOxId);
        $bNeedForExport = false;

        $oConfig = oxRegistry::get("oxConfig");
        $aFieldsToExport = $oConfig->getConfigParam("ATRICLE_FIELDS_TO_EXPORT");
        if (count($aFieldsToExport) > 0) {
            foreach ($aFieldsToExport as $sFieldName) {
                $sDbField = self::OXARTICLES . mb_strtolower($sFieldName);

                $sNewValue = $aParams[$sDbField];
                $sOldValue = $oArticle->getFieldData($sFieldName);
                $bNeedForExport = $sNewValue != $sOldValue;
                if ($bNeedForExport) {
                    //TODO call solarium
                    return parent::save();
                } else {
                    var_dump('do not export');
                }
            }
        }
        parent::save();

    }

}