<?php 
namespace App\Models;

use CodeIgniter\Model;

class Morder extends Model{
    protected $table      = 'tbl_order';
    protected $primaryKey = 'id';
    protected $allowedFields = ['ordercode', 'userid', 'price_ship', 'orderdate', 'money', 'coupon', 'address', 'province', 'district', 'status', 'trash'];

    // Truy vấN đặt hàng theo userid
    public function orderUserid($userid)
    {
        $query = $this->where(['trash' => 1, 'userid' => $userid])->orderBy('orderdate', 'desc')->get();
        return $query->getRowArray();
    }
}