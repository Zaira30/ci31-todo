<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Todos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		header('Content-Type: application/json; charset=utf-8');
		$this->load->model('Todo_model', 'todos');
	}

	private function input_json()
	{
		$raw = file_get_contents('php://input');
		$data = json_decode($raw, true);
		return is_array($data) ? $data : [];
	}

	private function respond($data, $status = 200)
	{
		http_response_code($status);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		exit;
	}

	public function index()
	{
		$items = $this->todos->all();
		return $this->respond(['data' => $items]);
	}

	public function show($id)
	{
		$todo = $this->todos->find((int)$id);
		if (!$todo) return $this->respond(['error' => 'Not found'], 404);
		return $this->respond(['data' => $todo]);
	}

	public function create()
	{
		$payload = $this->input_json();

		if (!isset($payload['title']) || trim($payload['title']) === '') {
			return $this->respond(['error' => 'title is required'], 422);
		}

		$data = [
			'title'       => trim($payload['title']),
			'description' => isset($payload['description']) ? trim($payload['description']) : null,
			'status'      => 'pending',
		];

		$id = $this->todos->insert($data);
		$created = $this->todos->find($id);
		return $this->respond(['data' => $created], 201);
	}

	public function update($id)
	{
		$payload = $this->input_json();

		$changes = [];
		if (isset($payload['title']))       $changes['title'] = trim($payload['title']);
		if (isset($payload['description'])) $changes['description'] = trim($payload['description']);
		if (isset($payload['status'])) {
			$status = $payload['status'] === 'done' ? 'done' : 'pending';
			$changes['status'] = $status;
		}

		if (empty($changes)) {
			return $this->respond(['error' => 'No fields to update'], 400);
		}

		$ok = $this->todos->update((int)$id, $changes);
		if (!$ok) return $this->respond(['error' => 'Not found'], 404);

		$updated = $this->todos->find((int)$id);
		return $this->respond(['data' => $updated]);
	}

	public function delete($id)
	{
		$ok = $this->todos->delete((int)$id);
		if (!$ok) return $this->respond(['error' => 'Not found'], 404);
		return $this->respond(['deleted' => true]);
	}
}
