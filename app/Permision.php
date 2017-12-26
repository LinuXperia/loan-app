<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permision extends EntrustPermission
{
    protected $fillable = ['name', 'display_name', 'description'];
}
