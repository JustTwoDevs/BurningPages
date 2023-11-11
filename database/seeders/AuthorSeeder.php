<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            'name' => 'Gabriel José de la Concordia',
            'lastname' => 'García Márquez',
            'pseudonym' => 'Gabo',
            'birth_date' => '1927-03-06',
            'death_date' => '2014-04-17',
            'biography' => 'Escritor y periodista colombiano. Reconocido principalmente por sus novelas y cuentos, también escribió narrativa de no ficción, discursos, reportajes, críticas cinematográficas y memorias. Estudió derecho y periodismo en la Universidad Nacional de Colombia e inicio sus primeras colaboraciones periodísticas en el diario El Espectador. Fue conocido como Gabo, y familiarmente y por sus amigos como Gabito. En 1982 recibió el Premio Nobel de Literatura «por sus novelas e historias cortas, en las que lo fantástico y lo real se combinan en un mundo ricamente compuesto de imaginación, lo que refleja la vida y los conflictos de un continente».\nJunto a Julio Cortázar, Mario Vargas Llosa y Carlos Fuentes, fue uno de los exponentes centrales del boom latinoamericano. También está considerado uno de los principales autores del realismo mágico, y su obra más conocida, la novela Cien años de soledad, es considerada una de las más representativas de esa corriente literaria, e incluso se considera que se debe al éxito de la novela el hecho de que el término se aplique a la literatura surgida a partir de 1960 en América Latina.​ En 2007 la Real Academia Española y la Asociación de Academias de la Lengua Española publicaron una edición popular conmemorativa de esta obra, por considerarla parte de los grandes clásicos hispánicos de todos los tiempos.',
            'nationality_id' => 1,
        ]);

        DB::table('authors')->insert([
            'name' => 'Mario',
            'lastname' => 'Mendoza Zambrano',
            'pseudonym' => 'Mario Mendoza',
            'birth_date' => '1964-01-06',
            'death_date' => null,
            'biography' => 'Escritor, catedrático y periodista colombiano. Es considerado uno de los mayores escritores del realismo degradado de la época.',
            'nationality_id' => 1,
        ]);

        DB::table('authors')->insert([
            'name' => 'Suzanne',
            'lastname' => 'Collins',
            'pseudonym' => 'Suzanne Collins',
            'birth_date' => '1962-08-10',
            'death_date' => null,
            'biography' => 'La carrera de Suzanne empezó en 1991 como guionista en programas de televisión para niños trabajando para canales como Nickelodeon. Mientras trabajaba en el programa Generation O! de Kids WBOOK, conoció al escritor de libros para niños James Plumiew quien la inspiró a escribir libros infantiles por su cuenta.',
            'nationality_id' => 2,
        ]);
    }
}
