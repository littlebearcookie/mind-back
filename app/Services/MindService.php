<?php

namespace App\Services;

use App\Repositories\MindRepository;

class MindService
{
  protected $mindRepo;

  // 透過 DI 注入 Model
  public function __construct(MindRepository $mindRepo)
  {
    $this->mindRepo = $mindRepo;
  }

  // 取得所有心智圖清單
  public function getAll()
  {
    return $this->mindRepo->getMinds();
  }

  // 新增心智圖
  public function add($text)
  {
    return $this->mindRepo->addMind($text);
  }

  // 編輯心智圖
  public function edit($mind_id, $text)
  {
    return $this->mindRepo->editMind($mind_id, $text);
  }

  // 刪除心智圖
  public function delete($mind_id)
  {
    $this->mindRepo->delMind($mind_id);
  }
}
