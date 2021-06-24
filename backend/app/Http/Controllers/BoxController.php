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
        return $id;
    }

    public function create(Request $request)
    {
        return $request;
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