<?php

use Illuminate\Database\Seeder;

class ContactNumberseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numberTypes = [
            ['type' => 'Mobile Number'],
            ['type' =>  'Home Number'],
            ['type' =>  'Office Number']
        ];

        foreach ($numberTypes as $record){
            DB::table('contact_number_type')->insert([
                'label' => $record['type']
            ]);
        }
    }
}
