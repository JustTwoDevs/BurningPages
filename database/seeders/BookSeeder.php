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

        DB::table('books')->insert([
            'title' => 'The Hunger Games',
            'sinopsis' => 'Los Juegos del Hambre (título original en inglés: The Hunger Games) es el primer libro de la trilogía homónima escrita por la autora estadounidense Suzanne Collins. La editorial Scholastic Press lo publicó el 14 de septiembre de 2008. Se trata de una novela de aventura y ciencia ficción narrada en primera persona desde la perspectiva de Katniss Everdeen, una adolescente de dieciséis años que vive en Panem, una nación postapocalíptica ubicada en lo que anteriormente era América del Norte. El libro muestra en mayor parte las experiencias vividas por ella en «Los Juegos del Hambre», un evento anual realizado en Panem donde un chico y una chica, de cada distrito con edades comprendidas entre los doce y los dieciocho años, deberán luchar a muerte entre ellos mientras son observados por televisión nacional.',
            'publication_date' => '2008-09-14',
            'original_language' => 'English',
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => 'https://www.amazon.com/Hunger-Games-Book/dp/B002MQYOFW',
        ]);

        DB::table('books')->insert([
            'title' => 'Catching Fire',
            'sinopsis' => 'Catching Fire is a 2009 science fiction young adult novel by the American novelist Suzanne Collins, the second book in The Hunger Games series. As the sequel to the 2008 bestseller The Hunger Games, it continues the story of Katniss Everdeen and the post-apocalyptic nation of Panem. Following the events of the previous novel, a rebellion against the oppressive Capitol has begun, and Katniss and fellow tribute Peeta Mellark are forced to return to the arena in a special edition of the Hunger Games.',
            'publication_date' => '2009-09-01',
            'original_language' => 'English',
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => 'https://www.amazon.com/Catching-Fire-Hunger-Games-Book/dp/B002MQYOFW',
        ]);

        DB::table('books')->insert([
            'title' => 'Mockingjay',
            'sinopsis' => 'Mockingjay is a 2010 science fiction novel by American author Suzanne Collins. It is the last installment of The Hunger Games, following 2008\'s The Hunger Games and 2009\'s Catching Fire. The book continues the story of Katniss Everdeen, who agrees to unify the districts of Panem in a rebellion against the tyrannical Capitol.',
            'publication_date' => '2010-08-24',
            'original_language' => 'English',
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => 'https://www.amazon.com/Mockingjay-Hunger-Games-Book/dp/B003XF1XOQ',
        ]);

        DB::table('books')->insert([
            'title' => 'The Ballad of Songbirds and Snakes',
            'sinopsis' => 'The Ballad of Songbirds and Snakes is a dystopian action-adventure novel by American author Suzanne Collins. It is a spinoff and a prequel to The Hunger Games trilogy. It was released May 19, 2020, published by Scholastic. The book received a virtual launch due to its release coinciding with the COVID-19 pandemic.',
            'publication_date' => '2020-05-19',
            'original_language' => 'English',
            'burningmeter' => 0,
            'readersScore' => 0,
            'buyLink' => 'https://www.amazon.com/Ballad-Songbirds-Snakes-Hunger-Games/dp/1338635174',
        ]);
    }
}
