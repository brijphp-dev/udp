<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\{Country, State, City, Region, Ethnicity};

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getCountryId($countryName)
    {
        $countryDetail = Country::where('name', $countryName)->get();
        if($countryDetail && sizeof($countryDetail) > 0){
            return $countryDetail[0]->id;
        }
        return 15;
    }

    public function getstateId($stateName)
    {
        $stateDetail = State::where('name', $stateName)->get();
        if($stateDetail && sizeof($stateDetail) > 0){
            return $stateDetail[0]->id;
        }
        return 1;
    }

    public function getCountryName($countryId)
    {
        $countryDetail = Country::where('id', $countryId)->get();
        if($countryDetail){
            return $countryDetail[0]->name;
        }
        return 15;
    }

    public function getstateName($stateId)
    {
        $stateDetail = State::where('id', $stateId)->get();
        if($stateDetail){
            return $stateDetail[0]->name;
        }
        return 1;
    }

    public function getChapterId($chapter)
    {
        # code...
    }

    public function getCityName($cityId)
    {
        $cityDetail = City::where('id', $cityId)->get();
        if($cityDetail){
            return $cityDetail[0]->name;
        }
        return 1;
    }

    public function getRegionName($regionId)
    {
        $regionDetail = Region::where('id', $regionId)->get();
        if($regionDetail){
            return $regionDetail[0]->name;
        }
        return 1;
    }

    public function getEthnicityName($ethnicityId)
    {
        $ethnicityDetail = Ethnicity::where('id', $ethnicityId)->get();
        if($ethnicityDetail){
            return $ethnicityDetail[0]->ename;
        }
        return 1;
    }
}
