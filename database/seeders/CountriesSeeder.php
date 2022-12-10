<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CountriesSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->insertData();
    }

    public function insertData()
    {
        $csvData = collect($this->getDataCsvToArray());
        $csvData->each(function ($column, $keyColumn) {
            if($keyColumn > 0) {
                \DB::table('countries')->insert([
                    'country'       => $column[0],
                    'alpha_2_code'  => $column[1],
                    'alpha_3_code'  => $column[2],
                    'numeric_code'  => $column[3],
                    'lat'           => $column[4],
                    'long'          => $column[5],
                    'created_at'    => date('Y-m-d'),
                    'updated_at'    => date('Y-m-d')
                ]
                );
            }
        });
    }

    private function getDataCsvToArray()
    {
        $csvFile = $this->getCsvFile();
        $csvDataArray = [];
        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csvDataArray[] = $data;
            }
            fclose($handle);
        }
        return $csvDataArray;
        // throw new \Exception(json_encode($csvData));
    }

    private function getCsvFile()
    {
        $csvFile = Storage::disk('public')->path("countries_codes_and_coordinates.csv");
        return $csvFile;
    }
}
