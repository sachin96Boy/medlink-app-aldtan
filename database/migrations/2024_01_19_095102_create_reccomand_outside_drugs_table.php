<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReccomandOutsideDrugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reccomand_outside_drugs', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->date('appoinment_date');
            $table->string('drug')->nullable;
            $table->string('dose')->nullable;
            $table->string('period');
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
        Schema::dropIfExists('reccomand_outside_drugs');
    }
}
