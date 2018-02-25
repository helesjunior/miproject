<?php
/**
 * Created by PhpStorm.
 * User: heles.junior
 * Date: 22/02/2018
 * Time: 14:16
 */


namespace App\Table;
use Illuminate\Database\Eloquent\Builder;

class Table
{
    private $rows = [];
    private $columns = [];
    private $actions = [];
    private $actionsMore = [];
    private $filters = [];
    /**
     * @var Builder
     */
    private $model = null;
    private $modelOriginal = null;
    private $perPage = 10;
    public function paginate($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }
    public function rows()
    {
        return $this->rows;
    }
    public function model($model = null)
    {
        if (!$model) {
            return $this->model;
        }
        $this->model = !is_object($model) ? new $model : $model;
        $this->modelOriginal = clone $this->model;
        return $this;
    }
    public function filters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function columns($columns = null)
    {
        if (!$columns) {
            return $this->columns;
        }
        $this->columns = $columns;
        return $this;
    }

    public function actions()
    {
        return $this->actions;
    }

    public function actionsMore()
    {
        return $this->actionsMore;
    }

    public function addAction($label, $route, $template)
    {
        $this->actions[] = [
            'label' => $label,
            'route' => $route,
            'template' => $template
        ];
        return $this;
    }

    public function addActionMore($label, $route, $template)
    {
        $this->actionsMore[] = [
            'label' => $label,
            'route' => $route,
            'template' => $template
        ];
        return $this;
    }

    public function addEditAction($route)
    {
        $this->addAction('Editar', $route, 'vendor.adminlte.table.edit_action');
        return $this;
    }

    public function addShowAction($route)
    {
        $this->addAction('Ver', $route, 'vendor.adminlte.table.show_action');
        return $this;
    }

    public function addMoreAction(Array $items)
    {
        foreach($items as $i){
            $this->addActionMore($i['label'], $i['route'],'vendor.adminlte.table.more_action');
        };

        return $this;
    }

    public function addDeleteAction($route)
    {
        $this->addAction('Excluir', $route, 'vendor.adminlte.table.delete_action');
        return $this;
    }
    public function search()
    {
        $keyName = $this->modelOriginal->getKeyName();
        $columns = collect($this->columns())->pluck('name')->toArray();
        array_unshift($columns, $keyName);
        $this->applyFilters();
        $this->applyOrders();
        $this->perPage();
        $this->rows = $this->model->paginate($this->perPage, $columns);
        return $this;
    }

    protected function perPage(){
        if(\Request::has('perpage') and is_numeric(\Request::get('perpage'))){
            $perpage = \Request::get('perpage');
            if($perpage == 10){
                $this->perPage = 10;
            }elseif ($perpage == 20){
                $this->perPage = 20;
            }elseif ($perpage == 50){
                $this->perPage = 50;
            }elseif ($perpage == 100){
                $this->perPage = 100;
            }
        }
        return $this;
    }

    protected function applyFilters()
    {
        foreach ($this->filters as $filter) {
            $field = $filter['name'];
            $operator = $filter['operator'];
            $search = \Request::get('search');
            $search = strtolower($operator) === 'like' ? "%$search%" : $search;
            if(!strpos($filter['name'],'.')) {
                $this->model = $this->model->orWhere($field, $operator, $search);
            }else{
                list($relation,$field) = explode('.',$filter['name']);
                $this->model = $this->model->orWhereHas($relation, function($query) use($field,$operator,$search){
                    $query->where($field,$operator,$search);
                });
            }
            //WHERE campo = 'valor' OR campo = 'valor'
        }
    }
    protected function applyOrders(){
        $fieldOrderParam = \Request::get('field_order');
        $orderParam = \Request::get('order');
        foreach ($this->columns() as $key => $column){
            if($column['name'] === $fieldOrderParam && isset($column['order'])){
                $order = $orderParam =='desc'?'desc':'asc';
                $this->columns[$key]['_order']=$order;
                $this->model->orderBy("{$column['name']}",$order);
            }elseif(isset($column['order'])){
                $this->columns[$key]['_order']=$column['order'];
                if($column['order'] === 'asc' || $column['order']==='desc'){
                    $this->model->orderBy("{$column['name']}",$column['order']);
                }
            }
        }
    }
}