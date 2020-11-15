<?php

namespace App\Models;

use CodeIgniter\Model;

class Mbrand extends Model
{
    protected $table      = 'tbl_brand';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'thumb', 'status', 'meta_title', 'meta_keyword', 'meta_desc', 'created_at', 'updated_at'];

    // Hiển thị tên thương hiệu qua sản phẩm
    public function brandGetName($id)
    {
        $query = $this->select('name')->where(['status' => 1, 'id' => $id])->get();
        return $query->getRowArray();
    }
}
