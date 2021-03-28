<?php
class MinHeap {
    private $arr = array();
    private $root;

    public function push(int $val) {
        $this->arr[] = $val;
        $this->bubbleUp();
    }
    public function pop(): ?int {
        if (count($this->arr) === 0) {
            return null;
        }
        // we alwasy pop the first node in min-heap
        $root = array_shift($this->arr);
        $this->bubbleDn();

        return $root;
    }

    public static function popWithoutRemoving(): ?array {
        return $this->arr[0];
    }

    public function query(int $job_id): ?array {
        if (in_array($job_id, $this->arr)) {
            return $this->arr[$job_id];
        } else {
            return null;
        }
    }    

    private function bubbleUp() {
        $index = count($this->arr) - 1;
        while ($index > 0 && $this->arr[$index] < $this->arr[$this->parentIndex($index)]) {
            $this->swap($index, $this->parentIndex($index));
            $index = $this->parentIndex($index);
        }
    }

    private function bubbleDn() {
        $index = 0;
        while ($index <= count($this->arr) - 1 && !$this->isValidParent($index)) {
            $largest_child_index = $this->getSmallestChildIndex($index);
            $this->swap($index, $largest_child_index);
            $index = $largest_child_index;
        }
    }


    private function swap($i, $j) {
        $temp = $this->arr[$i];
        $this->arr[$i] = $this->arr[$j];
        $this->arr[$j] = $temp;
    }

    private function parentIndex(int $index): int{
        return ($index - 1) / 2;
    }
    private function leftChild(int $index): int{
        return $this->arr[$index * 2 + 1];
    }
    private function rightChild(int $index): int{
        return $this->arr[$index * 2 + 2]; 
    }
    private function isValidParent(int $index) {
        return $this->arr[$index] < $this->leftChild($index) &&
        $this->arr[$index] < $this->rightChild($index);
    }
    private function getLeftChildIndex(int $index) {
        return $index * 2 + 1;
    }
    private function getRightChildIndex(int $index) {
        return $index * 2 + 2;
    }
    private function hasLeftChild($index) {
        return  $this->getLeftChildIndex($index) <= count($this->arr) - 1;
    }
    private function hasRightChild($index) {
        return  $this->getRightChildIndex($index) <= count($this->arr) - 1;
    }

    private function getSmallestChildIndex(int $index) {
        if (!$this->hasLeftChild($index)) {
            return $index;
        }
        if (!$this->hasRightChild($index)) {
            return $this->getLeftChildIndex($index);
        }

        return $this->leftChild($index) < $this->rightChild($index) ? 
               $this->getLeftChildIndex($index) :
               $this->getRightChildIndex($index);
    }


    public function getVals() {
        return $this->arr;
    }


}