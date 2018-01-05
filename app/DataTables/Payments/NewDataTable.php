<?php

namespace App\DataTables\Payments;

use App\Payment;
use Yajra\DataTables\Services\DataTable;

class NewDataTable extends DataTable
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return  $payments = Payment::where('approved', null);
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
                    ->addAction(['width' => '80px', 'printable' => false])
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
            ['data' => 'amount', 'name' => 'amount', 'title' => 'Amount'],
            ['data' => 'payment_mode', 'name' => 'payment_mode', 'title' => 'Payment Mode'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Payed On'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Payments\New_' . date('YmdHis');
    }
}
