<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		// Garante que a conexão com o banco será carregada
		$this->load->database();
	}

	public function all()
	{
		return $this->db
			->order_by('id', 'DESC')
			->get('todos')
			->result_array();
	}

	public function find($id)
	{
		return $this->db->get_where('todos', ['id' => $id])->row_array();
	}

	public function insert($data)
	{
		$this->db->insert('todos', $data);
		return $this->db->insert_id();
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id)->update('todos', $data);
		return $this->db->affected_rows() > 0;
	}

	public function delete($id)
	{
		$this->db->delete('todos', ['id' => $id]);
		return $this->db->affected_rows() > 0;
	}
}
