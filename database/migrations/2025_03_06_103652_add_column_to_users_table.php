<?php

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
            $table->enum("email_active",['1', '0'])->default('0')->after("email");
            $table->string("email_token")->nullable()->after("email_active");
            $table->enum("two_step_auth",['1', '0'])->default('0')->after("email_token");
            $table->string("login_token")->nullable()->after("two_step_auth");
            $table->enum("status",['actived', 'locked'])->default('actived')->after("login_token");
            $table->string('phone')->nullable()->after('status');
            $table->dropColumn('avatar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn("email_active");
            $table->dropColumn("email_token");
            $table->dropColumn("two_step_auth");
            $table->dropColumn("login_token");
            $table->dropColumn("status");
            $table->dropColumn('phone');
            $table->string('avatar')->nullable();
        });
    }
};
