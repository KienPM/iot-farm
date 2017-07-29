<?php

namespace App\Core\QueryFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    /**
     * The query builder instance.
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Filtering conditions.
     *
     * @var array
     */
    protected $conditions;

    /**
     * Optional filtering arguments.
     *
     * @var array
     */
    protected $arguments;

    /**
     * @param Request
     */
    public function __construct(Request $request)
    {
        $this->conditions = $request->all();
    }

    /**
     * Filter model instances according to given filtering conditions.
     *
     * @return void
     */
    abstract public function filter();

    /**
     * Sets the value of builder.
     *
     * @param mixed $builder the builder
     *
     * @return self
     */
    protected function setBuilder($builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Gets the value of builder.
     *
     * @return mixed
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Apply filters to the given Eloquent builder.
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->setBuilder($builder);

        $this->filter();

        return $this->getBuilder();
    }

    /**
     * Sets the Filtering conditions.
     *
     * @param array $conditions the conditions
     *
     * @return self
     */
    public function setConditions(array $conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Gets the Filtering conditions.
     *
     * @return array
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Get filter attribute value.
     *
     * @param  string $key
     * @return mixed
     */
    public function getFilterValue($key)
    {
        $conditions = $this->getConditions();
        return isset($conditions[$key]) ? $conditions[$key] : null;
    }

    /**
     * Sets the value of arguments.
     *
     * @param array $arguments the arguments
     *
     * @return self
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    /**
     * Gets the value of arguments.
     *
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    public function getArgumentValue($key)
    {
        $arguments = $this->getArguments();

        return empty($arguments[$key]) ? null : $arguments[$key];
    }
}
