<?php
/**
 * CSqlMap class file.
 *
 * @author Wei Zhuo <weizhuo@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2009 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CSqlMap is the gateway class to the SqlMap database mapping
 * solution.
 *
 * @author Wei Zhuo <weizhuo@gmail.com>
 * @version $Id$
 * @package system.db.sqlmap
 * @since 1.1
 */
class CSqlMap extends CApplicationComponent
{
    /**
     * @var string the ID of the {@link CDbConnection} application component. 
     * If not set the default application component 'db' will be used.
     */
    public $connectionID;

    /**
     * @var CDbConnection the database connection for the data mapper. 
     * By default, this is the 'db' application component.
     * @see getDbConnection
     */
    private $_db;

    /**
     * @var CSqlMapConfig sqlmap configuration containing file path information 
     * and mapping data.
     * @see CSqlMapConfig
     */
    protected $_config;

    /**
     * Constructor.
     * @param CDbConnection database connection for this new data mapper.
     * If not specified, the application component named 'db' will be used.
     * @param CSqlMapConfig mapping configurations
     * @see setDbConnection
     * @see CSqlMapConfig
     */
    public function __construct($dbConnection=null, $config=null)
    {
        $this->_db=$dbConnection;
        $this->_config=$config!==null?$config:new CSqlMapConfig();
    }

    /**
     * @param string base directory of mapping configuration files.
     * @see CSqlMapConfig::basePath
     */
    public function setBasePath($path)
    {
        $this->_config->basePath=$path;
    }

    /**
     * @return string base directory of mapping configuration files.
     * @see CSqlMapConfig::basePath
     */
    public function getBasePath()
    {
        return $this->_config->basePath;
    }

    /**
     * Returns the database connection used by the data mapper.
     * Uses the default application database connection when {@link connectionID} is empty.
     * @return CDbConnection current database connection
     * @throws CException if {@link connectionID} does not point to a valid application component.
     * @throws CDbException if default application database component is not a database connection.
     */
    public function getDbConnection()
    {
        if($this->_db!==null)
            return $this->_db;
        else if(($id=$this->connectionID)!==null)
        {
            if(($this->_db=Yii::app()->getComponent($id)) instanceof CDbConnection)
                return $this->_db;
            else
                throw new CException(Yii::t('yii','CSqlMap.connectionID "{id}" is invalid. Please make sure it refers to the ID of a CDbConnection application component.', array('{id}'=>$id)));
        }
        $this->_db=Yii::app()->getDb();
        if(!($this->_db instanceof CDbConnection))
            throw new CDbException(Yii::t('yii', 'CSqlMap requires a "db" CDbConnection application component.'));
    }

    /**
     * Initializes the application component.
     * This method overrides the parent implementation by setting the base path
     * to 'application.sqlmap' when {@link basePath} is not set.
     */
    public function init()
    {
        parent::init();
        if($this->getBasePath()==='.')
            $this->setBasePath(Yii::app()->getBasePath().DIRECTORY_SEPARATOR.'sqlmap');
    }

    /**
     * @param string mapping key, see {@link CSqlMapConfig::getMappingById} for details. 
     * @return array mapping data corresponding to the mapping key.
     * @see CSqlMapConfig::resolveMappingKey
     */
    public function getMappingById($str)
    {
        return $this->_config->getMappingById($str);
    }

    /**
     * Executes a Sql SELECT statement that returns data
     * to populate a single object instance.
     *
     * The argument $params is generally used to supply the input
     * data for the WHERE clause parameter(s) of the SELECT statement.
     * 
     * @param mixed query id or criteria.
     * If a string, it is treated as query id;
     * If an array, it is treated as the initial values for constructing a {@link CSqlMapCriteria} object;
     * Otherwise, it should be an instance of {@link CSqlMapCriteria}.
     * @param array parameters to be bound to the query SQL statement.
     * This is only used when the first parameter is a string (query id).
     * In other cases, please use {@link CSqlMapCriteria::params} to set parameters.
     * @return mixed the first mapped row of the query result, null if no record is found.
     */
    public function query($id, $params=array())
    {
        $mapping=$this->getMappingById($id);
        $stm=$this->getDbConnection()->createCommand($mapping['sql']);
        $result=array();
        foreach($stm->query() as $row)
            $result[] = $row;
        return $row;
    }

     /**
     * Executes a Sql SELECT statement that returns data
     * to populate a number of result objects.
     *
     * The argument $params is generally used to supply the input
     * data for the WHERE clause parameter(s) of the SELECT statement.
      *
     * @param mixed query id or criteria.
     * If a string, it is treated as query id;
     * If an array, it is treated as the initial values for constructing a {@link CSqlMapCriteria} object;
     * Otherwise, it should be an instance of {@link CSqlMapCriteria}.
     * @param array parameters to be bound to the query SQL statement.
     * This is only used when the first parameter is a string (query id).
     * In other cases, please use {@link CSqlMapCriteria::params} to set parameters.
     * @return array all rows of the query result. Each array element 
     * is an array representing a mapped object.
     */
    public function queryAll($id, $params=array())
    {
    }

    /**
     * Executes a Sql INSERT statement.
     *
     * Insert is a bit different from other update methods, as it provides
     * facilities for returning the primary key of the newly inserted row
     * (rather than the effected rows),
     *
     * The argument $params is generally used to supply the input data for the
     * INSERT values.
     *
     * @param mixed query id or criteria.
     * If a string, it is treated as query id;
     * If an array, it is treated as the initial values for constructing a {@link CSqlMapCriteria} object;
     * Otherwise, it should be an instance of {@link CSqlMapCriteria}.
     * @param array parameters to be bound to the query SQL statement.
     * @return mixed The primary key of the newly inserted row.
     * This might be automatically generated by the RDBMS,
     * or selected from a sequence table or other source.
     */
    public function insert($id, $params=array())
    {        
    }

    /**
     * Executes a Sql UPDATE statement.
     *
     * Update can also be used for any other update statement type, such as
     * inserts and deletes.  Update returns the number of rows effected.
     *
     * The parameter object is generally used to supply the input data for the
     * UPDATE values as well as the WHERE clause parameter(s).
     *
     * @param mixed query id or criteria.
     * If a string, it is treated as query id;
     * If an array, it is treated as the initial values for constructing a {@link CSqlMapCriteria} object;
     * Otherwise, it should be an instance of {@link CSqlMapCriteria}.
     * @param array parameters to be bound to the query SQL statement.
     * @return int The number of rows effected.
     */
    public function update($id, $params=array())
    {
    }

    /**
     * Executes a Sql DELETE statement.  Delete returns the number of rows effected.
     *
     * The argument $params is generally used to supply the input
     * data for the WHERE clause parameter(s) of the DELETE statement.
     *
     * @param mixed query id or criteria.
     * If a string, it is treated as query id;
     * If an array, it is treated as the initial values for constructing a {@link CSqlMapCriteria} object;
     * Otherwise, it should be an instance of {@link CSqlMapCriteria}.
     * @param array parameters to be bound to the query SQL statement.
     * @return int The number of rows effected.
     */
    public function delete($id, $params=array())
    {
    }
}

/**
 * CSqlMapConfig providing caching for mapping configurations.
 *
 * @author Wei Zhuo <weizhuo@gmail.com>
 * @version $Id$
 * @package system.db.sqlmap
 * @since 1.1
 */
class CSqlMapConfig
{
    /**
     * Mapping configuration file extension.
     */
    const MAPPING_EXT='.php';

   /**
     * @var string base directory of the mapping configuration files.
     */
    public $basePath='.';

    /**
     * @var string default sqlmap mapping configuration file name.
     */
    public $defaultMappingFile='sqlmap';

    /**
     * @var array mapping configurations.
     */
    protected $_mappings=array();

    /**
     * @param string mapping file name without '.php' extension {@see MAPPING_EXT}.
     * @return string fullpath of the mapping file, returns default mapping file
     * if mapping file parameter is empty.
     */
    protected function getMappingFile($mapping=null)
    {
        if(empty($mapping))
            $mapping=$this->defaultMappingFile;
        return $this->basePath.DIRECTORY_SEPARATOR.$mapping.self::MAPPING_EXT;
    }

    /**
     * @param string mapping key of the form 'path.to.file.array_key'
     * where 'path.to.file' is a file named 'file' with '.php' extension and
     * is in the 'path.to' directory (replacing dots with directory separators)
     * relative to the {@see basePath} directory. If the file name is omitted
     * the default mapping configuration file name given by $defaultMappingFile
     * is used.
     * @return array array($file, $id) where $file is the mapping data file name
     * and $id as the array key.
     */
    public function resolveMappingKey($str)
    {
        $parts=explode('.', $str);
        $id=array_pop($parts);
        $file=$this->getMappingFile(implode(DIRECTORY_SEPARATOR, $parts));
        return array($file, $id);
    }

    /**
     * @param string mapping key, see {@link resolveMappingKey} for details.
     * @return array mapping data corresponding to the mapping key. Null if not exists.
     */
    public function getMappingById($str)
    {
        list($file, $id)=$this->resolveMappingKey($str);
        if(!isset($this->_mappings[$file]))
            $this->_mappings[$file]=include($file);
        if(isset($this->_mappings[$file][$id]))
            return $this->_mappings[$file][$id];
    }
}

/**
 * Base class for SqlMap exceptions.
 *
 * @author Wei Zhuo <weizhuo@gmail.com>
 * @version $Id$
 * @package system.db.sqlmap
 * @since 1.1
 */
class CSqlMapException extends CException 
{ 
}

/**
 * CSqlMapCriteria represent a mapping query criteria, such as mapping id,
 * parameters, limit and offset.
 *
 * @author Wei Zhuo <weizhuo@gmail.com>
 * @version $Id$
 * @package system.db.sqlmap
 * @since 1.1
 */
class CSqlMapCriteria
{
    /**
     * @var string the mapping key name. 
     * See {@link CSqlMapConfig::resolveMappingKey} for details.
     */
    public $id='';

    /**
     * @var array list of query parameter values indexed by parameter placeholders.
     * For example, <code>array(':name'=>'Dan', ':age'=>31)</code>.
     */
    public $params=array();

    /**
     * @var integer maximum number of records to be returned. If less than 0, 
     * it means no limit.
     */
    public $limit=-1;

    /**
     * @var integer zero-based offset from where the records are to be 
     * returned. If less than 0, it means starting from the beginning.
     */
    public $offset=-1;

    /**
     * Constructor.
     * @param array criteria initial property values (indexed by property name).
     */
    public function __construct($data=array())
    {
        foreach($data as $name=>$value)
            $this->$name=$value;
    }
}