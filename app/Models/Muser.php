<?php

namespace App\Models;

use CodeIgniter\Model;

class Muser extends Model
{
    protected $table      = 'tbl_user';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'fullname', 'email', 'phone', 'created_at', 'updated_at', 'status', 'thumb', 'address'];

    // Kiêm tra đăng nhâp
    public function checkLogin($username, $password)
    {
        $query = $this->where(['username' => $username, 'password' => $password])->get();
        if(count($query->getResultArray()) == 1) {
            return $query->getRowArray();
        } else {
            return false;
        }
    }

    public function orderGetUserid($id)
    {
        $query = $this->where(['id' => $id])->get();
        return $query->getRowArray();
    }

    public function userGetEmail($email)
    {
        $query = $this->where(['email' => $email])->get();
        return $query->getRowArray();
    }

}
