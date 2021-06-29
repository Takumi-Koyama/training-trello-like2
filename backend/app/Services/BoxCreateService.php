<?php

namespace App\Services;

use App\Models\Box;
use Illuminate\Database\Eloquent\Collection;

class BoxCreateService
{
    public function main(array $params): Box
    {
        $boxes = Box::all();
        $count = $boxes->count();

        if ($count === 0) {
            $newBox = $this->register($params, 0);
            $newBox->order = $count + 1;
            return $newBox;
        }

        //取得したboxを並び替えて配列で取得する
        $orgnizedBoxes = $this->sort($boxes);

        $order = $params['order'];

        //この条件の場合は最後尾とする
        if ($order === null || $count < $order || $order < 1) {
            $lastBoxId = $orgnizedBoxes[$count - 1]->id;
            $newBox = $this->register($params, $lastBoxId);
            $newBox->order = $count + 1;
            return $newBox;
        }

        //最後尾以外に挿入する場合には挿入する場所にあるカードをずらして登録
        $newBox = $this->slideRegister($params, $order, $orgnizedBoxes);
        $newBox->order = $order;
        return $newBox;
    }

    private function register(array $params, int $forwardId = null)
    {
        $newBox = new Box;
        $newBox->title = $params['title'];
        $newBox->forward_id = $forwardId;
        $newBox->save();
        return $newBox;
    }

    private function sort(Collection $boxes)
    {
        //最初のBoxを取得
        $firstBox = $boxes->firstWhere('forward_id', 0);

        //配列の個数を取得
        $count = $boxes->count();

        //順番に並べる
        $orgnizedBoxes = [$firstBox];
        for ($i = 0; $i < $count - 1; $i++) {
            $nextBox = $boxes->first(function ($value, $key) use ($orgnizedBoxes, $i) {
                return $value->forward_id === $orgnizedBoxes[$i]->id;
            });
            array_push($orgnizedBoxes, $nextBox);
        }

        return $orgnizedBoxes;
    }

    private function slideRegister(array $params, int $order, array $orgnizedBoxes)
    {
        //boxをforward_idをnullで挿入する
        $newBox = $this->register($params, null);

        //挿入したい場所のBoxを新しいBoxにつなぎ変える
        $changedBox = $orgnizedBoxes[$order - 1];
        $changedBox->forward_id = $newBox->id;
        $changedBox->save();

        if ($order === 1) {
            //挿入したい番号が先頭だった場合は0に繋ぎなおす
            $newBox->forward_id = 0;
        } else {
            //挿入する場所の前の番号を紐付ける
            $forwardBox = $orgnizedBoxes[$order - 2];
            $newBox->forward_id = $forwardBox->id;
        }
        $newBox->save();
        return $newBox;
    }
}