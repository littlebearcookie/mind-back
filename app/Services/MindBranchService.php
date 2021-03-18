<?php

namespace App\Services;

use App\Repositories\MindBranchRepository;

class MindBranchService
{
  protected $mindBranchRepo;

  // 透過 DI 注入 Model
  public function __construct(MindBranchRepository $mindBranchRepo)
  {
    $this->mindBranchRepo = $mindBranchRepo;
  }

  // 取得心智圖所有分支
  public function getAll($mind_id)
  {
    $branches = $this->mindBranchRepo->getMindBranches($mind_id);
    $data = $this->buildBranch($branches, $branches[0]);
    return array("root" => $data, "template" => "default", "theme" => "fresh-blue", "version" => "1.4.33");
  }

  // 新增心智圖分支
  public function add($mind_id, $data)
  {
    $this->dismountBranch($mind_id, 0, 0, $data);
  }

  // 新增心智圖分支
  public function delete($mind_id)
  {
    $this->mindBranchRepo->delMindBranches($mind_id);
  }

  // 匯入 XMind 檔案至 DB
  public function import($mind_id, $data)
  {
    $this->dismountBranchFromXMind($mind_id, 0, 0, $data);
  }

  // 匯出 XMind 檔案
  public function export($mind_id)
  {
    return $this->mindBranchRepo->getMindBranches($mind_id);
  }

  // 將心智圖拆分並存進DB
  function dismountBranch($mind_id, $lv, $parent, $mind)
  {
    if (isset($mind['data']['background'])) {
      $background =  $mind['data']['background'];
    } else {
      $background = ($lv >= 2) ? "" : "#E9F0F4";
    }
    $color = isset($mind['data']['color']) ? $mind['data']['color'] : "#000000";
    $weight = isset($mind['data']['font-weight']) ? "T" : "F";
    $text = $mind['data']['text'];
    $temp = array(
      "mind" => $mind_id,
      "level" => $lv,
      "parent" => $parent,
      "text" => $text,
      "background" => $background,
      "color" => $color,
      "weight" => $weight,
    );
    $id = $this->mindBranchRepo->addMindBranches($temp);
    // 判斷是否有children
    if (isset($mind['children'])) {
      $lv++;
      for ($j = 0; $j < count($mind['children']); $j++) {
        $this->dismountBranch($mind_id, $lv, $id, $mind['children'][$j]);
      }
    }
  }
  // 將DB中的心智圖組合
  function buildBranch($branches, $parent)
  {
    $children = $branches->filter(function ($item) use ($parent) {
      return $item->parent == $parent->id;
    })->values();
    if (count($children) == 0) {
      return array("data" => $parent);
    } else {
      $output = [];
      for ($i = 0; $i < count($children); $i++) {
        $temp = $this->buildBranch($branches, $children[$i]);
        array_push($output, $temp);
      }
      return array(
        "children" => $output,
        "data" => $parent
      );
    }
  }
  // 將 XMind 心智圖拆分並存進DB
  function dismountBranchFromXMind($mind_id, $lv, $parent, $mind)
  {
    $background = ($lv >= 2) ? "" : "#E9F0F4";
    $color = "#000000";
    $weight =  "F";
    $text = (isset($mind['title']['__text'])) ? $mind['title']['__text'] : $mind['title'];
    $temp = array(
      "mind" => $mind_id,
      "level" => $lv,
      "parent" => $parent,
      "text" => $text,
      "background" => $background,
      "color" => $color,
      "weight" => $weight,
    );
    $id = $this->mindBranchRepo->addMindBranches($temp);
    // 判斷是否有children
    if (isset($mind['children'])) {
      $lv++;
      if (isset($mind['children']['topics']['topic'][0])) {
        for ($j = 0; $j < count($mind['children']['topics']['topic']); $j++) {
          $this->dismountBranchFromXMind($mind_id, $lv, $id, $mind['children']['topics']['topic'][$j]);
        }
      } else {
        $this->dismountBranchFromXMind($mind_id, $lv, $id, $mind['children']['topics']['topic']);
      }
    }
  }
}
