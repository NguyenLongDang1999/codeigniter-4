<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Library Slug
use App\Libraries\Slug;
// Use Model
use App\Models\Mcatpost;

class CatpostController extends BaseController
{
    public function __construct()
    {
        $this->mcatpost = new Mcatpost();
        $this->slug = new Slug();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data['mcatpost'] = $this->mcatpost;
        $data['list'] = $this->mcatpost->orderBy('created_at', 'desc')->findAll();
        return view('backend/catpost/index', $data);
    }

    public function add()
    {
        // Danh muc đa cấp
        $data['mcatpost'] = $this->mcatpost;
        $data['validation'] = $this->validation;
        return view('backend/catpost/add', $data);
    }

    public function postAdd()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Tên danh mục tin không được bỏ trống.',
                    'max_length' => 'Tên danh mục tin không được vượt quá 255 ký tự.',
                ]
            ],
            'parentid' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Danh mục cha không được bỏ trống.'
                ]
            ],
            'meta_title' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Title (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Title (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_keyword' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Keyword (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Keyword (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_desc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Meta Description (SEO) không được bỏ trống.',
                ]
            ],
        ])) {
            // Load validation
            return redirect()->route('catpostAdd')->withInput();
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');
        $slug = $this->slug->str_slug($name);
        $parentid = $this->request->getVar('parentid');

        $data = array(
            'name' => $name,
            'slug' => $slug,
            'parentid' => $parentid,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        // Kiểm tra tên đã tồn tại chưa (Nên kiểm tra slug)
        if ($this->mcatpost->catpostCheckSlug($slug)) {
            $this->mcatpost->save($data); // save (insert update)
            session()->setFlashdata('success', 'Danh mục tin đã được thêm.');
        } else {
            session()->setFlashdata('error', 'Danh mục đã tồn tại. Vui lòng kiểm tra lại.');
        }
        return redirect()->route('catpostIndex');
    }

    public function edit($id)
    {
        // Danh muc đa cấp
        $data['mcatpost'] = $this->mcatpost;
         // Lấy id trên đường dẫn url
        $id = intval($id);
        // validation
        $data['validation'] = $this->validation;
        $row = $this->mcatpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        return view('backend/catpost/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->mcatpost->find($id);
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Tên danh mục tin không được bỏ trống.',
                    'max_length' => 'Tên danh mục tin không được vượt quá 255 ký tự.',
                ]
            ],
            'parentid' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Danh mục cha không được bỏ trống.'
                ]
            ],
            'meta_title' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Title (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Title (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_keyword' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Meta Keyword (SEO) không được bỏ trống.',
                    'max_length' => 'Meta Keyword (SEO) không được vượt quá 255 ký tự.',
                ]
            ],
            'meta_desc' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Meta Description (SEO) không được bỏ trống.',
                ]
            ],
        ])) {
            // Load validation
            return redirect()->back()->withInput();
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');
        $slug = $this->slug->str_slug($name);
        $parentid = $this->request->getVar('parentid');

        $data = array(
            'id' => $row['id'],
            'name' => $name,
            'slug' => $slug,
            'parentid' => $parentid,
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        $this->mcatpost->save($data); // save (insert update)
        session()->setFlashdata('success', 'Danh mục tin đã được cập nhật.');
        return redirect()->route('catpostIndex');
    }

    public function status($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->mcatpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->mcatpost->save($data); // save (insert update)
        session()->setFlashdata('success', 'Trạng thái của danh mục tin đã được cập nhật.');
        return redirect()->route('catpostIndex');
    }

    public function delete($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mcatpost->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $this->mcatpost->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn danh mục "' . $row['name'] . '".');
        return redirect()->route('catpostIndex');
    }

    //--------------------------------------------------------------------

}
