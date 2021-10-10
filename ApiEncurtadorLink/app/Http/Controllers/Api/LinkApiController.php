<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\MasterApiController;
use App\Models\Links;
use App\Models\Logs;

class LinkApiController extends MasterApiController
{
    protected $model;
    protected $path = 'links';
    protected $path2 = 'logs';
   

    public function __construct(Links $links, Logs $logs, Request $request) {
		$this->model = $links;
        $this->log = $logs;
        $this->request = $request;
	}

    
}
