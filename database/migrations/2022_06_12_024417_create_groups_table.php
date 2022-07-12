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
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id');
            $table->string('subject');
            $table->string('section');
            $table->json('sessions');
            $table->string('thumbnail')->default('https://gstatic.com/classroom/themes/img_read.jpg');
            $table->string('invitation_token');
            $table->timestamps();

            $table->unique(['subject', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
};
