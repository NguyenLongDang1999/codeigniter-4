<?php

namespace App\Models;

use CodeIgniter\Model;

class Mdistrict extends Model
{
    protected $table      = 'tbl_district';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'type', 'provinceid'];

    public function districtGetName($id)
    {
        $query = $this->select('name')->where(['id' => $id])->get();
        return $query->getRowArray();
    }
}
