<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ImportWordpressUsersSeede extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
            //   // Check if WordPress database connection exists
            //   $wordpressConnection = config('database.connections.wordpress');
        
            //   if (!$wordpressConnection || !isset($wordpressConnection['driver'])) {
            //       throw new \Exception("WordPress database connection is not properly configured.");
            //   }
      
    //           try {
    //               // Attempt to get the PDO instance for the WordPress connection
    //               DB::connection('wordpress')->getPdo();
      
    //               // If no exception was thrown, the connection is working
    //               echo "Successfully connected to WordPress database.\n";
      
    //               // Your seeding logic here
    //     // اتصال به دیتابیس وردپرس
    //  //   $wordpressUsers = DB::connection('wordpress')->table('users')->get();
    //  //   dd( $wordpressUsers);
    //     // 
    

    //     } catch (\Exception $e) {
    //         echo "Error connecting to WordPress database: " . $e->getMessage() . "\n";
    //         throw $e;
    //     }
    }
}
