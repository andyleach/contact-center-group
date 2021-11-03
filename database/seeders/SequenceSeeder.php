<?php

namespace Database\Seeders;

use App\Models\Sequence\Sequence;
use App\Models\Sequence\SequenceAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class SequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sequence = Sequence::factory()->create();

        $sequenceActionsCollection = new Collection();
        for ($i = 1; $i < 5; $i++) {
            $sequenceAction = SequenceAction::factory()->for($sequence)->create([
                'ordinal_position' => $i
            ]);

            $sequenceActionsCollection->push($sequenceAction);
        }
    }
}
