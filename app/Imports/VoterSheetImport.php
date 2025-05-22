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
use App\Models\{Voter, City, State, Pollingward, Region, Ethnicity};


HeadingRowFormatter::default('none');
class VoterSheetImport implements ToModel, WithEvents, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    use Importable, RegistersEventListeners, SerializesModels;
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $cityId = 0;
        $cityName = City::whereRaw('LOWER(`name`)  like ? ',[trim(strtolower($row['City']))])->get();
        if($cityName->isNotEmpty()){
            $cityId = $cityName[0]->id;
        }else{
            $city = new City();
            $city->name = trim($row['City']);
            $city->save();
            $cityId = $city->id;
        }

        $regionId = 0;
        $regionName = Region::whereRaw('LOWER(`name`)  like ? ',[trim(strtolower($row['Region']))])->get();
        if($regionName->isNotEmpty()){
            $regionId = $regionName[0]->id;
        }else{
            $region = new Region();
            $region->name = trim($row['Region']);
            $region->save();
            $regionId = $region->id;
        }

        $pollingWardId = 0;
        $pollingWardName = Pollingward::whereRaw('LOWER(`name`)  like ? ',[trim(strtolower($row['Ward']))])->get();
        if($pollingWardName->isNotEmpty()){
            $pollingWardId = $pollingWardName[0]->id;
        }else{
            $pollingWard = new Pollingward();
            $pollingWard->name = trim($row['Ward']);
            $pollingWard->save();
            $pollingWardId = $pollingWard->id;
        }

        $stateId = 0;
        if( array_key_exists('State', $row) ){
            $stateName = State::whereRaw('LOWER(`name`)  like ? ',[trim(strtolower($row['State']))])->get();
            if($stateName->isNotEmpty()){
                $stateId = $stateName[0]->id;
            }else{
                $state = new State();
                $state->name = trim($row['State']);
                $state->country_id = ( array_key_exists('Country', $row) && strtolower($row['Country']) =='the gambia' ) ? 3 : ( ( strtolower($row['Country']) == 'usa') ? 1 : 2 );
                $state->save();
                $stateId = $state->id;
            }
        }

        $ethnicity = 17;
        if ($row['Ethnicity'] != '') {
            $dbEthnicity = Ethnicity::whereRaw('LOWER(`ename`)  like ? ',[trim(strtolower($row['Ethnicity']))])->get();
            if($dbEthnicity->isNotEmpty()){
                $ethnicity = $dbEthnicity[0]->id;
            }else{
                $addEthnicity = new Ethnicity();
                $addEthnicity->ename = trim($row['Ward']);
                $addEthnicity->save();
                $ethnicity = $addEthnicity->id;
            }
        }

        return new Voter([
            'first_name' => $row['FirstName'],
            'last_name' => $row['LastName'],
            'email' => $row['Email'],
            'phone' => $row['Phone'],
            'address' => ( array_key_exists('Address', $row) ) ? $row['Address'] : '',
            'city' => $cityId, //( array_key_exists('Address', $row) ) ? $row['Address'] : '',
            'region' => $regionId,
            'ethnicity' => $ethnicity,
            'constituency' => $row['Constituency'],
            'polling_ward' => $pollingWardId,
            'polling_station' => $row['PollingStation'],
            'state' => $stateId,
            'post_code' => ( array_key_exists('PostCode', $row) ) ? $row['PostCode'] : '',
            'country' => ( array_key_exists('Country', $row) && strtolower($row['Country']) =='the gambia' ) ? 3 : ( ( strtolower($row['Country']) == 'usa') ? 1 : 2 ),
            'gender' => ( array_key_exists('Gender', $row) && $row['Gender'] == 'Male' ) ? 'Male' : 'Female',
            'voter_card' => ( array_key_exists('VoterID', $row) ) ? $row['VoterID'] : '',
        ]);
    }

    public function headingRow(): int
    {
        return 2;
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
