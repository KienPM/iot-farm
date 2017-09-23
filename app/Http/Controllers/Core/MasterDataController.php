<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vegetable;
use Exception;
use App\Core\Responses\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class MasterDataController extends Controller
{
    protected $dataTypeAvaiable = [
        'vegetables' => [
            'class' => Vegetable::class,
            'select' => ['id', 'name'],
        ],
    ];

    protected $dataTypeActive = [];

    public function __construct()
    {
        $this->middleware($this->authMiddleware());
    }

    public function index($type)
    {
        if (!in_array($type, $this->dataTypeActive)) {
            throw new NotFoundHttpException;
        }
        $entities = app($this->dataTypeAvaiable[$type]['class']);
        if (isset($this->dataTypeAvaiable[$type]['select'])) {
            $entities = $entities->select($this->dataTypeAvaiable[$type]['select']);
        }
        $entities = $entities->get()->toArray();

        return Response::response('success', [
            'data' => $entities,
        ]);
    }
}
