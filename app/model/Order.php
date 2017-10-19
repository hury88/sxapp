<?php
class Order extends KWModel
{
    const TABLE = 'order';

    #支付方式 1payssion,2paypal
    const PAY_PAYSSION = 1;
    const PAY_PAYPAL   = 2;
    #支付状态
    const STATE_NEW_ORDER      = 0;// 新订单
    const STATE_COMPLETE       = 1;// 已完成
    const STATE_PAID_PARTIAL   = 2;// 部分支付
    const STATE_PENDING        = 3;// 支付处理中
    const STATE_FAILED         = 4;// 支付失败
    const STATE_EXPIRED        = 5;// 支付延迟
    const STATE_ERROR          = 6;// 支付出现错误

    private static $_cache = [];

    protected $_data;
    /**
     * @var baseMD
     */
    protected $MD;
    protected $_pk;

    /**
     * 添加订单操作日志
     * order_id int(11) NOT NULL COMMENT '订单id',
     * action varchar(255) NOT NULL DEFAULT '' COMMENT '动作内容',
     * uid int(11) NOT NULL DEFAULT 0 COMMENT '操作人id',
     * user_name varchar(50) NOT NULL DEFAULT '' COMMENT '操作人',
     * order_status int(11) NOT NULL COMMENT '订单大状态',
     * order_status_text varchar(255) NOT NULL DEFAULT '' COMMENT '订单状态名称',
     * action_time datetime NOT NULL COMMENT '操作时间',
     * PRIMARY KEY (action_id)
     *
     * @param unknown $order_id
     * @param unknown $uid
     * @param unknown $action_text
     */
    public function addOrderAction($order_id, $uid, $action_text)
    {
        $this->order->startTrans();
        try {
            $order_status = $this->order->getInfo([
                'order_id' => $order_id
            ], 'order_status');
            $user = new UserModel();
            $user_name = $user->getInfo([
                'uid' => $uid
            ], 'user_name');
            $data_log = array(
                'order_id' => $order_id,
                'action' => $action_text,
                'uid' => $uid,
                'user_name' => $user_name['user_name'],
                'order_status' => $order_status['order_status'],
                'order_status_text' => $this->getOrderStatusName($order_id),
                'action_time' => date("Y-m-d H:i:s", time())
            );
            $order_action = new NsOrderActionModel();
            $order_action->save($data_log);
            $this->order->commit();
            return $order_action->action_id;
        } catch (\Exception $e) {
            $this->order->rollback();
            return $e->getMessage();
        }
    }

    // 生成订单号
    public static function orderNo()
    {

    	do {
    		//生成订单号
    		$orderNo = time() . mt_rand(1000, 9999);
    		//去重
    		$findOrderNo = M(self::TABLE)->where(['orderno' => $orderNo])->getField('id');
    	} while ( $findOrderNo );

    	return $orderNo;
    }

    // 生成订单号
    public function count($condition)
    {
        return $this->MD->where($condition)->count();
    }



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
