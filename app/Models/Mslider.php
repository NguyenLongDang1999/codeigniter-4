<?php

namespace App\Models;

use CodeIgniter\Model;

class Mslider extends Model
{
    protected $table      = 'tbl_slider';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'thumb', 'status', 'created_at', 'updated_at'];
}
