<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MasterApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $data = $this->model->all();
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
        $this->validate($request, $this->model->regras());
        $data = $request->all();
        $data['LinkOriginal'] = $request->Link;
        $data['LinkEncurtado'] = $this->encurtaLink($request->Link);
        $data['NumeroDeAcessos'] = 0;
        if($data['Link'] == false)
        {
            return $response = ['Status' => 'Erro','Mensagem' => 'Url invalida!'];      
        }
        $data = $this->model->create($data);
        $response = array();
        $response = ['Status' => 'Sucesso','Resultado' => "Informações salvas!"];
        return response()->json($response, 200);
        }
    }

    public function show(Request $request ,$id)
    {
        if(!$data = $this->model->find($id))
        {
            $response = array();
            $response = ['Status' => 'Erro','Mensagem' => 'Não foi encontrado resultado para a consultas!'];
            return response()->json($response, 402);
        }
        else{

            $user = $_SERVER['HTTP_USER_AGENT'];
            $ip = $request->ip();

            DB::update('update links set Controles = ? where Id = ?', [$user, $ip, $id]);
            $response = array();
            $response = ['Status' => 'Sucesso','Resultado' => $data];
            return response()->json($response, 200);
        }
    }

    public function update(Request $request, $id)
    {
       
        if(!$this->model->find($id))
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
        if(!$data = $this->model->find($id))
        {
            $response = array();
            $response = ['Status' => 'Erro','Mensagem' => 'Não foi encontrado resultado para a consulta!'];
            return response()->json($response, 402);
        }
        else{
            $data = $this->model->find($id);
            DB::delete('delete from links where id = ?',[$id]);
            $response = array();
            $response = ['Status' => 'Sucesso','Resultado' => "Delete realizado!"];
            return response()->json($response, 200);
        }
    }

    public function encurtaLink($url)
    {     
        $url = "https://is.gd/create.php?format=simple&url=".$url."";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                             CURLOPT_URL=> $url,
                             CURLOPT_RETURNTRANSFER=>true,
                             CURLOPT_ENCODING=>"",
                             CURLOPT_MAXREDIRS=>10,
                             CURLOPT_TIMEOUT=>0,
                             CURLOPT_FOLLOWLOCATION=>true,
                             CURLOPT_HTTP_VERSION=>CURL_HTTP_VERSION_1_1,
                             CURLOPT_CUSTOMREQUEST=>"GET",
                             CURLOPT_POSTFIELDS=>"",
                             CURLOPT_HTTPHEADER=>array(
                                                       "Content-Type: application/json",
                                                       "cache-control: no-cache",
                                                       ),
                                                       ));

                $response = curl_exec($curl);
                curl_close($curl);
                                        
        if($response != 'Error: Please enter a valid URL to shorten')
		return $response;
        else
        return false;
        
    }
}
