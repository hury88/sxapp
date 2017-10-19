<?php
class Good extends KWModel
{
    const TABLE = 'goods';
    private static $_cache = [];

    protected $_data;
    /**
     * @var baseMD
     */
    protected $MD;
    protected $_pk;

    /**
     * @param null $id
     * @return Person
     */
    public static function get($id=null)
    {
        if (!isset(self::$_cache[$id])){
            self::$_cache[$id] = new self($id);
        }
        return self::$_cache[$id];
    }

    private function __construct($id)
    {
        $this->MD = M(self::TABLE);
        if ($id !== NULL){
            $this->_data = $this->MD->find($id);
            $this->_pk = $id;
        }
    }


}