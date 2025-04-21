<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\admin\FinanceiroController as AdminFinanceiroController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isArray;

class FinanceiroController extends Controller
{
    private $Fc;
    public function __construct()
    {
        $this->Fc = new AdminFinanceiroController;
    }
    public function index(Request $request){
        $dados = $request->all();
        $sec2 = $request->segment(4);
        $query = $this->Fc->queryContas($dados,$sec2);
        // $campos = $this->Fc->campos(false,false,$sec2);
        $ret = $query;
        if(isset($query['contas']) && isset($query['campos'])){
            // dd($campos,$query);
            $arr = [];
            foreach ($query['contas'] as $k => $v) {
                if(is_object($v)){
                    // dump($query['contas'],$query['campos'],$v);
                    foreach ($query['campos'] as $k1 => $v1) {
                        if(isset($v1['active']) && $v1['active']){
                            // dump();
                            $arr[$k][$k1] = $v1;
                            $arr[$k][$k1]['value'] = $v[$k1];
                        }
                    }
                }
            }
            $ret['dados_table'] = $arr;
        }
        return $ret;
    }
}
