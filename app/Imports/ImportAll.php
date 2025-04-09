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
    protected $tab;

    public function __construct(string $tab)
    {
        $this->tab = $tab;
    }
    public function collection(Collection $rows)
    {
        $data = [];
        $ret = [];
        // dd($rows);
        if($this->tab=='lcf_entradas'){
            $ret = (new ImportController)->inport_nubank_lcf_entradas($rows);
        }
        dd($ret);
        // Inserção em lote (bulk insert)
        // DB::table('users')->insert($data);
    }
}
