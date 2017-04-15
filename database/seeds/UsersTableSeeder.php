<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds. The used factory is defined in ModelFactory.php under database/factories.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Data\Model\User::class, 5)->create();
    }
}
