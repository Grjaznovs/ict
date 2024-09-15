<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $folder = base_path() . '/database/seeders/tablecsv/';
        $files = [
            Category::class  => ['file' => 'c_categories.csv', 'key' => 'code']
        ];

        foreach ($files as $className => $fileConfig) {
            dump($fileConfig['file']);
            if (($handle = fopen($folder . "/" . $fileConfig['file'], "r")) !== FALSE) {
                $headers = null;
                while (($row = fgetcsv($handle, 0, ";")) !== FALSE) {
                    if ($headers) {
                        $insertRow = [];
                        foreach ($headers as $key => $value) {
                            if (isset($row[$key]) && $row[$key] != '') {
                                $insertRow[$value] = $row[$key];
                            } else {
                                $insertRow[$value] = null;
                            }
                        }

                        $className::updateOrCreate(
                            ['code' => $insertRow['code']],
                            [
                                'name' => $insertRow['name'],
                                'order' => $insertRow['order']
                            ]
                        );
                    } else {
                        $headers = $row;
                    }
                }
            } else {
                dump("File not found :`" . $fileConfig['file'] . "`");
            }
        }
    }
}
