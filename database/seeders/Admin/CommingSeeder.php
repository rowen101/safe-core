<?php

namespace Database\Seeders\Admin;


use App\Models\Comimgprofile;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CommingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path(). '/seeders/Admin/ComimgProfile.json';
        $str = file_get_contents($filePath);
        $json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true);
        foreach ($json as $value) {
            $rowdata = new Comimgprofile();
            $rowdata->id = $value["id"];
            $rowdata->company_img = $value["company_img"];
            $rowdata->is_active = $value["is_active"];
            $rowdata->save();
        }
    }

}
