<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Library Slug
use App\Libraries\Slug;
// Use Model
use App\Models\Mcatalog;

class CatalogController extends BaseController
{
    public function __construct()
    {
        $this->mcatalog = new Mcatalog();
        $this->slug = new Slug();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data['mcatalog'] = $this->mcatalog;
        $data['list'] = $this->mcatalog->where('trash', 1)->orderBy('created_at', 'desc')->findAll();
        return view('backend/catalog/index', $data);
    }

    public function recycle()
    {
        $data['list'] = $this->mcatalog->where('trash', 0)->orderBy('created_at', 'desc')->findAll();
        return view('backend/catalog/recycle', $data);
    }

    public function add()
    {
        // Danh muc đa cấp
        $data['mcatalog'] = $this->mcatalog;
        $data['validation'] = $this->validation;
        return view('backend/catalog/add', $data);
    }

    public function postAdd()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Tên danh mục sản phẩm không được bỏ trống.',
                    'max_length' => 'Tên danh mục sản phẩm không được vượt quá 255 ký tự.',
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
            return redirect()->route('catalogAdd')->withInput();
        }

        $upload_thumb = $this->request->getFile('thumb');
        // Nếu có lỗi trong lúc upload sẽ hiện ảnh defautl
        if ($upload_thumb->getError() == 4) {
            $thumb = 'default-image.jpg';
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/catalog', $thumb);
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
            'thumb' => $thumb,
            'status' => 1,
            'trash' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        // Kiểm tra tên đã tồn tại chưa (Nên kiểm tra slug)
        if ($this->mcatalog->catalogCheckSlug($slug)) {
            $this->mcatalog->save($data); // save (insert update)
            session()->setFlashdata('success', 'Danh mục sản phẩm đã được thêm.');
        } else {
            session()->setFlashdata('error', 'Danh mục đã tồn tại. Vui lòng kiểm tra lại.');
        }
        return redirect()->route('catalogIndex');
    }

    public function edit($id)
    {
        // Danh muc đa cấp
        $data['mcatalog'] = $this->mcatalog;
        
        // validation
        $data['validation'] = $this->validation;
        $row = $this->mcatalog->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        return view('backend/catalog/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->mcatalog->find($id);
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Tên danh mục sản phẩm không được bỏ trống.',
                    'max_length' => 'Tên danh mục sản phẩm không được vượt quá 255 ký tự.',
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
            $upload_thumb->move('uploads/catalog', $thumb);
            // Sau khi sửa sẽ xoá ảnh cũ
            if ($row['thumb'] != 'default-image.jpg') {
                unlink('uploads/catalog/' . $this->request->getVar('checkImg'));
            }
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
            'thumb' => $thumb,
            'updated_at' => date('Y-m-d H:i:s'),
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_desc' => $meta_desc,
        );

        $this->mcatalog->save($data); // save (insert update)
        session()->setFlashdata('success', 'Danh mục sản phẩm đã được cập nhật.');
        return redirect()->route('catalogIndex');
    }

    public function status($id)
    {
        
        $row = $this->mcatalog->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->mcatalog->save($data); // save (insert update)
        session()->setFlashdata('success', 'Trạng thái của danh mục sản phẩm đã được cập nhật.');
        return redirect()->route('catalogIndex');
    }

    public function trash($id)
    {

        // Lấy về chi tiết thông tin
        $row = $this->mcatalog->where(['trash' => 1])->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $child = $this->mcatalog->where(['parentid' => $row['id'], 'trash' => 1])->countAllResults();
        // Nếu không có danh mục con thì xoá nếu có thông báo lỗi
        if ($child == 0) {
            $trash = ($row['trash'] == 1) ? 0 : 1; // if rút gọn
            $data = array(
                'id' => $row['id'], // truyền id muốn cập nhật
                'trash' => $trash,
            );
            $this->mcatalog->save($data);
            session()->setFlashdata('success', 'Đã đưa danh mục "' . $row['name'] . '" vào thùng rác.');
        } else {
            session()->setFlashdata('error', 'Danh mục "' . $row['name'] . '" còn có các danh mục con bên trong. Vui lòng xoá danh mục con trước.');
        }
        return redirect()->route('catalogIndex');
    }

    public function restore($id)
    {
        
        // Lấy về chi tiết thông tin
        $row = $this->mcatalog->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $trash = ($row['trash'] == 0) ? 1 : 0; // if rút gọn
        $data = array(
            'id' => $row['id'], // truyền id muốn cập nhật
            'trash' => $trash,
        );
        $this->mcatalog->save($data);
        session()->setFlashdata('success', 'Đã khôi phục thành công danh mục "' . $row['name'] . '".');
        return redirect()->route('catalogRecycle');
    }

    public function delete($id)
    {
        
        // Lấy về chi tiết thông tin
        $row = $this->mcatalog->find($id);
        if(!$row) {
            return view('backend/error');
        }
        // xoá ảnh cũ
        if ($row['thumb'] != 'default-image.jpg') {
            unlink('uploads/catalog/' . $row['thumb']);
        }
        $this->mcatalog->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn danh mục "' . $row['name'] . '".');
        return redirect()->route('catalogRecycle');
    }

    //--------------------------------------------------------------------

}
