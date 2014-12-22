<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/21/14
 * Time: 2:40 PM
 */

namespace ODataQuery\Parameter;


use ODataQuery\ODataQueryOptionInterface;

class ODataQueryParameterCollection implements \Countable, \OuterIterator, ODataQueryOptionInterface {
    private $collection;

    public function __construct($items = NULL) {
        $this->collection = new \ArrayObject($items);
    }

    public function count() {
        return $this->collection->count();
    }

    public function getInnerIterator() {
        return $this->collection->getIterator();
    }

    public function valid() {
        return $this->collection->getIterator()->valid();
    }

    public function current() {
        return $this->collection->getIterator()->count();
    }

    public function rewind() {
        $this->collection->getIterator()->rewind();
    }

    public function next() {
        $this->collection->getIterator()->next();
    }

    public function key() {
        return $this->collection->getIterator()->key();
    }

    public function build() {
        $build = array();
        foreach ($this->collection as $name => $param) {
            if (is_object($param) || is_array($param)) {
                $param = (array)$param;
                $build[$name] = '['.implode(",", $param).']';
            }
            else {
                $build[$name] = $param;
            }
        }
        return $build;
    }

    public function __toString() {
        $build = $this->build();
        return http_build_query($build);
    }

    public function __set($name, $value) {
        $this->collection['@'.$name] = $value;
    }

    public function __get($name) {
        return $this->collection['@'.$name];
    }

}