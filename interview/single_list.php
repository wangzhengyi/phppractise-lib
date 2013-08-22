<?php

/**
 * 用class模拟struct,实现链表节点定义
 */
class Node
{

    /**
     * 数据
     */
    public $data;

    /**
     * 下一个节点
     */
    public $next;

    public function __construct ($data, $next = null)
    {
        $this->data = $data;
        $this->next = $next;
    }
}

class LinkList
{

    public $head;

    public function __construct ()
    {
        $this->head = null;
    }

    /**
     * 尾插法实现链表插入操作
     *
     * @param int $value            
     */
    public function insertNode ($value)
    {
        $cur = $this->head;
        $pre = null;
        
        while ($cur != null) {
            $pre = $cur;
            $cur = $cur->next;
        }
        
        $new = new Node($value);
        $new->next = null;
        
        if ($pre == null) {
            $this->head = $new;
        } else {
            $pre->next = $new;
        }
    }

    /**
     * 单链表中删除指定节点
     *
     * @param int $value            
     */
    public function deleteNode ($value)
    {
        $cur = $this->head;
        $pre = null;
        
        while ($cur != null) {
            if ($cur->data == $value) {
                if ($pre == null) {
                    $this->head->next = $cur->next;
                } else {
                    $pre->next = $cur->next;
                }
                break;
            }
            $pre = $cur;
            $cur = $cur->next;
        }
    }

    /**
     * 打印单链表
     */
    public function printList ()
    {
        $cur = $this->head;
        while ($cur->next != null) {
            printf("%d ", $cur->data);
            $cur = $cur->next;
        }
        printf("%d\n", $cur->data);
    }
}

// 测试
$list = new LinkList();
$list->insertNode(1);
$list->insertNode(2);
$list->insertNode(3);
$list->insertNode(4);
$list->insertNode(5);
$list->insertNode(6);

$list->printList();

$list->deleteNode(4);
$list->printList();