<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('order_statuses')->insert([
            ['name' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'processing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'shipped', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'completed', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'cancelled', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
