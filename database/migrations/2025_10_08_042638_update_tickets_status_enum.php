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
        // Update existing data first
        DB::table('tickets')->where('status', 'open')->update(['status' => 'pending']);
        DB::table('tickets')->where('status', 'closed')->update(['status' => 'completed']);
        
        // Modify the enum column
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['pending', 'scheduled', 'completed'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert existing data first
        DB::table('tickets')->where('status', 'pending')->update(['status' => 'open']);
        DB::table('tickets')->where('status', 'completed')->update(['status' => 'closed']);
        
        // Revert the enum column
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('status', ['open', 'pending', 'scheduled', 'closed'])->default('open')->change();
        });
    }
};
