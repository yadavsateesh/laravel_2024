<?php

namespace App\Imports;

use App\Admin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class AdminImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
	
	public function model(array $row)
    {
        return new Admin([

            'name'     => $row['name'],

            'email'    => $row['email'], 

            'password' => Hash::make($row['password']),
			

        ]);

    }
}
