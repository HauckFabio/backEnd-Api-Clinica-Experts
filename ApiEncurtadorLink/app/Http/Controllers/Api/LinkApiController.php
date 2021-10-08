<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Links;
use Illuminate\Routing\ResourceRegistrar;

class LinkApiController extends Controller
{
  
    public function __construct(Links $link, Request $request) {
		$this->link = $link;
        $this->request = $request;
	}

    public function index()
    {
        $data = $this->link->all();
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->link->regras());

        $data = $request->all();

        $data = $this->link->create($data);

        return response()->json($data, 200);
    }

    public function show($id)
    {
        if(!$data = $this->link->find($id))
        {
            return response()->json(['error' => 'Não foi encontrado resultado para a consulta!'], 400);
        }
        else{
            return response()->json($data);
        }
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
