<?php

namespace App\Imports;

// use App\Models\User;

use App\Http\Controllers\admin\ImportController;
use App\Qlib\Qlib;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ShouldQueue;

class ImportAll implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    protected $tabs;

    public function __construct(array $tab)
    {
        $this->tabs = $tab;
    }
    public function collection(Collection $rows)
    {
        $data = [];
        $ret = [];
        // if($this->tab=='lcf_entradas'){
        //     $ret = (new ImportController)->inport_nubank_lcf_entradas($rows);
        // }
        $ret = (new ImportController)->inport_nubank_entradas_saidas($rows,$this->tabs);
        // dd($ret);
        return $ret;
        // Inserção em lote (bulk insert)
        // DB::table('users')->insert($data);
    }
}
