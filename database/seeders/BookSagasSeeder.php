<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSagasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookSagas')->insert([
            'name' => 'Hunger Games',
            'sinopsis' => 'La trilogía Los juegos del hambre, se lleva a cabo en un período de tiempo futuro no identificado después de la destrucción de los países actuales de América del Norte, en un país conocido como “Panem”. Panem está formado por un rico Capitolio, ubicado en lo que eran las Montañas Rocosas, y doce (antes trece) distritos que lo rodean, los distritos más pobres, que atienden a las necesidades del Capitolio, y los más ricos, que son los más favorecidos. Como castigo por una rebelión en contra de este último, en la que Capitolio derrotó a los doce primeros distritos y destruyó el decimotercero, cada año un chico y una chica de cada uno de los doce distritos restantes, entre doce y dieciocho años, son seleccionados por sorteo y obligados a participar en los “Juegos del Hambre”. Los juegos son un evento televisado donde los participantes, llamados “tributos”, deben luchar a muerte en un estadio al aire libre llamado “La Arena” hasta que sólo queda un vencedor. El tributo ganador y su distrito correspondiente, recibirán grandes riquezas y alimentos respectivamente.',
            'burningmeter' => 0.0,
            'readersScore' => 0.0,
        ]);
    }
}
