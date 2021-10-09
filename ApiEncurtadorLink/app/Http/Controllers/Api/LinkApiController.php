<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterApiController;
use App\Models\Links;


class LinkApiController extends MasterApiController
{
    protected $model;
    protected $path = 'links';
   

    public function __construct(Links $links, Request $request) {
		$this->model = $links;
        $this->request = $request;
	}

    
}
