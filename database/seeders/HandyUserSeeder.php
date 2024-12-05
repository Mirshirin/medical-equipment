<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HandyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        try {
            // Step 1: Fetch user meta data from the WordPress database
            $wordpressUsersMeta = DB::connection('wordpress')
                ->table('usermeta')
                ->where('meta_key', '=', 'gxuVAvVD_capabilities') // Only get meta data related to roles
                ->get();

            // Step 2: Insert role data into your application’s usermeta table
            foreach ($wordpressUsersMeta as $wpUserMeta) {
                $roles = unserialize($wpUserMeta->meta_value);  // Unserialize the role
                $role = key($roles);  // Get the role name (e.g., "administrator")

                DB::table('usermeta')->insert([
                    'user_id' => $wpUserMeta->user_id,
                    'meta_key' => $wpUserMeta->meta_key,
                    'meta_value' => $role,  // Store the role as a string (e.g., "administrator")
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Step 3: Fetch users from the WordPress database and insert them into your application’s users table
            $wordpressUsers = DB::connection('wordpress')->table('users')->get();
            foreach ($wordpressUsers as $wpUser) {
                DB::table('users')->insert([
                    'id' => $wpUser->ID,
                    'name' => $wpUser->user_login,
                    'email' => $wpUser->user_email,
                    'password' => $wpUser->user_pass, // Store WordPress hashed password
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Step 4: Update the role_id in the users table based on the role in usermeta and the roles table
            // This assumes you have a 'roles' table where role names like 'administrator', 'editor', etc., are mapped to 'role_id'
            DB::statement("
            UPDATE users u
            JOIN usermeta um ON u.id = um.user_id
            JOIN roles r ON r.wp_role_name = um.meta_value
            SET u.role_id = IFNULL(r.id, 6)
            WHERE um.meta_key = 'gxuVAvVD_capabilities' AND (u.role_id IS NULL OR u.role_id = '')
        ");
        


        } catch (\Exception $e) {
            echo "Error connecting to WordPress database: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}
