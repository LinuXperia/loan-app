<?php
/**
 * Created by PhpStorm.
 * User: amon
 * Date: 12/31/17
 * Time: 10:08 AM
 */

namespace App\Repositories;


interface UserRepository
{

    public function getLoansById($id);
}