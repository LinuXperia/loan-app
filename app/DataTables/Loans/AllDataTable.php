<?php

namespace App\DataTables\Loans;

use App\Loan;
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
                return '<a href="/customer/' . $model->user_id .'/loan/'.$model->id.'" class="btn btn-xs btn-outline-info"> More Details</a>';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $loans = Loan::all();

        return $loans;
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
            ['data' => 'reference_no', 'name' => 'reference_no', 'title' => 'Reference No.'],
            ['data' => 'amount_borrowed', 'name' => 'amount_borrowed', 'title' => 'Amount'],
            ['data' => 'amount_to_pay', 'name' => 'amount_to_pay', 'title' => 'Total Amount'],
            ['data' => 'status', 'name' => 'status', 'title' => 'Loan Status'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Applied On'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Loans\All_' . date('YmdHis');
    }
}
