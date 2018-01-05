<?php

namespace App\DataTables\Agents;

use App\User;
use Yajra\DataTables\Services\DataTable;

class AllDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', function ($model) {
                return '<a href="agent/details/'.$model->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        $agents =  User::withRole('agent')->get();

        foreach ($agents as $agent){
            $agent->registered_by_name = User::getNameFromId($agent->registered_by);
        }

        return $agents;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '80px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'email', 'name' => 'email', 'title' => 'Email'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'registered_by_name', 'name' => 'registered_by_name', 'title' => 'Registered By'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created On'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Agents\All_' . date('YmdHis');
    }
}
