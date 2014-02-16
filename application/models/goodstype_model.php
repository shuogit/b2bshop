<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//商品类型模型
class Goodstype_model extends CI_Model{

	const TBL_GT = 'goods_type';

	public function add_goodstype($data){
		return $this->db->insert(self::TBL_GT,$data);
	}
	#获取所有商品类型
	public function get_all_types(){
		$query = $this->db->get(self::TBL_GT);
		return $query->result_array();
	}

	#通过ID获得分类
	public function get_type($type_id){
		$condition['type_id'] = $type_id;
		$query = $this->db->where($condition)->get(self::TBL_GT);
		$goods_type = $query->row_array();
		return $goods_type['type_name'];
	}

	#获取分页数据
	public function list_goodstype($limit,$offset){
		$query = $this->db->limit($limit,$offset)->get(self::TBL_GT);
		return $query->result_array();
	}

	#统计商品类型的总数
	public function count_goodstype(){
		return $this->db->count_all(self::TBL_GT);
	}
}