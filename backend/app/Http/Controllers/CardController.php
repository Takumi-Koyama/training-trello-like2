<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function get(int $id)
    {
        return $id;
    }

    public function create(Request $request)
    {
        //全件取得
        $box = Box::findOrfail($request->columnId);
        $cards = $box->cards;

        //件数取得
        $count = $cards->count();

        //何も登録されていない場合
        if ($count === 0) {
            $newBox = new Card;
            $newBox->title = $request->title;
            $newBox->description = $request->description;
            $newBox->forward_id = 0;
            $newBox->box_id = $request->columnId;
            $newBox->save();
            return $newBox;
        }

        //最初のCardを取得
        $firstCard = $cards->firstWhere('forward_id', 0);

        //順番に並べる
        $orgnizedCards = [$firstCard];
        for ($i = 0; $i < $count - 1; $i++) {
            $nextCard = $cards->first(function ($value, $key) use ($orgnizedCards, $i) {
                return $value->forward_id === $orgnizedCards[$i]->id;
            });
            array_push($orgnizedCards, $nextCard);
        }

        //orderを取得する
        $order = (int)$request->order;

        //この条件の場合は最後尾とする
        if ($order === null || $count <= $order || $order < 1) {
            $newCard = new Card;
            $newCard->title = $request->title;
            $newCard->description = $request->description;
            $newCard->box_id = $request->columnId;
            //現在最後尾のidを取得してセットする
            $newCard->forward_id = $orgnizedCards[$count - 1]->id;
            $newCard->save();
            return $newCard;
        }

        //最後尾以外に挿入する場合には挿入する場所にあるカードを繋ぎなおす必要がある

        //boxをforward_idをnullで挿入する
        $newCard = new Card;
        $newCard->title = $request->title;
        $newCard->description = $request->description;
        $newCard->box_id = $request->columnId;
        $newCard->forward_id = null;
        $newCard->save();

        //挿入したい場所のCardを新しいCardにつなぎ変える
        $changedCard = $orgnizedCards[$order - 1];
        $changedCard->forward_id = $newCard->id;
        $changedCard->save();

        if ($order === 1) {
            //挿入したい番号が先頭だった場合は0に繋ぎなおす
            $newCard->forward_id = 0;
        } else {
            //挿入する場所の前の番号を紐付ける
            $forwardCard = $orgnizedCards[$order - 2];
            $newCard->forward_id = $forwardCard->id;
        }
        $newCard->save();
        return $newCard;


        return $request;
    }

    public function updateContents(Request $request, int $id)
    {
        return $request;
    }

    public function updateDeadline(Request $request, int $id)
    {
        return $request;
    }

    public function move(Request $request, int $id)
    {
        return $request;
    }

    public function archive(int $id)
    {
        return $id;
    }

    public function delete(int $id)
    {
        return $id;
    }
}