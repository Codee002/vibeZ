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
            $table->string('username')->after('name')->change();
            $table->string('password')->after('username')->change();
            $table->enum("gender", ['male', 'female'])->nullable()->after('email_verified_at')->change();
            $table->date('birthday')->nullable()->after('gender')->change();
            $table->string('avatar')->nullable()->after('birthday')->change();
            $table->string('role')->default(User::TYPE_MEMBER)->after('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
