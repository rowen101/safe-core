<?php

namespace Database\Seeders\Admin;

use App\Models\AppUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path(). '/seeders/Admin/AppUser.json';
        $str = file_get_contents($filePath);
        $json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true);
        foreach ($json as $value) {
            $rowdata = new AppUser();
            $rowdata->id = $value["id"];
            $rowdata->user_id = $value["user_id"];
            $rowdata->app_id = $value["app_id"];
            $rowdata->is_active = $value["is_active"];
            $rowdata->created_by = 0;
            $rowdata->updated_by = 0;
            $rowdata->save();
        }
    }

}
