<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Requests;

use Illuminate\Http\Request;

/**
 * Description of DataTableRequest
 *
 * @author Sandy
 */
class DataTableRequest {

    protected $sColumns;

    /**
     * The current start position
     * @var integer
     */
    protected $displayStart;

    /**
     * The current display length
     * @var integer
     */
    protected $displayLength;

    /**
     * Array of current sort column indexes and directions
     * 
     * @var array
     */
    protected $sortColumns;

    /**
     * The search string
     * @var string
     */
    protected $search;

    /**
     * The 'sEcho' value that was passed in
     * @var integer
     */
    protected $echo;


    public function setDisplayStart($displayStart) {
        $this->displayStart = $displayStart;
    }

    public function getDisplayStart() {
        return $this->displayStart;
    }

    public function setDisplayLength($displayLength) {
        $this->displayLength = $displayLength;
    }

    public function getDisplayLength() {
        return $this->displayLength;
    }

    /**
     * Get the first sort column index
     * 
     * This method always returns the first column
     * index of the current sort column and should
     * be used when you only want to sort against one
     * column. Otherwise, you should use getSortColumns()
     * to get all of the sort column indexes and directions.
     * 
     * @return integer
     */
    public function getSortColumnIndex() {
        $keys = array_keys($this->sortColumns);
        return $keys[0];
    }

    /**
     * Get the first sort column direction
     * 
     * This method always returns the first column
     * sort direction of the current sort column and should
     * be used when you only want to sort against one
     * column. Otherwise, you should use getSortColumns()
     * to get all of the sort column indexes and directions.
     * 
     * @return string
     */
    public function getSortDirection() {
        $values = array_values($this->sortColumns);
        return $values[0];
    }

    /**
     * Get all of the current sort columns
     * 
     * This method will return an array containing
     * the column index as the key, and the sort
     * direction as the value.
     * 
     * Example:
     *   array(2 => 'asc', 3 => 'desc')
     *
     * @return array
     */
    public function getSortColumns() {
        return $this->sortColumns;
    }

    public function setSortColumns($sortColumns) {
        $this->sortColumns = $sortColumns;
    }

    public function setSearch($search) {
        $this->search = $search;
    }

    public function getSearch() {
        return $this->search;
    }

    public function hasSearch() {
        return !(is_null($this->search) || $this->search == '');
    }

    public function setEcho($echo) {
        $this->echo = $echo;
    }

    public function getEcho() {
        return $this->echo;
    }

    public function getSColumns() {
        return $this->sColumns;
    }

    public function setSColumns($sColumns) {
        $this->sColumns = $sColumns;
    }

   
    public function __construct(Request $request) {
        $this->setDisplayLength($request->input('iDisplayLength'));
        $this->setDisplayStart($request->input('iDisplayStart'));
        $this->setEcho($request->input('sEcho'));
        $this->setSColumns($request->input('sColumns'));

        if ($request->input('sSearch')) {
            $this->setSearch($request->input('sSearch'));
        }

        $num = $request->input('iSortingCols');

        $sortCols = array();

        for ($x = 0; $x < $num; $x++) {
            $sortCols[$request->input('iSortCol_' . $x)] = $request->input('sSortDir_' . $x);
        }

        $this->setSortColumns($sortCols);
    }

}
