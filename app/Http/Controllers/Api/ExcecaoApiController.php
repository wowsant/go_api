<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExcecaoApiController extends Controller
{
    static function erro($codigoHttp, $dados = array(), $msg ='') {
        switch ($codigoHttp) {
            case '406':
                return response()->json([
                    'retorno' => [
                        'msg' => 'Erro ao gravar informação, processo não realizado.',
                        'info' => !empty($msg) ? $msg : '',
                    ],
                    'dadosInvalidos' => $dados,
                ], 406);
                break;

            default:
                return response()->json([
                    'mensagem' => 'Erro ao gravar informação, processo não realizado',
                ], 500);
                break;
        }

    }
    static function sucesso($dados = array(), $msg ='') {

        return response()->json([
            'retorno' => [
                'msg' => 'Processo realizado com sucesso.',
                'info' => !empty($msg) ? $msg : '',
            ],
        ], 201);
    }
}
