<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        $admin = \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'plain_code' => 'admin123',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // 2. Create Sample Groups
        $groupA = \App\Models\Group::create(['name' => 'Internal Division', 'description' => 'Staff and Internal Team']);
        $groupB = \App\Models\Group::create(['name' => 'Public Community', 'description' => 'General Community Members']);

        // 3. Create Sample Voters
        $voter1 = \App\Models\User::factory()->create(['name' => 'Alice Voter', 'username' => 'alice', 'plain_code' => 'alice123', 'password' => bcrypt('password'), 'is_admin' => false]);
        $voter2 = \App\Models\User::factory()->create(['name' => 'Bob Voter', 'username' => 'bob', 'plain_code' => 'bob123', 'password' => bcrypt('password'), 'is_admin' => false]);
        $voter3 = \App\Models\User::factory()->create(['name' => 'Charlie Voter', 'username' => 'charlie', 'plain_code' => 'charlie123', 'password' => bcrypt('password'), 'is_admin' => false]);

        $voter1->groups()->attach($groupA);
        $voter2->groups()->attach($groupA);
        $voter3->groups()->attach($groupB);

        // 4. Create Public Event
        $eventPublic = \App\Models\VotingEvent::create([
            'group_id' => null,
            'title' => 'Best General Project 2026',
            'description' => 'Vote for the best overall community project. Open to all users.',
            'start_time' => now()->subDay(),
            'end_time' => now()->addDays(7),
            'is_active' => true,
            'show_results' => true,
        ]);

        $eventPublic->options()->createMany([
            ['candidate_name' => 'Project Alpha', 'description' => 'AI based voting system'],
            ['candidate_name' => 'Project Beta', 'description' => 'Blockchain ledger'],
            ['candidate_name' => 'Project Gamma', 'description' => 'Quantum network'],
        ]);

        // 5. Create Group-Restricted Event (Internal Division only)
        $eventInternal = \App\Models\VotingEvent::create([
            'group_id' => $groupA->id,
            'title' => 'Internal Team Lead Election',
            'description' => 'Vote for the new Internal Division Team Lead.',
            'start_time' => now()->subDay(),
            'end_time' => now()->addDays(3),
            'is_active' => true,
            'show_results' => false, // Hidden results
        ]);

        $eventInternal->options()->createMany([
            ['candidate_name' => 'David Manager', 'description' => '5 years experience'],
            ['candidate_name' => 'Eve Coordinator', 'description' => 'Agile expert'],
        ]);
        
        // 6. Cast some sample votes
        \App\Models\Vote::create([
            'user_id' => $voter1->id,
            'voting_event_id' => $eventPublic->id,
            'option_id' => $eventPublic->options->first()->id,
        ]);
        \App\Models\Vote::create([
            'user_id' => $voter2->id,
            'voting_event_id' => $eventPublic->id,
            'option_id' => $eventPublic->options->last()->id,
        ]);
    }
}
