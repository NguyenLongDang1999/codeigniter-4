<?php

namespace App\Models;

use CodeIgniter\Model;

class Mprovince extends Model
{
    protected $table      = 'tbl_province';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'type'];

    public function provinceGetName($id)
    {
        $query = $this->select('name')->where(['id' => $id])->get();
        return $query->getRowArray();
    }
}
