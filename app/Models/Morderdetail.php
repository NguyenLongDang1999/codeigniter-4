<?php 
namespace App\Models;

use CodeIgniter\Model;

class Morderdetail extends Model{
    protected $table      = 'tbl_orderdetail';
    protected $primaryKey = 'id';
    protected $allowedFields = ['orderid', 'productid', 'qty', 'price', 'status', 'trash'];

    public function orderdetailProductid($id)
    {
        $query = $this->select('*')->where('orderid', $id)->join('tbl_product', 'tbl_product.id = tbl_orderdetail.productid')->get();
        return $query->getResultArray();
    }
}