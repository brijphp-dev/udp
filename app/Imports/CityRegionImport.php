<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Queue\SerializesModels;
use App\Models\{Voter, City, State, Pollingward, Region};

HeadingRowFormatter::default('none');
class CityRegionImport implements ToModel, WithEvents, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    use Importable, RegistersEventListeners, SerializesModels;
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if( array_key_exists('Name', $row) && $row['Name'] != '' ){
            $cityName = City::whereRaw('LOWER(`name`)  like ? ',[trim(strtolower($row['Name']))])->get();
            if($cityName->isEmpty()){
                $city = new City();
                $city->name = trim($row['Name']);
                $city->save();
            }
        }
        if( array_key_exists('Region', $row) && $row['Region'] != '' ){
            $regionName = Region::whereRaw('LOWER(`name`)  like ? ',[trim(strtolower($row['Region']))])->get();
            if($regionName->isEmpty()){
                $region = new Region();
                $region->name = trim($row['Region']);
                $region->save();
            }
        }
    }
    public function headingRow(): int
    {
        return 1;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
