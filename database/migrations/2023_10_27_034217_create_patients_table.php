<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('family_name')->nullable;
            $table->string('name')->nullable;
            $table->date('birthday')->nullable;
            $table->integer('age')->nullable;
            $table->string('gender')->nullable;
            $table->string('address')->nullable;
            $table->string('mobile')->nullable;
            $table->string('telephone')->nullable;
            $table->string('email')->nullable;
            $table->double('height_feets')->default(0);
            $table->double('height_inches')->default(0);
            $table->double('height_cen')->default(0);
            $table->double('weight')->nullable;
            $table->string('nic')->nullable;
            $table->string('occupation')->nullable;
            $table->integer('status')->default(0);
            $table->longText('fingerprint_id')->nullable;
            $table->longText('finger2')->nullable;
            $table->longText('finger3')->nullable;
            $table->longText('finger4')->nullable;
            $table->longText('finger5')->nullable;
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
        Schema::dropIfExists('patients');
    }
}
