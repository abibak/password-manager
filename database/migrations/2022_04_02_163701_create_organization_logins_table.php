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
        Schema::create('organization_logins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_folder_id')->constrained()->onDelete('CASCADE');
            $table->string('name', 100);
            $table->string('login', 150);
            $table->string('password', 300);
            $table->string('url', 200)->nullable();
            $table->string('tags', 100)->nullable();
            $table->string('note', 500)->nullable();
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
        Schema::dropIfExists('organization_logins');
    }
};
