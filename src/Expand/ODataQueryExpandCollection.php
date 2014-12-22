<?php
/**
 * Created by PhpStorm.
 * User: alexboyce
 * Date: 12/21/14
 * Time: 11:42 PM
 */

namespace ODataQuery\Expand;


use ODataQuery\ODataQueryOptionInterface;
use ODataQuery\ODataResourceInterface;

class ODataQueryExpandCollection implements ODataExpandableInterface, ODataQueryOptionInterface {
    private $collection = array();
    public function __construct(array $collection = NULL) {
        if (isset($collection)) {
            foreach ($collection as $item) {
                if ($item instanceof ODataResourceInterface) {
                    $this->add($item);
                }
            }
        }
    }

    public function add(ODataQueryExpand $item) {
        $name = $item->property();
        $this->collection[$name] = $item;
        return $this;
    }

    public function remove(ODataQueryExpand $item) {
        $name = $item->property();
        unset($this->collection[$name]);
        return $this;
    }

    public function get($property = NULL) {
        return isset($property) ? $this->collection[$property] : $this->collection;
    }

    public function __toString() {
        return implode(",", $this->collection);
    }
}