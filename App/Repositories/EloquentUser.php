<?php
/**
 * Created by PhpStorm.
 * User: amon
 * Date: 12/31/17
 * Time: 10:06 AM
 */

namespace App\Repositories;


use App\Loan;

class EloquentUser implements UserRepository
{
    /**
     * @var Loan
     */
    private $model;

    /**
     * EloquentUser constructor.
     * @param Loan $model
     */
    public function __construct(Loan $model)
    {

        $this->model = $model;
    }

    public function getLoansById($id)
    {
        return $this->model->where('user_id', $id);
    }
}