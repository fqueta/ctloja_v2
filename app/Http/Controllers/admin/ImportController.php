<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\ImportAll;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Qlib\Qlib;

class ImportController extends Controller
{
    public function import(Request $request)
    {
        // $request->validate([
        //     'file' => 'required|mimes:xls,xlsx',
        // ]);

        // Excel::import(new UsersImport, $request->file('file'));
        $request->validate([
            'file' => 'required|mimes:csv,txt',
            'tab' => 'required',
        ]);
        $tab = $request->input('tab') ? $request->input('tab') : 'lcf_entradas';
        Excel::import(new ImportAll($tab), $request->file('file'));

        // return back()->with('success', 'Produtos importados com sucesso!');
        return back()->with('success', 'Importação concluída!');
    }
    public function inport_nubank_lcf_entradas($dados=[]){
        $ret['exec'] = false;
        $ret['color'] = 'danger';
        $ret['mens'] = 'Erro ao importar';
        $data_geral = [];
        $tab = 'lcf_entradas';
        // dd(is_object($dados),$dados);
        if(is_object($dados)){
            $insert = [];
            foreach ($dados as $row) {
                if(isset($row['valor']) && $row['valor'] > 0){
                    $id_conta = 2; //banco
                    $token = @$row['identificador']; //banco
                    $data = [
                        'token' => $token,
                        'valor_pago' => @$row['valor'],
                        'valor' => @$row['valor'],
                        'conta' => $id_conta,
                        'descricao' => @$row['descricao'],
                        'numero' => '',
                        'tag' => 'Banco Nubank',
                        'tipo' => 'entrada',
                        'data_pagamento' => Qlib::dtBanco(@$row['data']),
                        'atualizado' => Qlib::dtBanco(@$row['data']),
                        'emissao' => Qlib::dtBanco(@$row['data']),
                        'vencimento' => Qlib::dtBanco(@$row['data']),
                        'nome' => '',
                        'obs' => '',
                        'obs_pagamento' => '',
                        'historico' => '',
                        'historico_estorno' => '',
                        'prazo' => 0,
                        'periodo_repete' => 0,
                        'operador' => 0,
                        'id_fatura_fixa' => 0,
                        'forma_pagameto' => 0,
                        'token_fatura_dividir' => '',
                        'registro_geradas_fixa' => '',
                        'token_transf' => '',
                        'ref_compra' => '',
                        'local' => 'import csv',
                        'reg_asaas' => '',
                        'reg_excluido' => '',
                        'reg_deletado' => '',
                        'dividir' => '',
                        'id_cliente' => 0,
                        'id_responsavel' => 0,
                        'vezes' => 0,
                        'categoria' => 51, //servicos
                        'pago' => 's',
                        // 'created_at' => now(),
                        'autor' => 'sis',
                        'data' => now(),
                    ];
                    $data_geral[] = $data;
                    $insert = Qlib::update_tab($tab,$data,"WHERE token='$token'");
                    if($insert['exec']){
                        $ret = $insert;
                    }
                }
            }
            $ret['data'] = $data_geral;
        }
        return $ret;
    }
    public function form_import(Request $request){
        $d = $request->all();
        return view('clientes.import',$d);
    }
    public function form_import_all(Request $request){
        $d = $request->all();
        $d['titulo'] = __('Importação de arquivos');
        return view('config.import_all',$d);
    }
}
