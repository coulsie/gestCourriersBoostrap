<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    public function run(): void
    {
        $year = now()->year;

        // Calcul de la date de Pâques pour les jours mobiles
        $easter = Carbon::createFromTimestamp(easter_date($year));

        $holidays = [
            ['name' => 'Jour de l’An', 'date' => Carbon::create($year, 1, 1)],
            ['name' => 'Lundi de Pâques', 'date' => $easter->copy()->addDay()],
            ['name' => 'Fête du Travail', 'date' => Carbon::create($year, 5, 1)],
            ['name' => 'Fête de Tabaski', 'date' => $easter->copy()->addDay()],
            ['name' => 'Fête de ramadan', 'date' => $easter->copy()->addDay()],
            ['name' => 'Nuit du destin', 'date' => $easter->copy()->addDay()],
            ['name' => 'Anniversaire de Mahomet', 'date' => $easter->copy()->addDay()],
            ['name' => 'Mahoulid', 'date' => $easter->copy()->addDay()],
            ['name' => 'Ascension', 'date' => $easter->copy()->addDays(39)],
            ['name' => 'Lundi de Pentecôte', 'date' => $easter->copy()->addDays(50)],
            ['name' => 'Fête Nationale', 'date' => Carbon::create($year, 8, 7)],
            ['name' => 'Assomption', 'date' => Carbon::create($year, 8, 15)],
            ['name' => 'Toussaint', 'date' => Carbon::create($year, 11, 1)],
            ['name' => 'Journée de la paix', 'date' => Carbon::create($year, 11, 15)],
            ['name' => 'Noël', 'date' => Carbon::create($year, 12, 25)],
        ];

        foreach ($holidays as $holiday) {
            Holiday::updateOrCreate(
                ['holiday_date' => $holiday['date']->toDateString()],
                ['name' => $holiday['name'], 'is_recurring' => true]
            );
        }
    }
}
