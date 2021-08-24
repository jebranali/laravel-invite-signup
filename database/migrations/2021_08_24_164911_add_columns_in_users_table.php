<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_name')->after('name');
            $table->text('avatar')->nullable()->after('user_name');
            $table->string('user_role')->after('avatar');
            $table->timestamp('registered_at')->nullable()->after('user_role');
            $table->string('pin_code')->nullable()->after('registered_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('user_name');
            Schema::dropIfExists('avatar');
            Schema::dropIfExists('user_role');
            Schema::dropIfExists('registered_at');
            Schema::dropIfExists('pin_code');
        });
    }
}
