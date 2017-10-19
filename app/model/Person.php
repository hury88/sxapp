<?php
class Person extends KWModel
{
    const TABLE = 'usr';
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
        $id = $id ?: self::getUserId();
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

    /**
     * 获取用户Id
     */
    public static function getUserId()
    {
        $rand = cookie('KWPSID');
        $userId = cookie('userId');
        if ($rand && $userId) {
            list($id, $md5md5) = explode('|',$userId, 2);
            if ($md5md5 == md5($id.md5($rand))) {
                return $id;
            } else {
                cookie('KWPSID', null);
                cookie('userId', null);
            }
        }
        return null;
    }
    /**
     * 设置用户Id
     */
    public static function setUserId($id)
    {
        $rand = rand();
        cookie('KWPSID', $rand);
        cookie('userId', $id . '|' . md5($id.md5($rand)) );
    }

    /**
     * 登录
     */
    public function login()
    {
        $data  = [
            'lastloginip'    => Request::instance()->ip(),
            'lastlogintime'  => time(),
            'logtimes' => ['exp', 'logtimes+1'],
        ];
        $result =  $this->MD->where(['id' => $this->_pk])->update($data);

        self::setUserId($this->_pk);
    }

    /**
     * 登出
     */
    public function loginOut()
    {
        self::setUserId(null);
    }
}