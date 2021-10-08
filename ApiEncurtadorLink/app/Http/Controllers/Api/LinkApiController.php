<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
        if(empty($request->Identificacao) || empty($request->Link))
        {
            $response = array();
            if(empty($request->Identificacao))
                $response = ['Status' => 'Erro','Mensagem' => 'Campo Identificacao vazio!'];
            else if(empty($request->Link))
            {
                $response = ['Status' => 'Erro','Mensagem' => 'Campo Link vazio!'];  
            }
            else if(empty($request->Identificacao) and empty($request->Link))
            {
                $response = ['Status' => 'Erro','Mensagem' => 'Campos Link e Identificacao vazios!'];    
            }

            return response()->json($response, 401);
        }
        else{
        $this->validate($request, $this->link->regras());

        $data = $request->all();
        $data = $this->link->create($data);
        $response = array();
        $response = ['Status' => 'Sucesso','Resultado' => "Informações salvas!"];
        return response()->json($response, 200);
        }
    }

    public function show($id)
    {
        if(!$data = $this->link->find($id))
        {
            $response = array();
            $response = ['Status' => 'Erro','Mensagem' => 'Não foi encontrado resultado para a consultas!'];
            return response()->json($response, 402);
        }
        else{
            $response = array();
            $response = ['Status' => 'Sucesso','Resultado' => $data];
            return response()->json($response, 200);
        }
    }

    public function update(Request $request, $id)
    {
       
        if(!$this->link->find($id))
        {
            $response = array();
            $response = ['Status' => 'Erro','Mensagem' => 'Não foi encontrado resultado para a consultas!'];
            return response()->json($response, 402);
        }
        else{
            
            $link = $request->Link;
            DB::update('update links set Link = ? where Id = ?', [$link, $id]);
            $response = array();
            $response = ['Status' => 'Sucesso','Resultado' => 'Update realizado!'];
            return response()->json($response, 200);
        }
    }

    public function destroy($id)
    {
        if(!$data = $this->link->find($id))
        {
            $response = array();
            $response = ['Status' => 'Erro','Mensagem' => 'Não foi encontrado resultado para a consulta!'];
            return response()->json($response, 402);
        }
        else{
            $data = $this->link->find($id);
            DB::delete('delete from links where id = ?',[$id]);
            $response = array();
            $response = ['Status' => 'Sucesso','Resultado' => "Delete realizado!"];
            return response()->json($response, 200);
        }
    }
}
