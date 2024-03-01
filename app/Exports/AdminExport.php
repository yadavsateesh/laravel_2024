<?php

namespace App\Exports;

use App\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AdminExport implements FromCollection, WithHeadings
{
    /**
		* @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       
		 return Admin::select("id", "name", "email","password")->get();
    }
	
	/**

     * Write code on Method

     *

     * @return response()

     */

    public function headings(): array

    {

        return ["ID", "Name", "Email","password"];

    }
}
