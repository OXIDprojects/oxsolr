<?php

namespace mattagohni\solrquery\solr;

class Query
{
    /** @var  string */
    protected $searchParameter;

    /** @var  string */
    protected $query;

    /** @var  array */
    protected $conditions;

    /**
     * Query constructor.
     * @param string $searchParameter
     */
    public function __construct($searchParameter)
    {
        $this->setSearchParameter($searchParameter);
    }

    /**
     * @param string $searchParameter
     */
    public function setSearchParameter($searchParameter)
    {

        $this->searchParameter = $this->parseSearchValue($searchParameter);
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        $this->query = "title:".$this->searchParameter;
        if (count($this->conditions) > 0) {
            foreach ($this->conditions as $condition) {
                $this->parseCondtion($condition);
            }
        }
        return $this->query;
    }

    public function addAnd($andQuery)
    {
        $andQuery['type'] = 'AND';
        $this->conditions[] = $andQuery;
    }

    public function addOr($orCondition)
    {
        $orCondition['type'] = 'OR';
        $this->conditions[] = $orCondition;
    }

    /**
     * @param string $searchParameter
     * @return string
     */
    private function parseSearchValue($searchParameter)
    {
        $searchParameterArray = explode(" ", $searchParameter);

        if (count($searchParameterArray) > 1) {
            $searchParameter = '"'.implode(' ', $searchParameterArray).'"';
        }
        return $searchParameter;
    }

    /**
     * @param $condition
     * @throws \Exception
     */
    protected function parseCondtion($condition)
    {
        $conditionString = ' ' . $condition['type'] . ' ' . $condition['key'] . ':' . $this->parseSearchValue($condition['value']);

        switch ($condition['type']) {
            case 'AND':
                $this->query .= $conditionString;
                break;
            case 'OR':
                if ($this->needBrackets()) {
                    $this->query = '(' . $this->query . ')' . $conditionString;
                } else {
                    $this->query .= $conditionString;
                }
                break;
            default:
                throw new \Exception('Condtion is not supported - '.$condition['type']);
        }
    }

    /**
     * @return bool
     */
    protected function needBrackets()
    {
        return strpos($this->query, '(') === false && strpos($this->query, 'AND') !== false;
    }
}
