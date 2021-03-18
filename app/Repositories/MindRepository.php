<?php

namespace App\Repositories;

use App\Models\Mind;

class MindRepository
{
  protected $mind;

  // 透過 DI 注入 Model
  public function __construct(Mind $mind)
  {
    $this->mind = $mind;
  }

  // 取得所有心智圖清單
  public function getMinds()
  {
    return $this->mind->get();
  }

  // 新增心智圖
  public function addMind($text)
  {
    $mind = new $this->mind;
    $mind->text = $text;
    $mind->save();
    return $mind->id;
  }

  // 編輯心智圖
  public function editMind($mind_id, $text)
  {
    $mind = $this->mind->find($mind_id);
    $mind->text = $text;
    $mind->save();
  }

  // 刪除心智圖
  public function delMind($mind_id)
  {
    $this->mind->find($mind_id)->delete();
  }
}
