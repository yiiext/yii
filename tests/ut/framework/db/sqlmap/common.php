<?php

Yii::import('system.db.CDbConnection');
Yii::import('system.db.sqlmap.CSqlMap');

if(!defined('SRC_SQLMAP_DB_FILE'))
	define('SRC_SQLMAP_DB_FILE',dirname(__FILE__).'/data/source.db');
if(!defined('TEST_SQLMAP_DB_FILE'))
	define('TEST_SQLMAP_DB_FILE',dirname(__FILE__).'/data/test.db');
if(!defined('SQLMAP_BASE_PATH'))
    define('SQLMAP_BASE_PATH',dirname(__FILE__).'/sqlite');

class CSqlMapTestCase extends CTestCase
{
	protected $_connection;

	function initdb()
	{
		if(!extension_loaded('pdo') || !extension_loaded('pdo_sqlite'))
			$this->markTestSkipped('PDO and SQLite extensions are required.');
		copy(SRC_SQLMAP_DB_FILE,TEST_SQLMAP_DB_FILE);
		$this->_connection=new CDbConnection('sqlite:'.TEST_SQLMAP_DB_FILE);
	}

    function tearDown()
    {
        if($this->_connection!==null)
            $this->_connection->active=false;
    }

    function newSqlMap()
    {
        $this->initdb();
        $sqlmap = new CSqlMap($this->_connection);
        $sqlmap->basePath=SQLMAP_BASE_PATH;
        $this->_connection->active=true;
        return $sqlmap;
    }
}
