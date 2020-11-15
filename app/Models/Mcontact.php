<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcontact extends Model
{
    protected $table      = 'tbl_contact';
    protected $primaryKey = 'id';
    protected $allowedFields = ['fullname', 'email', 'body', 'phone', 'created_at'];
}
