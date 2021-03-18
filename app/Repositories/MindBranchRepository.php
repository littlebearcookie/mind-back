<?php

namespace App\Repositories;

use App\Models\MindBranch;

class MindBranchRepository
{
  protected $mindBranch;

  // 透過 DI 注入 Model
  public function __construct(MindBranch $mindBranch)
  {
    $this->mindBranch = $mindBranch;
  }

  // 取得心智圖所有分支
  public function getMindBranches($mind_id)
  {
    return $this->mindBranch->where("mind", $mind_id)->orderBy("level", "ASC")->get();
  }

  // 新增心智圖分支
  public function addMindBranches($data)
  {
    $mindBranch = new $this->mindBranch;
    $mindBranch->mind = $data['mind'];
    $mindBranch->level = $data['level'];
    $mindBranch->parent = $data['parent'];
    $mindBranch->text = $data['text'];
    $mindBranch->background = $data['background'];
    $mindBranch->color = $data['color'];
    $mindBranch->weight = $data['weight'];
    $mindBranch->save();
    return $mindBranch->id;
  }

  // 刪除心智圖分支
  public function delMindBranches($mind_id)
  {
    $this->mindBranch->where("mind", $mind_id)->delete();
  }
}
