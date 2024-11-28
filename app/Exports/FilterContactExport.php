<?php

namespace App\Exports;

use App\Models\CustomerContact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FilterContactExport implements FromCollection, WithHeadings
{
    /* use Exportable; */

    public $data;
    public function __construct( $filter_data)
    {
        $this->data = $filter_data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data['data_to_download'];
    }

    public function headings(): array
    {
        return $this->data['headings'];
    }
}
