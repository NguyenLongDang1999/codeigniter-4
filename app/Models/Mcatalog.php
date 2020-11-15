<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcatalog extends Model
{
    protected $table      = 'tbl_catalog';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'parentid', 'thumb', 'status', 'trash', 'meta_title', 'meta_keyword', 'meta_desc', 'created_at', 'updated_at'];

    // Kiểm tra tên có hay chưa nếu có sẽ ko thêm đc
    public function catalogCheckSlug($slug)
    {
        $query = $this->where(['slug' => $slug])->orderBy('created_at', 'DESC')->countAllResults();
        if ($query > 0) {
            return false;
        } else {
            return true;
        }
    }

    // Hiển thị tên danh mục qua sản phẩm
    public function catalogGetName($id)
    {
        $query = $this->where(['status' => 1, 'trash' => 1, 'id' => $id])->get();
        return $query->getRowArray();
    }

    public function catalogSubCatalog($parentid = 0)
    {
        $query = $this->where(['status' => 1, 'trash' => 1, 'parentid' => $parentid])->get();
        return $query->getResultArray();
    }

     // chi tiet danh mục
     public function catalogDetail($slug)
     {
         $query = $this->where(['trash' => 1, 'status' => 1, 'slug' => $slug])->get();
         return $query->getRowArray();
     }

    // Hiển thị sản phẩm theo danh mục trang chu
    public function catalogByCat($parentid)
    {
        $arr = array();
        $arr[] = $parentid;
        $list = $this->catalogSubCatalog($parentid);
        if (count($list)) {
            foreach ($list as $item) {
                $arr[] = $item['id'];
                $list1 = $this->catalogSubCatalog($item['id']);
                if (count($list1)) {
                    foreach ($list1 as $item1) {
                        $arr[] = $item1['id'];
                        $list2 = $this->catalogSubCatalog($item1['id']);
                        if (count($list2)) {
                            foreach ($list2 as $item2) {
                                $arr[] = $item2['id'];
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }
}
