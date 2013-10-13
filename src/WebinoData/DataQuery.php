<?php

namespace WebinoData;

class DataQuery
{
    protected $sql;
    protected $platform;

    public function __construct($sql, $platform)
    {
        $this->sql      = $sql;
        $this->platform = $platform;
    }

    public function toggle($column)
    {
        return new DataQuery\Toggle(
            $column,
            $this->sql->update(),
            $this->platform
        );
    }

    public function increment($column)
    {
        $query = new DataQuery\Increment(
            $column,
            $this->sql->update(),
            $this->platform
        );
        return $query;
    }

    public function decrement($column)
    {
        $query = new DataQuery\Decrement(
            $column,
            $this->sql->update(),
            $this->platform
        );
        return $query;
    }
}
