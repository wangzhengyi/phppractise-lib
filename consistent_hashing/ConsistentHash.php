<?php

/**
 * 一致性哈希代码，参考链接：http://blog.csdn.net/mayongzhan
 * @author wzy
 *
 */
class ConsistentHash
{

    /**
     * The number of positions to hash each target to.
     *
     * @var int
     */
    private $_replicas = 64;

    /**
     * Internal counter for current number of targets.
     *
     * @var int
     */
    private $_targetCount = 0;

    /**
     * Internal map of positions (hash outputs) to targets.
     *
     * @var array {position => target,...}
     */
    private $_positionToTarget = array();

    /**
     * Internal map of targets to lists of positions that target is hashed to.
     *
     * @var array {target => [position, position,...], ...}
     */
    private $_targetToPositions = array();

    /**
     * Whether the internal map of positions to targets is already sorted.
     *
     * @var boolean
     */
    private $_positionToTargetSorted = false;

    /**
     * Constructor.
     *
     * @param int $replicas
     *            Amount of positions to hash each target to.
     */
    public function __construct ($replicas = null)
    {
        if (! empty($replicas)) {
            $this->_replicas = $replicas;
        }
    }

    /**
     * Add a target.
     *
     * @param string $target
     *            server ip
     * @param double $weight
     *            server weight
     */
    public function addTarget ($target, $weight = 1)
    {
        if (isset($this->_targetToPositions[$target])) {
            // 节点已经存在
            return;
        }
        
        $this->_targetToPositions[$target] = array();
        
        // 防止数据偏移，根据每台server的权重增加虚拟节点
        for ($i = 0; $i < round($this->_replicas * $weight); $i ++) {
            $position = crc32($target . '.' . $i);
            $this->_positionToTarget[$position] = $target;
            $this->_targetToPositions[$target][] = $position;
        }
        
        $this->_positionToTargetSorted = false;
        $this->_targetCount ++;
    }

    /**
     * Add a list of targets.
     *
     * @param array $targets
     *            [target => weight, ...]
     * @param double $weight            
     */
    public function addTargets ($targets)
    {
        foreach ($targets as $target => $weight) {
            $this->addTarget($target, $weight);
        }
    }

    /**
     * Remove a target
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
     * A list of all potential targets.
     *
     * @return array
     */
    public function getAllTargets ()
    {
        return array_keys($this->_targetToPositions);
    }

    /**
     * Get a list of targets for the resource, in order of precedence.
     * Up to $requestCount targets are returned, less if there are fewer in
     * total.
     *
     * @param string $resource            
     * @param int $requestCount
     *            The length of the list to return
     * @return array List of targets
     */
    public function lookupList ($resource, $requestCount)
    {
        // handle no targets
        if ($requestCount <= 0 || empty($this->_positionToTarget)) {
            return array();
        }
        
        // hash resource to a position
        $resourcePosition = crc32($resource);
        
        $results = array();
        $collect = false;
        
        $this->sortPositionTargets();
        
        // search targets above the resourcePosition
        foreach ($this->_positionToTarget as $key => $value) {
            // start collecting targets after passing resource position
            if (! $collect && $key > $resourcePosition) {
                $collect = true;
            }
            
            // only collect the first instance of any target
            if ($collect && ! in_array($value, $results)) {
                $results[] = $value;
            }
            
            // return when enough results, or list exhausted
            if (count($results) == $requestCount || count($results) == $this->_targetCount) {
                return $results;
            }
        }
        
        // loop to start, search targets below the resourcePosition
        // (ps:there is no position larger than resourcePosition)
        foreach ($this->_positionToTarget as $key => $value) {
            if (! in_array($value, $results)) {
                $results[] = $value;
            }
            
            // return when enough results, or list exhausted
            if (count($results) == $requestCount || count($results) == $this->_targetCount) {
                return $results;
            }
        }
        
        // return results after iterating through both "parts"
        return $results;
    }

    /**
     * sorts the internal mapping
     */
    private function sortPositionTargets ()
    {
        if (! $this->_positionToTargetSorted) {
            ksort($this->_positionToTarget, SORT_NUMERIC);
            
            $this->_positionToTargetSorted = true;
        }
    }
}

?>