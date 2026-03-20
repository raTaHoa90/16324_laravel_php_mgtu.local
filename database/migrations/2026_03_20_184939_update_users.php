<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('group_role')->default(0);
        });

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin',
            'password' => '123123',
            'group_role' => User::ROLE_ADMINISTRATOR
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        User::Where('email', 'admin@admin')->delete();

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('group_role');
        });
    }
};
