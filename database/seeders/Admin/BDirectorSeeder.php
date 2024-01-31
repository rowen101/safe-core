<?php

namespace Database\Seeders\Admin;

use App\Models\BDirector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BDirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = database_path(). '/seeders/Admin/BDirector.json';
        $str = file_get_contents($filePath);
        $json = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str), true);
        foreach ($json as $value) {
            $rowdata = new BDirector();
            $rowdata->id = $value["id"];
            $rowdata->name = $value["name"];
            $rowdata->image = $value["image"];
            $rowdata->position = $value["position"];
            $rowdata->about = $value["about"];
            $rowdata->org_type = $value["org_type"];
            $rowdata->is_social = $value["is_social"];
            $rowdata->fb = $value["fb"];
            $rowdata->tw = $value["tw"];
            $rowdata->linkin = $value["linkin"];
            $rowdata->instagram = $value["instagram"];
            $rowdata->fb_url = $value["fb_url"];
            $rowdata->tw_url = $value["tw_url"];
            $rowdata->linkin_url = $value["linkin_url"];
            $rowdata->instagram_url = $value["instagram_url"];
            $rowdata->is_active = $value["is_active"];
            $rowdata->created_by = 0;
            $rowdata->updated_by = 0;
            $rowdata->save();
        }
    }

}
