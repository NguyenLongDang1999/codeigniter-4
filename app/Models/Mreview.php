<?php 
namespace App\Models;

use CodeIgniter\Model;

class Mreview extends Model{
    protected $table      = 'tbl_review';
    protected $primaryKey = 'id';
    protected $allowedFields = ['productid', 'userid', 'total', 'created_at', 'body'];
    
    public function getReview($id)
    {
        $query = $this->where(['productid' => $id])->get(); 
        return $query->getRowArray();
    }
}