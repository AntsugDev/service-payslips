<?php

namespace App\Http\Api\Core\Filters;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Api\Core\Exceptions\Client\BadRequestException;
use App\Http\Api\Core\Exceptions\Filters\InvalidFilterException;
use App\Http\Api\Core\Exceptions\Filters\InvalidOperatorException;
use App\Http\Api\Core\Exceptions\Includes\InvalidIncludeException;
use App\Http\Api\Core\Exceptions\Filters\InvalidFilterValueException;
use App\Http\Api\Core\Exceptions\Filters\InvalidSortingMethodException;
use App\Http\Api\Core\Exceptions\Filters\InvalidOperatorForFilterException;
use App\Http\Api\Core\Exceptions\Filters\InvalidArrayValueForFilterException;

/**
 * Class QueryFilters
 * @package App\Http\Api\Core\Filters
 *
 */
abstract class QueryFilters
{

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder $builder ;
     */
    protected $builder;

    /**
     * @var array
     */
    protected static $operator_to_symbol = array(
        "eq" => "=",
        "gt" => ">",
        "ge" => ">=",
        "lt" => "<",
        "le" => "<=",
        "lk" => "like"
    );

    /**
     * @var string
     */
    protected static $array_value_delimiter = ",";

    /**
     * @return array
     */
    public abstract function allowed_filters(): array;

    /**
     * @return array
     */
    public abstract function allowed_sorts(): array;

    /**
     * @return array
     */
    public abstract function allowed_includes(): array;

    /**
     * An array representing that relationships that cannot be loaded through eloquent 'load' or 'with' method.
     * @return array
     */
    public function method_includes(): array
    {
        return [];
    }

    /**
     * @var array includes
     */
    private $includes = [];

    /**
     * @var string
     */
    protected static $default_ordering = "asc";

    /**
     * @var null
     */
    private static $per_page = null;

    /**
     * @var int
     */
    private static $page = 1;

    /**
     * @return string
     */
    public function get_default_ordering()
    {
        return self::$default_ordering;
    }

    /**
     * @return int|null
     */
    public function get_per_page()
    {
        return is_null(self::$per_page) ? $this->builder->count() : self::$per_page;
    }

    /**
     * @return int
     */
    public function get_page()
    {
        return $this::$page;
    }

    /**
     * @return array
     * @throws InvalidIncludeException
     */
    public function get_includes()
    {
        if (empty($this->includes) && !empty($this->request->query('includes')))
            $this->load_includes($this->request->query('includes'));
        return $this->includes;
    }

    /**
     * @param $order_field
     *
     * @return array
     */
    protected function parse_order($order_field)
    {
        switch (substr($order_field, 0, 1)) {
            case "-":
                return [substr($order_field, 1) => 'desc'];
            case ' ':
                return [substr($order_field, 1) => 'asc'];
            default:
                return [$order_field => $this->get_default_ordering()];
        }
    }

    /**
     * @param String $values
     *
     * @return Builder
     */
    public function sort(string $values)
    {
        collect(explode(",", $values))
            ->mapWithKeys(function ($v) {
                return $this->parse_order($v);
            })
            ->map(function (string $order, string $field) {
                if (!in_array($field, $this->allowed_sorts()))
                    throw new InvalidSortingMethodException($field, $this->allowed_sorts());
                return $this->builder->orderBy($field, $order);
            });
        return $this->builder;
    }

    /**
     * @param String $values
     *
     * @return Builder
     * @throws InvalidArrayValueForFilterException
     * @throws InvalidFilterValueException
     */
    public function page(string $values)
    {
        $values = explode(",", $values);
        if (count($values) > 1)
            throw new InvalidArrayValueForFilterException('page', $values);

        $value = intval($values[0]);
        if ($value === 0)
            throw new InvalidFilterValueException('page', $values);

        self::$page = $value;

        return $this->builder;
    }

    /**
     * @param string $includes
     *
     * @return Builder
     */
    public function includes(string $includes)
    {
        return $this->builder;
    }

    /**
     * @param string $includes
     *
     * @throws InvalidIncludeException
     */
    private function load_includes(string $includes)
    {
        $includes = explode(",", $includes);
        foreach ($includes as $include) {
            if (!in_array($include, $this->allowed_includes()))
                throw new InvalidIncludeException($include, $this->allowed_includes());
            if (!in_array($include, $this->method_includes()))
                array_push($this->includes, $include);
            if (in_array($include, $this->method_includes()))
                $this->includes = array_merge($this->includes, call_user_func([$this, $include]));
        }
    }

    /**
     * @param String $values
     *
     * @return Builder
     * @throws InvalidArrayValueForFilterException
     * @throws InvalidFilterValueException
     */
    public function limit(string $values)
    {
        $values = explode(",", $values);
        if (count($values) > 1)
            throw new InvalidArrayValueForFilterException('limit', $values);

        $value = intval($values[0]);
        if ($value === 0)
            throw new InvalidFilterValueException('limit', $values);

        self::$per_page = $value;

        return $this->builder;
    }

    /**
     * @return String
     */
    public static function getArrayValueDelimiter()
    {
        return self::$array_value_delimiter;
    }

    /**
     * @param String $filter_and_operator
     *
     * @return mixed
     * @throws InvalidFilterException
     */
    private function parse_filter(String $filter_and_operator)
    {
        $filter = explode(":", $filter_and_operator);
        if (count($filter) > 2)
            throw new InvalidFilterException($filter_and_operator, $this->allowed_filters());
        return $filter[0];
    }

    /**
     * @param String $filter_and_operator
     *
     * @return String
     */
    protected function parse_operator(String $filter_and_operator)
    {
        $filter = explode(":", $filter_and_operator);
        return (count($filter) == 1) ? "eq" : $filter[1];
    }

    /**
     * @param $value
     *
     * @return array|bool
     */
    protected function parse_filter_value($value)
    {
        if (is_array($value)) {
            return collect($value)
                ->map(function ($valueValue) {
                    return $this->parse_filter_value($valueValue);
                })
                ->all();
        }

        if (Str::contains($value, static::getArrayValueDelimiter()))
            return explode(static::getArrayValueDelimiter(), $value);

        if ($value === 'true')
            return true;

        if ($value === 'false')
            return false;

        return $value;
    }

    /**
     * @param String $filter
     * @param String $value
     * @param String $operator
     *
     * @return Builder
     * @throws InvalidOperatorForFilterException
     * @throws InvalidOperatorException
     */
    private function standard_filter($filter, $value, $operator)
    {
        $parsed_values = $this->parse_filter_value($value);
        if (is_array($parsed_values)) { // ["banana", "mela", "kiwi"]
            if ($operator === "eq")
                return $this->builder->whereIn($filter, $parsed_values);
            elseif ($operator === "lk") {
                $parsed_values = array_map(function ($v) {
                    return "%${v}%";
                }, $parsed_values);
                return $this->builder->where(function ($sub_query) use ($filter, $operator, $parsed_values) {
                    foreach ($parsed_values as $parsed_value)
                        $sub_query->orWhere($filter, $this->get_symbol_for_operator($operator), $parsed_value);
                });
            } else
                throw new InvalidOperatorForFilterException($operator, $filter, ["eq"]);
        }
        if ($operator === "lk")
            $value = "%{$value}%";
        return $this->builder->where($filter, $this->get_symbol_for_operator($operator), $value);
    }

    /**
     * QueryFilter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param null $param_name
     *
     * @return array|string|null
     */
    public function filters($param_name = null)
    {
        return $this->request->query($param_name);
    }

    /**
     * @return array
     */
    public static function get_operators()
    {
        return array_keys(self::get_operators());
    }

    /**
     * @param $operator
     *
     * @return String
     * @throws InvalidOperatorException
     */
    public function get_symbol_for_operator($operator)
    {
        if (!array_key_exists($operator, self::$operator_to_symbol)) {
            throw new InvalidOperatorException($operator, array_keys(self::$operator_to_symbol));
        }
        return self::$operator_to_symbol[$operator];
    }

    protected function filter_transformers()
    {
        return [];
    }

    protected function transform_filter($filter)
    {
        foreach ($this->filter_transformers() as $filter_value => $transform) {
            if (Str::startsWith($filter, $filter_value))
                return Str::replaceFirst($filter_value, $transform, $filter);
        }
        return $filter;
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     * @throws BadRequestException
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        foreach ($this->filters() as $filter_and_operator => $value) {
            $filter = $this->parse_filter($filter_and_operator);
            $operator = $this->parse_operator($filter_and_operator);
            if (method_exists($this, $filter))
                call_user_func_array([$this, $filter], array_filter([$value, $operator]));
            else if (in_array($filter, $this->allowed_filters())) {
                $filter = $this->transform_filter($filter);
                $this->standard_filter($filter, $value, $operator);
            } else
                throw new InvalidFilterException($filter, $this->allowed_filters());
        }
        return $this->builder;
    }

}
