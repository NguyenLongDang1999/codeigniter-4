<?php

namespace App\Models;

use CodeIgniter\Model;

class Mproduct extends Model
{
    protected $table      = 'tbl_product';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'sku', 'quantity', 'price', 'sale', 'catid', 'brandid', 'intro_desc', 'detail_desc', 'thumb', 'thumb_list', 'view', 'number_buy', 'featured', 'status', 'trash', 'meta_title', 'meta_keyword', 'meta_desc', 'created_at', 'updated_at'];

    // Kiểm tra tên có hay chưa nếu có sẽ ko thêm đc
    public function productCheckSlug($slug)
    {
        $query = $this->where(['slug' => $slug])->orderBy('created_at', 'DESC')->countAllResults();
        if($query > 0) {
            return false;
        } else {
            return true;
        }
    }

    // Hiển thị sản phẩm ra trang chủ theo danh mục
    public function productByCat($list_cat)
    {
        $query = $this->where(['trash' => 1, 'status' => 1])->whereIn('catid', $list_cat)->orderBy('created_at', 'desc')->Limit(16)->get();
        return $query->getResultArray();
    }

    // CHi tiết sẩn phẩm
    public function productDetail($slug)
    {
        $query = $this->where(['trash' => 1, 'status' => 1, 'slug' => $slug])->get();
        return $query->getRowArray();
    }

    // Hiển thị sản phẩm theo danh mục
    public function productShowByCat($listCatid, $value, $order)
    {
        $str = "";
        foreach ($listCatid as $item) {
            $str .= " catid = $item OR";
        }
        $str = rtrim($str, 'OR ');     
        $query = $this->where(['trash' => 1, 'status' => 1])->groupStart()->where($str)->groupEnd()->orderBy($value, $order)->paginate(12);
        return $query;
    }     

    // TÌm kiếm sản phẩm
    public function productSearch($keyword, $value, $order)
    {
        $query = $this->like('name', $keyword)->where(['status' => 1, 'trash' => 1])->orderBy($value, $order)->paginate(12);
        return $query;
    }

    // Trả về số lượng đã bán sản phẩm
    public function productUpdateNumberBuy($id)
    {
        $query = $this->where(['id' => $id])->get(); 
        $row = $query->getRowArray();
        return $row['number_buy'];
    }

    // Lấy chih tiết sản phẩm qua id 
    public function productGetid($id)
    {
        $query = $this->where(['trash' => 1, 'status' => 1,'id' => $id])->get(); 
        return $query->getRowArray();
    }
}
