# Solr_basic

Solr_basic is a basic integration of Apaches Solr search engine (http://lucene.apache.org/solr/).

  - The default oxid search box is overwritten and uses solr
  
Therefore an initial article export to solr has to be done.

### Solr Installation (Bitnami)
* Download from https://bitnami.com/stack/solr an appropiate solr instance and follow the installation steps. 
* Navigate to the installation folder (windows eg. C:\Bitnami\solr-6.2.1-2\apache-solr\server\solr) and create a directory.
* Start Bitnami Apache Solr Stack Manager Tool and go to your Solr application. 
* Create a new core and insert the formercreated directory name into instanceDir. 

### Module Installation
* Insert in the module settings your solr configuration.

