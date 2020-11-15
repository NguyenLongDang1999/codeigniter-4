<?php 
namespace App\Models;

use CodeIgniter\Model;

class Madmin extends Model{
    protected $table      = 'tbl_admin';
    protected $primaryKey = 'id';
    protected $allowedFields = ['fullname', 'username', 'password', 'gender', 'email', 'thumb', 'status', 'created_at', 'updated_at'];

    // Kiêm tra đăng nhâp
    public function checkLogin($username, $password)
    {
        $query = $this->where(['username' => $username, 'password' => $password]);
        if($query->countAllResults() == 1) {
            return $query->get()->getRowArray();
        } else {
            return false;
        }
    }
}