<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcatpost extends Model
{
    protected $table      = 'tbl_catpost';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'parentid', 'status', 'meta_title', 'meta_keyword', 'meta_desc', 'created_at', 'updated_at'];

    // Kiểm tra tên có hay chưa nếu có sẽ ko thêm đc
    public function catpostCheckSlug($slug)
    {
        $query = $this->where(['slug' => $slug])->orderBy('created_at', 'DESC')->countAllResults();
        if ($query > 0) {
            return false;
        } else {
            return true;
        }
    }

    // chi tiet danh mục
    public function catpostDetail($slug)
    {
        $query = $this->where(['status' => 1, 'slug' => $slug])->get();
        return $query->getRowArray();
    }

    // Hiển thị tên danh mục 
    public function catpostGetName($id)
    {
        $query = $this->where(['status' => 1, 'id' => $id])->get();
        return $query->getRowArray();
    }

    // Danh muc da cap
    public function catpostSubCatpost($parentid = 0)
    {
        $query = $this->where(['status' => 1, 'parentid' => $parentid])->get();
        return $query->getResultArray();
    }
}
