<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the images table if it exists
        Schema::dropIfExists('images');

        // Drop the users table if it exists
        Schema::dropIfExists('users');
    }

    public function down(): void
    {
        // Check if the foreign key exists before trying to drop it
        $foreignKeys = DB::select("SELECT * FROM information_schema.TABLE_CONSTRAINTS WHERE CONSTRAINT_SCHEMA = 'your_database_name' AND TABLE_NAME = 'images' AND CONSTRAINT_NAME = 'images_user_id_foreign'");

        if (count($foreignKeys) > 0) {
            Schema::table('images', function (Blueprint $table) {
                $table->dropForeign('images_user_id_foreign');
            });
        }

        // The rest of your down method...
    }
};
