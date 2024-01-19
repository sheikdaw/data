<?php

namespace App\Imports;

use App\Models\mis;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new mis([
            'road_name' => $row[0],
            'assessment'=>$row[1],
            'old_assessment'=>$row[2],
            'owner_name'=>$row[3],
            'old_door_number'=>$row[4],
            'mobile'=>$row[5],
            'building_usage'=>$row[6],
            'ward'=>$row[7],
            'workername'=>$row[8],
             ]);
    }
}
