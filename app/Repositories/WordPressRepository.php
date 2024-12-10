<?php
// در مسیر app/Repositories/WordPressRepository.php
namespace App\Repositories;

use App\Models\Brand;
use App\Models\Country;
use App\Models\MedicalSpecialty;

class WordPressRepository
{
    public function saveCountries($countries)
    {
        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['name' => $country['name']],
                ['name' => $country['name']]
            );
        }
    }

    public function saveBrands($brands)
    {
        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['name' => $brand['name']],
                ['name' => $brand['name']]
            );
        }
    }

    public function saveMedicalSpecialty($medicalSpecialties)
    {
        foreach ($medicalSpecialties as $$medicalSpecialty) {
            MedicalSpecialty::updateOrCreate(
                ['name' => $medicalSpecialty['name']],
                ['name' => $medicalSpecialty['name']]
            );
        }
    }
}
