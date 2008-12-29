<?php

require_once(dirname(__FILE__).'/common.php');

class CSqlMapResultClassTest extends CSqlMapTestCase
{
    function testArrayResultMap()
    {
        $sqlmap = $this->newSqlMap();
        $result = $sqlmap->find('accounts.AccountsAsArrayViaResultClass');
        $this->assertTrue(is_array($result));
        var_dump($result);
    }
}
