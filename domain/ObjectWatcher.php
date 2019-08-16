<?php

namespace woo\domain;

class ObjectWatcher
{
    private $all = [];
    private $dirty = [];
    private $new = [];
    private $delete = [];

    private static $instance;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function instance()
    {
        if (! self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @param DomainObject $domainObject
     * @return string
     */
    public function globalKey(DomainObject $domainObject)
    {
        return get_class($domainObject) . "." . $domainObject->getId();
    }

    /**
     * @param DomainObject $domainObject
     */
    static function add(DomainObject $domainObject)
    {
        $instance = self::instance();
        $instance->all[$instance->globalKey($domainObject)] = $domainObject;
    }

    /**
     * @param DomainObject $object
     */
    static function addDelete(DomainObject $object)
    {
        $instance = self::instance();
        $instance->delete[$instance->globalKey($object)] = $object;
    }

    /**
     * @param DomainObject $object
     */
    static function addNew(DomainObject $object)
    {
        $instance = self::instance();
        $instance->new[] = $object;
    }

    /**
     * @param DomainObject $object
     */
    static function addDirty(DomainObject $object)
    {
        $instance = self::instance();
        if (! in_array($object, $instance->dirty, true)) {
            $instance->dirty[$instance->globalKey($object)] = $object;
        }
    }

    /**
     * @param DomainObject $object
     */
    static function addClean(DomainObject $object)
    {
        $instance = self::instance();

        unset($instance->delete[$instance->globalKey($object)]);
        unset($instance->dirty[$instance->globalKey($object)]);
        $instance->new = array_filter($instance->new, function ($a) use ($object) { return ! ($a == $object); });
    }

    /**
     * 完成操作
     */
    public function performOperations()
    {
        /* @var DomainObject $object */
        foreach ($this->new as $key => $object) {
            $object->finder()->insert($object);
        }

        $this->new = [];

        foreach ($this->dirty as $key => $object) {
            $object->finder()->update($object);
        }

        $this->dirty = [];
    }

    public function printAll()
    {
        print_r($this->new);
        print_r($this->dirty);
        print_r($this->delete);
        print_r($this->all);
    }

    /**
     * @param $classname
     * @param $id
     * @return DomainObject
     */
    static function exists($classname, $id)
    {
        $instance = self::instance();

        $key = $classname . '.' . $id;

        return array_key_exists($key, $instance->all) ? $instance->all[$key] : null;
    }
}