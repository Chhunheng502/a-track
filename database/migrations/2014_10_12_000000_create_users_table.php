<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->default('teacher');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('photo_url')->default('https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png');
            $table->string('google_id')->nullable();
            $table->string('google_token')->nullable();
            $table->string('google_refreshToken')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
