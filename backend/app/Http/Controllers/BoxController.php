<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function getAll()
    {
        return "getall";
    }

    public function get(int $id)
    {
        return $id;
    }

    public function create(Request $request)
    {
        //全件取得
        $boxes = Box::all();

        //件数取得
        $count = $boxes->count();

        //何も登録されていない場合
        if ($count === 0) {
            $newBox = new Box;
            $newBox->title = $request->title;
            $newBox->forward_id = 0;
            $newBox->save();
            return $newBox;
        }

        //最初のBoxを取得
        $firstBox = $boxes->firstWhere('forward_id', 0);

        //順番に並べる
        $orgnizedBoxes = [$firstBox];
        for ($i = 0; $i < $count - 1; $i++) {
            $nextBox = $boxes->first(function ($value, $key) use ($orgnizedBoxes, $i) {
                return $value->forward_id === $orgnizedBoxes[$i]->id;
            });
            array_push($orgnizedBoxes, $nextBox);
        }

        //orderを取得する
        $order = (int)$request->order;

        //この条件の場合は最後尾とする
        if ($order === null || $count <= $order || $order < 1) {
            $newBox = new Box;
            $newBox->title = $request->title;
            //現在最後尾のidを取得してセットする
            $newBox->forward_id = $orgnizedBoxes[$count - 1]->id;
            $newBox->save();
            return $newBox;
        }

        //最後尾以外に挿入する場合には挿入する場所にあるカードを繋ぎなおす必要がある

        //boxをforward_idをnullで挿入する
        $newBox = new Box;
        $newBox->title = $request->title;
        $newBox->forward_id = null;
        $newBox->save();

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

    public function updateTitle(Request $request, int $id)
    {
        return $request;
    }

    public function move(Request $request, int $id)
    {
        return $request;
    }

    public function delete(int $id)
    {
        return $id;
    }
}