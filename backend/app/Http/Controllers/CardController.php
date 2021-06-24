<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function get(int $id)
    {
        return "get";
    }

    public function create()
    {
        return "create";
    }

    public function updateContents(int $id)
    {
        return "updateContents";
    }

    public function updateDeadline(int $id)
    {
        return "updateDeadline";
    }

    public function move(int $id)
    {
        return "move";
    }

    public function archive(int $id)
    {
        return "archive";
    }

    public function delete(int $id)
    {
        return "delete";
    }
}