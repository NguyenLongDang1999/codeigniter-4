<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcoupon extends Model
{
    protected $table      = 'tbl_coupon';
    protected $primaryKey = 'id';
    protected $allowedFields = ['code', 'price_discount', 'code_limit', 'user_used', 'expiration_date', 'price_payment_limit', 'code_description', 'status', 'created_at'];

    public function getUserUsed($id)
    {
        $query = $this->where(['status' => 1, 'id' => $id])->get();
        $row = $query->getRowArray();
        return $row['user_used'];
    }
}
