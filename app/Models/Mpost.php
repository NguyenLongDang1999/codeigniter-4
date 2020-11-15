<?php

namespace App\Models;

use CodeIgniter\Model;

class Mpost extends Model
{
    protected $table      = 'tbl_post';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'catpostid', 'intro_desc', 'detail_desc', 'thumb', 'status', 'trash', 'meta_title', 'meta_keyword', 'meta_desc', 'created_at', 'updated_at'];

    // Kiểm tra tên có hay chưa nếu có sẽ ko thêm đc
    public function postCheckSlug($slug)
    {
        $query = $this->where(['slug' => $slug])->orderBy('created_at', 'DESC')->countAllResults();
        if($query > 0) {
            return false;
        } else {
            return true;
        }
    }  

    public function postDetail($slug)
    {
        $query = $this->where(['trash' => 1, 'status' => 1, 'slug' => $slug])->get();
        return $query->getRowArray();
    }

     // Hiển thị sản phẩm theo danh mục
     public function postShowByCat($listCatid)
     {
         $str = "";
         foreach ($listCatid as $item) {
             $str .= " catpostid = $item OR";
         }
         $str = rtrim($str, 'OR ');     
         $query = $this->where(['trash' => 1, 'status' => 1])->groupStart()->where($str)->groupEnd()->orderBy('created_at', 'desc')->paginate(4);
         return $query;
     }    
}
