<?php

namespace App\DataTables\Accounts;

use App\Loan;
use Yajra\DataTables\Services\DataTable;

class CustomerLoanDataTable extends DataTable
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
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return  $loan = Loan::where('user_id', $this->id);
    }

    /**
     * Optional method if you want to use html builder.
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '80px','printable' => false])
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
            [
                'data' => 'amount_borrowed',
                'name' => 'amount_borrowed',
                'title' => 'Amount Borrowed',
                'render' => 'function(){
                                return "Ksh. " + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            }',
            ],
            [
                'data' => 'amount_to_pay',
                'name' => 'amount_to_pay',
                'title' => 'Amount To Pay',
                'render' => 'function(){
                                return "Ksh. " + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                            }',
            ],
            ['data' => 'duration', 'name' => 'duration', 'title' => 'Duration (months)'],
            [
                'data' => 'approved',
                'name' => 'approved',
                'title' => 'Approved',
                'render' => 'function(){
                    
                                     return data == \'1\' ? \'Approved\' : \'Not Approved\'
                                }',
            ],
            ['data' => 'status', 'name' => 'status', 'title' => 'Status'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Borrowed Date'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Accounts\CustomerLoan_' . date('YmdHis');
    }
}
