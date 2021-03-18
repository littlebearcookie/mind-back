<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MindService;
use App\Services\MindBranchService;

class MindController extends Controller
{
	protected $mindService;
	protected $mindBranchService;
	// 透過 DI 注入 Service
	public function __construct(MindService $mindService, MindBranchService $mindBranchService)
	{
		$this->mindService = $mindService;
		$this->mindBranchService = $mindBranchService;
	}
	public function all()
	{
		$data = $this->mindService->getAll();
		return [
			"status" => "ok",
			"data" => $data
		];
	}
	public function one($mind_id)
	{
		$data = $this->mindBranchService->getAll($mind_id);
		return [
			"status" => "ok",
			"data" => $data
		];
	}
	public function add(Request $request)
	{
		$mind_id = $this->mindService->add($request->MindOut['root']['data']['text']);
		$this->mindBranchService->add($mind_id, $request->MindOut['root']);
		return [
			"status" => "ok",
		];
	}
	public function edit(Request $request, $mind_id)
	{
		$this->mindService->edit($mind_id, $request->MindOut['root']['data']['text']);
		$this->mindBranchService->delete($mind_id);
		$this->mindBranchService->add($mind_id, $request->MindOut['root']);
		return [
			"status" => "ok",
		];
	}
	public function delete($mind_id)
	{
		$this->mindService->delete($mind_id);
		$this->mindBranchService->delete($mind_id);
		return [
			"status" => "ok",
		];
	}
	public function import(Request $request)
	{
		$mind_id = $this->mindService->add($request->MindOut['title']);
		$this->mindBranchService->import($mind_id, $request->MindOut);
		return [
			"status" => "ok",
		];
	}
	public function export($mind_id)
	{
		$data = $this->mindBranchService->export($mind_id);
		return [
			"status" => "ok",
			"data" => $data
		];
	}
}
