<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Model
use App\Models\Mbrand;

class BrandController extends BaseController
{
    public function __construct()
    {
        $this->mbrand = new Mbrand();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data['list'] = $this->mbrand->orderBy('created_at', 'desc')->findAll();
        return view('backend/brand/index', $data);
    }

    public function add()
    {
        $data['validation'] = $this->validation;
        return view('backend/brand/add', $data);
    }

    public function postAdd()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[3]|is_unique[tbl_brand.name]',
                'errors' => [
                    'required' => 'Tên thương hiệu không được bỏ trống.',
                    'max_length' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên thương hiệu không được dưới 3 ký tự.',
                    'is_unique' => 'Tên thương hiệu này đã tồn tại.'
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
            'thumb' => [
                'rules' => 'max_size[thumb,1024]|is_image[thumb]|mime_in[thumb,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ảnh không phù hợp với kích thước.',
                    'is_image' => 'Tệp bạn upload không phải là hình ảnh.',
                    'mime_in' => 'Tệp bạn upload không phải là hình ảnh.'
                ]
            ]
        ])) {
            // Load validation
            return redirect()->route('brandAdd')->withInput();
        }

        $upload_thumb = $this->request->getFile('thumb');
        // Nếu có lỗi trong lúc upload sẽ hiện ảnh defautl
        if ($upload_thumb->getError() == 4) {
            $thumb = 'default-image.jpg';
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/brand', $thumb);
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');

        $data = array(
            'name' => $name,
            'thumb' => $thumb,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        $this->mbrand->save($data); // save (insert update)
        session()->setFlashdata('success', 'Thương hiệu đã được thêm.');
        return redirect()->route('brandIndex');
    }

    public function edit($id)
    {
        
        $id = intval($id);
        $row = $this->mbrand->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        $data['validation'] = $this->validation;    
        return view('backend/brand/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->mbrand->find($id);
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[3]',
                'errors' => [
                    'required' => 'Tên thương hiệu không được bỏ trống.',
                    'max_length' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên thương hiệu không được dưới 3 ký tự.',
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
            'thumb' => [
                'rules' => 'max_size[thumb,1024]|is_image[thumb]|mime_in[thumb,image/png,image/jpg,image/jpeg]',
                'errors' => [
                    'max_size' => 'Ảnh không phù hợp với kích thước.',
                    'is_image' => 'Tệp bạn upload không phải là hình ảnh.',
                    'mime_in' => 'Tệp bạn upload không phải là hình ảnh.'
                ]
            ]
        ])) {
            // Load validation
            return redirect()->back()->withInput();
        }

        $upload_thumb = $this->request->getFile('thumb');
        // Kiểm tra ảnh cũ 
        if ($upload_thumb->getError() == 4) {
            $thumb = $this->request->getVar('checkImg');
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/brand', $thumb);
            // Sau khi sửa sẽ xoá ảnh cũ
            if ($row['thumb'] != 'default-image.jpg') {
                unlink('uploads/brand/' . $this->request->getVar('checkImg'));
            }
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');
        $meta_title = $this->request->getVar('meta_title');
        $meta_keyword = $this->request->getVar('meta_keyword');
        $meta_desc = $this->request->getVar('meta_desc');

        $data = array(
            'id' => $row['id'],
            'name' => $name,
            'thumb' => $thumb,
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        $this->mbrand->save($data); // save (insert update)
        session()->setFlashdata('success', 'Thương hiệu đã được cập nhật.');
        return redirect()->route('brandIndex');
    }

    public function status($id)
    {
        
        $id = intval($id);
        $row = $this->mbrand->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->mbrand->save($data); // save (insert update)
        session()->setFlashdata('success', 'Trạng thái của thương hiệu đã được cập nhật.');
        return redirect()->route('brandIndex');
    }

    public function delete($id)
    {
        
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mbrand->find($id);
        if(!$row) {
            return view('backend/error');
        }
        // xoá ảnh cũ
        if ($row['thumb'] != 'default-image.jpg') {
            unlink('uploads/brand/' . $row['thumb']);
        }
        $this->mbrand->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn thương hiệu "' . $row['name'] . '".');
        return redirect()->route('brandIndex');
    }

    //--------------------------------------------------------------------

}
