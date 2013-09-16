<?php

/**
 * 一致性哈希代码，参考链接：http://blog.csdn.net/mayongzhan
 * @author wzy
 *
 */
class ConsistentHash
{

    /**
     * 虚拟节点数，解决节点分布不均匀问题
     *
     * @var int
     */
    private $_replicas = 64;

    /**
     * 节点计数器
     *
     * @var int
     */
    private $_targetCount = 0;

    /**
     * 位置对应节点，用于lookup中根据位置确认要访问的节点
     *
     * @var array {position => target,..}
     */
    private $_positionToTarget = array();

    /**
     * 节点对应位置，用于删除节点
     *
     * @var array {target => [position, position,..]}
     */
    private $_targetToPositions = array();

    /**
     * 排序标识
     *
     * @var boolean
     */
    private $_positionToTargetSorted = false;

    /**
     * 构造函数，采用crc32算法进行哈希分布，同时确认虚拟节点数（虚拟节点数越多，分布越均匀，但程序的分布式运算越慢）
     *
     * @param int $replicas            
     */
    public function __construct ($replicas)
    {
        if (! empty($replicas)) {
            $this->_replicas = $replicas;
        }
    }

    /**
     * 添加节点，根据虚拟节点数，将节点分布在多个位置上
     *
     * @param string $target
     *            服务器ip
     * @return ConsistentHash
     */
    public function addTarget ($target)
    {
        if (isset($this->_targetToPositions[$target])) {
            // 节点已经存在
            return;
        }
        
        $this->_targetToPositions[$target] = array();
        
        for ($i = 0; $i < $this->_replicas; $i ++) {
            $position = crc32($target . '.' . $i);
            $this->_positionToTarget[$position] = $target;
            $this->_targetToPositions[$target][] = $position;
        }
        
        $this->_positionToTargetSorted = false;
        $this->_targetCount ++;
    }

    /**
     * 增加多个节点
     *
     * @param array $targets            
     * @return ConsistentHash
     */
    public function addTargets ($targets)
    {
        foreach ($targets as $target) {
            $this->addTarget($target);
        }
    }

    /**
     * 删除单个节点
     *
     * @param string $target            
     */
    public function removeTarget ($target)
    {
        if (isset($this->_targetToPositions[$target])) {
            foreach ($this->_targetToPositions[$target] as $position) {
                unset($this->_positionToTarget[$position]);
            }
            
            unset($this->_targetToPositions[$target]);
            
            $this->_targetCount --;
        }
    }

    /**
     * 获取所有服务器节点
     *
     * @return multitype:
     */
    public function getAllTargets ()
    {
        return array_keys($this->_targetToPositions);
    }

    /**
     * 查找当前资源对应的节点
     *
     * @param string $resource            
     * @param count $requestCount            
     * @return array
     */
    public function lookupList ($resource, $requestCount)
    {
        // 没有虚拟节点
        if (empty($this->_positionToTarget)) {
            return array();
        }
        
        // hash resource to a position
        $resourcePosition = crc32($resource);
        
        $results = array();
        $collect = false;
        
        $this->_sortPositionTargets();
        
        // search values above the resourcePosition
        foreach ($this->_positionToTarget as $key => $value) {
            if (! $collect && $key > $resourcePosition) {
                $collect = true;
            }
            
            if ($collect && ! in_array($value, $results)) {
                $results[] = $value;
            }
            
            if (count($results) == $requestCount || count($results) > $this->_targetCount) {
                return $results;
            }
        }
        
        return $results;
    }

    /**
     * sorts the internal mapping
     */
    private function _sortPositionTargets ()
    {
        if (! $this->_positionToTargetSorted) {
            ksort($this->_positionToTarget, SORT_NUMERIC);
            $this->_positionToTargetSorted = true;
        }
    }
}

?>