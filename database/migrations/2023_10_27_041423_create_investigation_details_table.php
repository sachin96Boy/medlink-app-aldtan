<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestigationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investigation_details', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id');
            $table->string('investigation_id')->nullable;
            $table->string('investigation_details')->nullable;
            $table->integer('treatment');
            $table->integer('medicalTest')->nullable;
            $table->date('next_visit_date')->nullable;
            $table->double('amount')->nullable;
            $table->string('comment');
            $table->date('channel_date');
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
        Schema::dropIfExists('investigation_details');
    }
}
