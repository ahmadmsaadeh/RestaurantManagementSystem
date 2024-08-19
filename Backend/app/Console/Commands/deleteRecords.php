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
use Illuminate\Support\Facades\DB;

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
        Feedback::query()->forceDelete();
        Order_item::query()->forceDelete();
        Order::query()->forceDelete();
        Reservation::query()->forceDelete();
        Table::query()->forceDelete();
        MenuItem::query()->forceDelete();
        Category::query()->forceDelete();
        User::query()->forceDelete();
        Role::query()->forceDelete();

// Reset auto-increment values using raw SQL
        $this->resetAutoIncrement('feedbacks');
        $this->resetAutoIncrement('order_items');
        $this->resetAutoIncrement('orders');
        $this->resetAutoIncrement('reservations');
        $this->resetAutoIncrement('tables');
        $this->resetAutoIncrement('menu_items');
        $this->resetAutoIncrement('categories');
        $this->resetAutoIncrement('users');
        $this->resetAutoIncrement('roles');

        $this->info('All records deleted and auto-increment values reset successfully');


    }
    /**
     * Reset the auto-increment value for a given table.
     *
     * @param string $table
     */
    protected function resetAutoIncrement($table)
    {
        DB::statement("ALTER TABLE $table AUTO_INCREMENT = 1");
    }
}
