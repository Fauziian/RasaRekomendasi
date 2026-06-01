<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ChefSchedule;
use App\Models\CommentRating;
use App\Models\Consultation;
use App\Models\Message;
use App\Models\Preference;
use App\Models\Recipe;
use App\Models\RecipeSave;
use App\Models\Tag;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VipPackage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            UserSeeder::class,
            VipPackageSeeder::class,
            RecipeSeeder::class,
            PreferenceSeeder::class,
            CommentRatingSeeder::class,
            TransactionSeeder::class,
            ChefScheduleSeeder::class,
            ConsultationSeeder::class,
        ]);
    }
}
