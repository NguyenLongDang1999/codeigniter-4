<?php

namespace App\Controllers;
// Use BaseController
use App\Controllers\BaseController;
use App\Models\Mproduct;
use App\Models\Mpost;
use App\Models\Mcatalog;
use App\Models\Mcatpost;

class PostController extends BaseController
{
    public function __construct()
    {
        $this->mproduct = new Mproduct();
        $this->mpost = new Mpost();
        $this->mcatalog = new Mcatalog();
        $this->mcatpost = new Mcatpost();
    }

    public function index()
    {
        $data['listPostNew'] = $this->mpost->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->paginate(4);
        // LOad view
        $data['mcatpost'] = $this->mcatpost;
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(8);
        $data['mcatalog'] = $this->mcatalog;
        $data['pager'] = $this->mpost->pager;
        return view('frontend/post/index', $data);
    }

    public function catpost()
    {   
        // lấy thông tin qua url
        $slug = $this->request->uri->getSegment(2);
        $row = $this->mcatpost->catpostDetail($slug);

        // Xuất Breadcrumb
        $parent = $this->mcatpost->catpostGetName($row['id']);
        if (isset($parent['parentid'])) {
            $child = $this->mcatpost->catpostGetName($parent['parentid']);
            $data['child'] = $child;

            if (isset($child['parentid'])) {
                $parentChild = $this->mcatpost->catpostGetName($child['parentid']);
                $data['parentChild'] = $parentChild;
            }
        }

        // Lấy id hiển thị sản phẩm theo danh mục
        $listCat = $this->mcatpost->where(['status' => 1, 'parentid' => $row['id']])->findAll();
        $listCatid[] = $row['id'];
        foreach ($listCat as $item) {
            $listCatid[] = $item['id'];
            $listCat = $this->mcatpost->where(['status' => 1, 'parentid' => $item['id']])->findAll();
            foreach ($listCat as $item1) {
                $listCatid[] = $item1['id'];
            }
        }

        $data['postShowByCat'] = $this->mpost->postShowByCat($listCatid);

        // LOad view
        $data['mcatpost'] = $this->mcatpost;
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(8);
        $data['mcatalog'] = $this->mcatalog;
        $data['parent'] = $parent;
        $data['pager'] = $this->mpost->pager;
        $data['row'] = $row;
        return view('frontend/post/catpost', $data);
    }

    public function detail()
    {
        $data['mcatalog'] = $this->mcatalog;
        $data['mcatpost'] = $this->mcatpost;
        $slug = $this->request->uri->getSegment(2);
        $row = $this->mpost->postDetail($slug);
        if (!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        $data['listProductNew'] = $this->mproduct->where(['status' => 1, 'trash' => 1])->orderBy('created_at', 'desc')->findAll(8);
        // Xuất Breadcrumb
        $child = $this->mcatpost->catpostGetName($row['catpostid']);
        $parentChild = $this->mcatpost->catpostGetName($child['parentid']);
        // LOad view
        $data['parentChild'] = $parentChild;
        $data['child'] = $child;
        return view('frontend/post/detail', $data);
    }
}
