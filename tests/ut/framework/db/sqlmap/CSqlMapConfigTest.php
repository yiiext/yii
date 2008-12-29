<?php

require_once(dirname(__FILE__).'/common.php');

class CSqlMapConfigTest extends CSqlMapTestCase
{
    function testDefaultSqlmapConfig()
    {
        $sqlmap = $this->newSqlMap(); 
        $expect=array('ok');
        $this->assertEquals($sqlmap->getMappingById('test-config'), $expect);
    }

    function testPathToFileConfig()
    {
        $sqlmap = $this->newSqlMap(); 
        $expect=array('ok');
        $path='simple.config.test-config';
        $this->assertEquals($sqlmap->getMappingById($path), $expect);
    }
}
