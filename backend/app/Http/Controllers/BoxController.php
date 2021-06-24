<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Faker\Core\Number;
use Illuminate\Http\Request;

class BoxController extends Controller
{
    public function getAll()
    {
        return "getall";
    }

    public function get(int $id)
    {
        return "get";
    }

    public function create()
    {
        return "create";
    }

    public function updateTitle(int $id)
    {
        return "updateTitle";
    }

    public function move(int $id)
    {
        return "move";
    }

    public function delete(int $id)
    {
        return "delete";
    }
}