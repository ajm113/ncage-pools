<?php

namespace App;

class QueryOptionsBuilder
{
    /*
     * Front-Facing Options We Usually Create In Controller.
     */
    protected $filter = [];
    protected $sortBy = [];
    protected $limit = 1;
    protected $enableCache = true;

    /*
     * Back-Facing Options We Usually Create In Model.
     * Usually let's the programmer know the supplied params
     * aren't valid to help avoid errors.
     */
    protected $filterScheme = [];
    protected $sortByScheme = [];

    /*
     * Front-Facing Setters for our Controllers.
     */

    /**
     * Sets the filter for our model query.
     *
     * @return void
     */
    public function setFilter(array $filter)
    {
        $this->filter = $filter;
    }

    /**
     * Set's the limit for Larevel.
     *
     * @return void
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * Sets the sort by for our model query.
     *
     * @return void
     */
    public function setSortBy(array $sortBy)
    {
        $this->sortBy = $sortBy;
    }

    /**
     * Enables cache for our model query.
     *
     * @return void
     */
    public function setEnableCache(bool $enable)
    {
        $this->enableCache = $enable;
    }

    /*
     * Back-Facing Setters for our Models.
     */

    /**
     * Set the filter scheme for our model query.
     *
     * @return void
     */
    public function setFilterScheme(array $filter)
    {
        $this->filterScheme = $filter;
    }

    /**
     * Set the sort by scheme for our model query.
     *
     * @return void
     */
    public function setSortByScheme(array $sortBy)
    {
        $this->sortByScheme = $sortBy;
    }

    /*
     * Back/Front-Facing Getters
     */

    /**
     * Get our filter options.
     *
     * @return array
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Get our limit.
     *
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get our filter item. If it does not exist, null is returned.
     *
     * @return mixed|null
     */
    public function getFilterItem($name)
    {
        return (isset($this->filter[$name])) ? $this->filter[$name] : null;
    }

    /**
     * Get our sort by options.
     *
     * @return array
     */
    public function getSortBy()
    {
        return $this->sortBy;
    }

    /**
     * Check if cache is enables.
     *
     * @return bool
     */
    public function getEnableCache()
    {
        return $this->enableCache;
    }

    /**
     * Get filter sceheme.
     *
     * @return array
     */
    public function getFilterScheme()
    {
        return $this->filterScheme;
    }

    /**
     * Get sort by sceheme.
     *
     * @return array
     */
    public function getSortByScheme()
    {
        return $this->sortByScheme;
    }

    /**
     * Checks for any mismatch with keys from
     * any of the supplied schemes from model or controller.
     * Throws exception if mismatch found. Simply returns true
     * if no errors found.
     *
     * @return boolean
     */
    public function check()
    {
        // Compare our filter scheme.
        foreach ($this->getFilter() as $key => $value)
        {
            if(!in_array($key, $this->getFilterScheme()))
                throw new InvalidArgumentException("The supplied filter '$key' does not exist inside supplied filter scheme!");
        }

        // Compare our sort by scheme.
        if($this->getSortBy())
        {
            if(!in_array($this->getSortBy()[0], $this->getSortByScheme()))
                throw new InvalidArgumentException("The supplied sort by '" . $this->getSortBy()[0] .
                    "' does not exist inside supplied sort by scheme!");
        }

        return true;
    }
}
