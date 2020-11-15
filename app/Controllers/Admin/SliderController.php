<?php
// Use Controller Folder Admin
namespace App\Controllers\Admin;
// Use BaseController
use App\Controllers\BaseController;
// Use Model
use App\Models\Mslider;

class SliderController extends BaseController
{
    public function __construct()
    {
        $this->mslider = new Mslider();
        $this->validation =  \Config\Services::validation();
    }

    public function index()
    {
        $data['list'] = $this->mslider->orderBy('created_at', 'desc')->findAll();
        return view('backend/slider/index', $data);
    }

    public function add()
    {
        $data['validation'] = $this->validation;
        return view('backend/slider/add', $data);
    }

    public function postAdd()
    {
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[3]|is_unique[tbl_slider.name]',
                'errors' => [
                    'required' => 'Tên slider không được bỏ trống.',
                    'max_length' => 'Tên slider không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên slider không được dưới 3 ký tự.',
                    'is_unique' => 'Tên slider này đã tồn tại.'
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
            return redirect()->route('sliderAdd')->withInput();
        }

        $upload_thumb = $this->request->getFile('thumb');
        // Nếu có lỗi trong lúc upload sẽ hiện ảnh defautl
        if ($upload_thumb->getError() == 4) {
            $thumb = 'default-image.jpg';
        } else {
            // Sinh ra tên ngẫu nhiên cho ảnh
            $thumb = $upload_thumb->getRandomName();
            // move tới file lưu ảnh
            $upload_thumb->move('uploads/slider', $thumb);
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');

        $data = array(
            'name' => $name,
            'thumb' => $thumb,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $this->mslider->save($data); // save (insert update)
        session()->setFlashdata('success', 'Slider đã được thêm.');
        return redirect()->route('sliderIndex');
    }

    public function edit($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->mslider->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $data['row'] = $row;
        $data['validation'] = $this->validation;    
        return view('backend/slider/edit', $data);
    }

    public function postEdit($id)
    {
        $row = $this->mslider->find($id);
        if (!$this->validate([
            'name' => [
                'rules' => 'required|max_length[255]|min_length[3]',
                'errors' => [
                    'required' => 'Tên thương hiệu không được bỏ trống.',
                    'max_length' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
                    'min_length' => 'Tên thương hiệu không được dưới 3 ký tự.',
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
            $upload_thumb->move('uploads/slider', $thumb);
            // Sau khi sửa sẽ xoá ảnh cũ
            if ($row['thumb'] != 'default-image.jpg') {
                unlink('uploads/slider/' . $this->request->getVar('checkImg'));
            }
        }

        // Lấy giá trị
        $name = $this->request->getVar('name');

        $data = array(
            'id' => $row['id'],
            'name' => $name,
            'thumb' => $thumb,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $this->mslider->save($data); // save (insert update)
        session()->setFlashdata('success', 'Slider đã được cập nhật.');
        return redirect()->route('sliderIndex');
    }

    public function status($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        $row = $this->mslider->find($id);
        if(!$row) {
            return view('backend/error');
        }
        $status = ($row['status'] == 1) ? 0 : 1;
        $data = array(
            'id' => $row['id'],
            'status' => $status
        );
        $this->mslider->save($data); // save (insert update)
        session()->setFlashdata('success', 'Trạng thái của slider đã được cập nhật.');
        return redirect()->route('sliderIndex');
    }

    public function delete($id)
    {
         // Lấy id trên đường dẫn url
        $id = intval($id);
        // Lấy về chi tiết thông tin
        $row = $this->mslider->find($id);
        if(!$row) {
            return view('backend/error');
        }
        // xoá ảnh cũ
        if ($row['thumb'] != 'default-image.jpg') {
            unlink('uploads/slider/' . $row['thumb']);
        }
        $this->mslider->delete($id);
        session()->setFlashdata('success', 'Đã xoá vĩnh viễn slider "' . $row['name'] . '".');
        return redirect()->route('sliderIndex');
    }

    //--------------------------------------------------------------------

}
