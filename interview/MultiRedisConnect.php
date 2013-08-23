<?php

class MultiRedisConnect
{

    /**
     * hostname
     *
     * @var string
     */
    const REDISHOSTNAME = "127.0.0.1";

    /**
     * port
     *
     * @var int
     */
    const REDISPORT = 6379;

    /**
     * timeout
     *
     * @var int
     */
    const REDISTIMEOUT = 0;

    /**
     * password
     *
     * @var string
     */
    const REDISPASSWORD = "123456";

    /**
     * 类单例数组
     *
     * @var array
     */
    private static $instance = array();

    /**
     * redis连接句柄
     *
     * @var object
     */
    private $redis;

    /**
     * hash的key
     *
     * @var int
     */
    private $hash;

    /**
     * 私有化构造函数,防止类外实例化
     *
     * @param int $dbnumber            
     */
    private function __construct ($dbnumber)
    {
        $dbnumber = (int) $dbnumber;
        $this->hash = $dbnumber;
        $this->redis = new Redis();
        $this->redis->connect(self::REDISHOSTNAME, self::REDISPORT, self::REDISTIMEOUT);
        $this->redis->auth(self::REDISPASSWORD);
        $this->redis->select($dbnumber);
    }

    private function __clone ()
    {}

    /**
     * 获取类单例
     *
     * @param int $dbnumber            
     * @return object
     */
    public static function getRedisInstance ($dbnumber)
    {
        $hash = (int) $dbnumber;
        
        if (! isset(self::$instance[$hash])) {
            self::$instance[$hash] = new MultiRedisConnect($dbnumber);
        }
        
        return self::$instance[$hash];
    }

    /**
     * 获取redis的连接实例
     *
     * @return object
     */
    public function getRedisConnect ()
    {
        return $this->redis;
    }

    /**
     * 关闭单例时做清理工作
     */
    public function __destruct ()
    {
        $key = $this->hash;
        self::$instances[$key]->redis->close();
        self::$instances[$key] = null;
    }
}

?>