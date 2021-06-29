<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Services\BoxCreateService;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\BoxCreateRequest;
use Illuminate\Http\Request;
use App\Http\Resources\BoxResource;

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

    public function create(BoxCreateRequest $request)
    {
        $params = [
            'title' => $request->title,
            'order' => $request->order,
        ];
        $service = new BoxCreateService;
        $newBox = $service->main($params);
        return BoxResource::make($newBox);
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