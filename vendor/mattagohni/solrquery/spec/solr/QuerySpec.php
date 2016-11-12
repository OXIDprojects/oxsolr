<?php

namespace spec\mattagohni\solrquery\solr;

use mattagohni\solrquery\solr\Query;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin Query
 */
class QuerySpec extends ObjectBehavior
{
    public function let()
    {
        $searchparameter = 'my_search_value';
        $this->beConstructedWith($searchparameter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Query::class);
    }

    public function it_returns_the_basic_search_query()
    {
        $this->getQuery()->shouldReturn('title:my_search_value');
    }

    public function it_returns_the_correct_search_query_for_multi_word_searchterm()
    {
        $searchparameter = 'my search value';
        $this->beConstructedWith($searchparameter);
        $this->getQuery()->shouldReturn('title:"my search value"');
    }

    public function it_can_add_a_additional_search_parameter()
    {
        $this->addAnd([
            'key'   => 'body',
            'value' => 'my_and_parameter'
        ]);
        $this->getQuery()->shouldReturn('title:my_search_value AND body:my_and_parameter');
    }

    public function it_can_add_an_additional_and_with_whitespace()
    {
        $this->addAnd(
            [
                'key' => 'body',
                'value' => 'my and parameter'
            ]
        );

        $this->getQuery()->shouldReturn('title:my_search_value AND body:"my and parameter"');
    }

    public function it_can_add_two_additional_ands()
    {
        $this->addAnd(
            [
                'key' => 'body',
                'value' => 'my and parameter'
            ]
        );
        $this->addAnd(
            [
                'key' => 'attribute',
                'value' => 'my_attribute'
            ]
        );

        $this->getQuery()->shouldReturn('title:my_search_value AND body:"my and parameter" AND attribute:my_attribute');
    }

    public function it_can_add_an_or_query()
    {
        $this->addOr(
            [
                'key' => 'body',
                'value' => 'my_or_attribute'
            ]
        );

        $this->getQuery()->shouldReturn('title:my_search_value OR body:my_or_attribute');
    }

    public function it_can_add_two_or()
    {
        $this->addOr(
            [
                'key' => 'body',
                'value' => 'my_or_attribute'
            ]
        );
        $this->addOr(
            [
                'key' => 'body',
                'value' => 'my_second_or_attribute'
            ]
        );
        $this->getQuery()->shouldReturn('title:my_search_value OR body:my_or_attribute OR body:my_second_or_attribute');
    }

    public function it_can_add_or_with_whitespace()
    {
        $this->addAnd(
            [
                'key' => 'attribute',
                'value' => 'my_attribute'
            ]
        );
        $this->addOr(
            [
                'key' => 'body',
                'value' => 'my_or_attribute'
            ]
        );
        $this->getQuery()->shouldReturn('(title:my_search_value AND attribute:my_attribute) OR body:my_or_attribute');
    }
}
