<?php
class KWModel
{
    protected $_data;
    private $_cache = [];
    protected $_dirty = false;
    /**
     * @var baseDAO
     */
    protected $MD = null;
    protected $_pk;


    public function __get($key)
    {
        return isset($this->_data[$key]) ? $this->_data[$key] : null;
       /* if (substr($key, -7) == 'Service' || substr($key, -3) == 'DAO') {
            return TXFactory::create($key);
        }
        $data = array_merge($this->_data, $this->_cache);
        return isset($data[$key]) ? TXString::encode($data[$key]) : null;*/
    }

    public function _get($key)
    {
        $data = array_merge($this->_data, $this->_cache);
        return isset($data[$key]) ? $data[$key] : null;
    }

    public function __set($key, $value)
    {
        if (array_key_exists($key, $this->_data)){
            $this->_data[$key] = $value;
            $this->_dirty = true;
        } else {
            $this->_cache[$key] = $value;
        }
    }

    public function __isset($key)
    {
        return isset($this->_data[$key]) || isset($this->_cache[$key]);
    }

    public function save($data, $condition='')
    {
        if ($data && $this->MD){
            return $this->MD->where($condition ? : "id=$this->_pk")->update($data);
        };return false;
    }



    public function __toLogger()
    {
        return $this->_data;
    }

    /**
     * 是否含有
     * @return mixed
     */
    public function has($field, $value)
    {
        return $this->MD->where([$field=>$value])->find();
    }
    /**
     * 是否含有
     * @return mixed
     */
    public function notHas($field, $value)
    {
        return ! $this->MD->where([$field=>$value])->find();
    }

    /**
     * 是否存在
     * @return mixed
     */
    public function exist()
    {
        return $this->_data ? true : false;
    }

    /**
     * 获取键值
     * @return mixed
     */
    public function getPk()
    {
        return $this->_pk;
    }

    /**
     * 获取用户数据
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

}