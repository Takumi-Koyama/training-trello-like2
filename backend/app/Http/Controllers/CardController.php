<?php

namespace App\Http\Controllers;

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