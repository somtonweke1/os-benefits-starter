<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('benefits_content', function (Blueprint $table) {
            $table->id();
            $table->string('directus_id')->unique();
            $table->string('name');
            $table->text('description');
            $table->json('eligibility_criteria');
            $table->json('content')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('benefits_content');
    }
}; 