<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;

use App\Situacao;
use App\Http\Controllers\Api\ExcecaoApiController;

class SituacaoController extends Controller
{
    public function __construct(Situacao $situacao) {
        $this->objeto = $situacao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ['data' => $this->objeto->paginate(200)];

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        try {

            if ($request->get('classe') == 'GERAL' || $request->get('classe') == 'TAREFA' ) {
                if (Situacao::verificaDescricao($request->get('descricao'))) {

                    return ExcecaoApiController::erro(
                        '406',
                        array('descricao' => $request->get('descricao')),
                        'Já existe uma situação com esta descrição.'
                    );
                } else {
                    $this->objeto->create($request->all());

                    return ExcecaoApiController::sucesso(
                        '201',
                        array('descricao' => $request->get('descricao')),
                        'Situação cadastrada com sucesso.'
                    );
                }
            } else {
                return ExcecaoApiController::erro(
                    '406',
                    array('classe' => $request->get('classe')),
                    'Classe de situação invalida, gentileza utilizar GERAL ou TAREFA'
                );
            }

        } catch (\Exeption $e) {

            return response()->json(['msg' => 'Ops... Erro ao gravar informação'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ['data' => $this->objeto->find($id)];
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        exit($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

           $dados = $this->objeto->find($id);

            if ($request->get('classe')) {

                if ($request->get('classe') != $dados->classe) {

                    return ExcecaoApiController::erro(
                        '406',
                        array('classe' => $request->get('classe')),
                        'Não é permitido alterar classe das situaçãoes, apenas a descrição'
                    );
                }
            }

            $dados->descricao = $request->get('descricao');
            $dados->save();

            return ExcecaoApiController::sucesso(
                '200',
                array('descricao' => $request->get('descricao')),
                'Situação autalizada com sucesso com sucesso.'
            );
        } catch (\Exeption $e) {

            return response()->json(['msg' => 'Ops... Erro ao gravar informação'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $dados = $this->objeto->find($id);

            $dados->utilizavel = 'N';
            $dados->save();

            return ExcecaoApiController::sucesso(
                '200',
                'Situação excluida com sucesso.'
            );
        } catch (\Exeption $e) {

            return response()->json(['msg' => 'Ops... Erro ao gravar informação'], 500);
        }

    }
}
