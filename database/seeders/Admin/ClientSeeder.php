<?php

namespace Database\Seeders\Admin;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path(). '/seeders/Admin/Client.json';
        $str = file_get_contents($filePath);
        $json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true);
        foreach ($json as $value) {
            $rowdata = new Client();
            $rowdata->id = $value["id"];
            $rowdata->filename = $value["filename"];
            $rowdata->image = $value["image"];
            $rowdata->is_active = $value["is_active"];
            $rowdata->created_by = 0;
            $rowdata->updated_by = 0;
            $rowdata->save();
        }
    }

}
