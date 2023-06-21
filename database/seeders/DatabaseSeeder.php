<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ProvinceSeeder::class);
        $this->call(CityAcehSeeder::class);
        $this->call(CityBaliSeeder::class);
        $this->call(CityBantenSeeder::class);
        $this->call(CityBengkuluSeeder::class);
        $this->call(CityDaerahIstimewaYogyakartaSeeder::class);
        $this->call(CityDaerahKhususIbukotaJakartaSeeder::class);
        $this->call(CityGorontaloSeeder::class);
        $this->call(CityJambiSeeder::class);
        $this->call(CityJawaBaratSeeder::class);
        $this->call(CityJawaTengahSeeder::class);
        $this->call(CityJawaTimurSeeder::class);
        $this->call(CityKalimantanBaratSeeder::class);
        $this->call(CityKalimantanSelatanSeeder::class);
        $this->call(CityKalimantanTengahSeeder::class);
        $this->call(CityKalimantanTimurSeeder::class);
        $this->call(CityKalimantanUtaraSeeder::class);
        $this->call(CityKepulauanBangkaBelitungSeeder::class);
        $this->call(CityKepulauanRiauSeeder::class);
        $this->call(CityLampungSeeder::class);
        $this->call(CityMalukuSeeder::class);
        $this->call(CityMalukuUtaraSeeder::class);
        $this->call(CityNusaTenggaraBaratSeeder::class);
        $this->call(CityNusaTenggaraTimurSeeder::class);
        $this->call(CityPapuaSeeder::class);
        $this->call(CityPapuaBaratSeeder::class);
        $this->call(CityRiauSeeder::class);
        $this->call(CitySulawesiBaratSeeder::class);
        $this->call(CitySulawesiSelatanSeeder::class);
        $this->call(CitySulawesiTengahSeeder::class);
        $this->call(CitySulawesiTenggaraSeeder::class);
        $this->call(CitySulawesiUtaraSeeder::class);
        $this->call(CitySumateraBaratSeeder::class);
        $this->call(CitySumateraSelatanSeeder::class);
        $this->call(CitySumateraUtaraSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(SourceSeeder::class);
        $this->call(BankSeeder::class);
    }
}
