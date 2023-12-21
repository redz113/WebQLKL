<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Filterable
{
    public function filterName($query, $value)
    {
        return $query->where('name', 'LIKE', '%' . $value . '%');
    }

    public function filterSort($query, $value)
    {
        $value = explode('-', $value);
        if (count($value) == 2) return $query->orderBy($value[0], $value[1]);
        return $query;
    }

    public function scopeFilter($query, $param)
    {
        foreach ($param as $field => $value) {
            $method = 'filter' . Str::studly($field);

            if ($value === '') {
                continue;
            }

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
                continue;
            }

            if (empty($this->filterable) || !is_array($this->filterable)) {
                continue;
            }

            if (in_array($field, $this->filterable)) {
                $query->where($this->table . '.' . $field, $value);
                continue;
            }

            if (key_exists($field, $this->filterable)) {
                $query->where($this->table . '.' . $this->filterable[$field], $value);
                continue;
            }
        }

        return $query;
    }
}
