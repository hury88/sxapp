<?php
class KWFactory
{
    /**
     * 对象列表
     *
     * @var array
     */
    private static $objects = [];

    /**
     * dynamic create object
     * @param string $class
     * @param string $alias
     * @return TXSingleDAO | mixed
     */
    public static function create($class, $alias=null)
    {
        if (null === $alias) {
            $alias = $class;
        }
        if (!isset(self::$objects[$alias])) {
            if (substr($class, -5) == 'Model') {
                $key = substr($class, 0, -5);
                self::$objects[$alias] = M(strtoupper($key));
            } else {
                self::$objects[$alias] = new $class();
            }
        }

        return self::$objects[$alias];
    }
}
