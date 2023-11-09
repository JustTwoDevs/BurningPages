<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            'title' => 'Cien años de soledad',
            'sinopsis' => 'The work tells the story of the Buendía family over seven generations in the fictional town of Macondo. The novel shows the history of the Macondo civilization from its origins to its destruction along with the last of its founding lineages. The novel is considered a masterpiece of the Latin American boom and the 20th century.',
            'publication_date' => '1967-06-05',
            'original_language' => 'Spanish',
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => 'https://www.amazon.com/Cien-a%C3%B1os-soledad-Spanish-Edition/dp/0307474720',
        ]);


        DB::table('books')->insert([
            'title' => 'Crónica de una muerte anunciada',
            'sinopsis' => 'A man returns to the town where a baffling murder took place 27 years earlier, determined to get to the bottom of the story.\n\nJust hours after marrying the beautiful Angela Vicario, everyone agrees, Bayardo San Roman returned his bride in disgrace to her parents. Her distraught family forced her to name her first lover; and her twin brothers announced their intention to murder Santiago Nasar for dishonoring their sister.\n\nYet if everyone knew the murder was going to happen, why did no one intervene to stop it? The more that is learned, the less is understood, and as the story races to its inexplicable conclusion, an entire society--not just a pair of murderers—is put on trial.',
            'publication_date' => '1981-01-01',
            'original_language' => 'Spanish',
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => 'https://www.amazon.com/Cr%C3%B3nica-muerte-anunciada-Spanish/dp/1400034957',
        ]);

        DB::table('books')->insert([
            'title' => 'Satanás',
            'sinopsis' => 'A beautiful and naive woman who skillfully steals from top executives, a painter inhabited by mysterious forces and a priest who faces a case of demonic possession in La Candelaria, stories that are woven around that of Campo Elías, hero of the Vietnam War, who begins his particular descent into hell obsessed by the duality between good and evil, between Jekyll and Hyde, and will become an exterminating angel.\n\nAwarded the 2002 Biblioteca Breve Prize, Satan confirms Mario Mendoza as one of the greatest exponents of the new Colombian narrative, a literature that has separated itself from magical realism and has discovered new voices for a new reality.',
            'publication_date' => '2002-01-01',
            'original_language' => 'Spanish',
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => 'https://www.amazon.com/-/es/Satanas-audiolibro/dp/B078NFHL91/ref=sr_1_1?__mk_es_US=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=2661K5JESCO3H&keywords=satanas+mario&qid=1699496422&s=books&sprefix=satanas+mario%2Cstripbooks-intl-ship%2C239&sr=1-1',
        ]);
    }
}
