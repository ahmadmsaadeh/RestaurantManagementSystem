<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Feedback;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Reservation;
use App\Models\Role;
use App\Models\Table;
use App\Models\User;
use Illuminate\Console\Command;

class deleteRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all records from the table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Feedback::query()->delete();
        Order_item::query()->delete();
        Order::query()->delete();
        Reservation::query()->delete();
        Table::query()->delete();
        MenuItem::query()->delete();
        Category::query()->delete();
        User::query()->delete();
        Role::query()->delete();









        $this->info('All records deleted successfully');
    }
}
