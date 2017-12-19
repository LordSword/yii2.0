<?php
/**
 * Created by PhpStorm.
 * User: jun
 * Date: 2017/6/9
 * Time: 13:43
 */
namespace common\components;

use yii\base\Component;


class Sms extends Component
{

    public $appid;

    public $servers;

    private $_smsService;

    public function init()
    {
        parent::init();
        RpcClient::config($this->servers, $this->appid);
        $smsService = RpcClient::instance('sms');
        $this->_smsService = $smsService;
    }

    public function __call($name, $params)
    {
        return call_user_func_array([$this->_smsService, $name], $params);
    }



}



class RpcClient
{
    /**
     * 发送数据和接收数据的超时时间  单位S
     * @var integer
     */
    const TIME_OUT = 5;

    /**
     * 异步调用发送数据前缀
     * @var string
     */
    const ASYNC_SEND_PREFIX = 'asend_';

    /**
     * 异步调用接收数据
     * @var string
     */
    const ASYNC_RECV_PREFIX = 'arecv_';

    /**
     * 服务端地址
     * @var array
     */
    protected static $addressArray = array();


    /**
     * appid
     * @var string
     */
    protected static $appid = '';

    /**
     * 异步调用实例
     * @var string
     */
    protected static $asyncInstances = array();

    /**
     * 同步调用实例
     * @var string
     */
    protected static $instances = array();

    /**
     * 到服务端的socket连接
     * @var resource
     */
    protected $connection = null;

    /**
     * 实例的服务名
     * @var string
     */
    protected $serviceName = '';

    /**
     * 设置/获取服务端地址
     * @param array $address_array
     */
    public static function config($address_array = array(), $appid = '')
    {
        if (!empty($address_array)) {
            self::$addressArray = $address_array;
        }
        if (!empty($appid)) {
            self::$appid = $appid;
        }
    }

    /**
     * 获取一个实例
     * @param string $service_name
     * @return instance of RpcClient
     */
    public static function instance($service_name)
    {
        if (!isset(self::$instances[$service_name])) {
            self::$instances[$service_name] = new self($service_name);
        }
        return self::$instances[$service_name];
    }

    /**
     * 构造函数
     * @param string $service_name
     */
    protected function __construct($service_name)
    {
        $this->serviceName = $service_name;
    }

    /**
     * 调用
     * @param string $method
     * @param array $arguments
     * @throws Exception
     * @return
     */
    public function __call($method, $arguments)
    {
        // 判断是否是异步发送
        if (0 === strpos($method, self::ASYNC_SEND_PREFIX)) {
            $real_method = substr($method, strlen(self::ASYNC_SEND_PREFIX));
            $instance_key = $real_method . serialize($arguments);
            if (isset(self::$asyncInstances[$instance_key])) {
                throw new \Exception($this->serviceName . "->$method(" . implode(',', $arguments) . ") have already been called");
            }
            self::$asyncInstances[$instance_key] = new self($this->serviceName);
            return self::$asyncInstances[$instance_key]->sendData($real_method, $arguments);
        }
        // 如果是异步接受数据
        if (0 === strpos($method, self::ASYNC_RECV_PREFIX)) {
            $real_method = substr($method, strlen(self::ASYNC_RECV_PREFIX));
            $instance_key = $real_method . serialize($arguments);
            if (!isset(self::$asyncInstances[$instance_key])) {
                throw new \Exception($this->serviceName . "->asend_$real_method(" . implode(',', $arguments) . ") have not been called");
            }
            $tmp = self::$asyncInstances[$instance_key];
            unset(self::$asyncInstances[$instance_key]);
            return $tmp->recvData();
        }
        // 同步发送接收
        $this->sendData($method, $arguments);
        return $this->recvData();
    }

    /**
     * 发送数据给服务端
     * @param string $method
     * @param array $arguments
     */
    public function sendData($method, $arguments)
    {
        $this->openConnection();
        $bin_data = JsonProtocol::encode(array(
            'class' => $this->serviceName,
            'method' => $method,
            'params' => $arguments,
            'appid' => self::$appid,
        ));
        if (fwrite($this->connection, $bin_data) !== strlen($bin_data)) {
            throw new \Exception('Can not send data');
        }
        return true;
    }

    /**
     * 从服务端接收数据
     * @throws Exception
     */
    public function recvData()
    {
        $ret = fgets($this->connection);
        $this->closeConnection();
        if (!$ret) {
            throw new \Exception("recvData empty");
        }
        return JsonProtocol::decode($ret);
    }

    /**
     * 打开到服务端的连接
     * @return void
     */
    protected function openConnection()
    {
        $address = self::$addressArray[array_rand(self::$addressArray)];
        $this->connection = stream_socket_client($address, $err_no, $err_msg);
        if (!$this->connection) {
            throw new \Exception("can not connect to $address , $err_no:$err_msg");
        }
        stream_set_blocking($this->connection, true);
        stream_set_timeout($this->connection, self::TIME_OUT);
    }

    /**
     * 关闭到服务端的连接
     * @return void
     */
    protected function closeConnection()
    {
        fclose($this->connection);
        $this->connection = null;
    }
}


/**
 * RPC 协议解析 相关
 * 协议格式为 [json字符串\n]
 * @author walkor <worker-man@qq.com>
 * */
class JsonProtocol
{
    /**
     * 从socket缓冲区中预读长度
     * @var integer
     */
    const PRREAD_LENGTH = 87380;

    /**
     * 判断数据包是否接收完整
     * @param string $bin_data
     * @param mixed $data
     * @return integer 0代表接收完毕，大于0代表还要接收数据
     */
    public static function dealInput($bin_data)
    {
        $bin_data_length = strlen($bin_data);
        // 判断最后一个字符是否为\n，\n代表一个数据包的结束
        if ($bin_data[$bin_data_length - 1] != "\n") {
            // 再读
            return self::PRREAD_LENGTH;
        }
        return 0;
    }

    /**
     * 将数据打包成Rpc协议数据
     * @param mixed $data
     * @return string
     */
    public static function encode($data)
    {
        return json_encode($data) . "\n";
    }

    /**
     * 解析Rpc协议数据
     * @param string $bin_data
     * @return mixed
     */
    public static function decode($bin_data)
    {
        return json_decode(trim($bin_data), true);
    }
}