<?php

namespace App\DataTables\Accounts;

use App\User;
use Yajra\DataTables\Services\DataTable;

class UnapprovedDataTable extends DataTable
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
                return '<a href="details/'.$model->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
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
        $users =  User::where([['status', '=', 'active'], ['approved', '=', null]])->withRole('customer')->get();

        foreach ($users as $user){

            $user->registered_by_name = User::getNameFromId($user->registered_by);
            $user->mobile = $user->borrowerPersonalDetails()->first()->mobile;
            $user->account = $user->borrowerPersonalDetails()->first()->account;
        }

        return $users;
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
            [
                'name' => 'account',
                'title' => 'Account No.',
                'data' => 'account'
            ],
            [
                'name' => 'name',
                'title' => 'Name',
                'data' => 'name'
            ],
            [
                'name' => 'email',
                'title' => 'Email',
                'data' => 'email'
            ],
            [
                'name' => 'mobile',
                'title' => 'Mobile No.',
                'data' => 'mobile'
            ],
            [
                'name' => 'registered_by_name',
                'title' => 'Registered By',
                'data' => 'registered_by_name'
            ],
            [
                'name' => 'created_at',
                'title' => 'Registered On',
                'data' => 'created_at'
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Accounts\Unapproved_' . date('YmdHis');
    }
}
