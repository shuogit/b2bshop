<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order extends Admin_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('order_model');
		$this->load->model('user_model');
		$this->load->model('goods_model');

	}
	
	#显示出所有的订单
	public function index($offset = ''){
		#配置分页信息
		$config['base_url'] = site_url('admin/order/index/');
		$config['total_rows'] = $this->order_model->count_order();
		$config['per_page'] = 2;
		$config['uri_segment'] = 4;

		#自定义分页链接
		$config['first_link'] = '首页';
		$config['last_link'] = '尾页';
		$config['prev_link'] = '上一页';
		$config['next_link'] = '下一页';

		#初始化分页类
		$this->pagination->initialize($config);
		
		#生成分页信息
		$data['pageinfo'] = $this->pagination->create_links();
		$limit = $config['per_page'];
		$data['order'] = $this->order_model->list_order($limit,$offset); 
		$this->load->view('order_list.html',$data);

	}

	public function order_detail($order_id){
		$data['order'] = $this->order_model->get_order($order_id);
		$user_id = $data['order']['user_id'];
		$data['user'] = $this->user_model->get_user($user_id);
		# $goods是个多维数组，包含多个商品
		$data['goods'] = $this->goods_model->get_order_goods($order_id);
		$this->load->view('order_detail.html',$data);
	}

	#订单状态修改
	public function order_change($order_id){
		$order_status = $this->input->post('order_status');
		if($this->order_model->order_change($order_id,$order_status)){
			$data['message'] = '操作成功';
			$data['url'] = site_url('admin/order/index');
			$data['wait'] = 2;
			$this->load->view('message.html',$data);
		} else {
			$data['message'] = '操作失败';
			$data['url'] = site_url('admin/order/index');
			$data['wait'] = 5;
			$this->load->view('message.html',$data);
		} 
	}
}