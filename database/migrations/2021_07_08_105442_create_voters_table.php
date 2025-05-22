<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('city')->nullable();
            $table->integer('region')->nullable();
            $table->string('constituency')->nullable();
            $table->integer('polling_ward')->nullable();
            $table->string('polling_station')->nullable();
            $table->integer('state')->nullable();
            $table->string('post_code')->nullable();
            $table->integer('country')->nullable();
            $table->enum('gender', ['Male', 'Female'])->default('Male');
            $table->date('date_ofbirth')->nullable();
            $table->string('voter_card')->nullable();
            $table->string('voter_card_img')->nullable();
            $table->integer('chapter')->default(0);
            $table->integer('status')->default(1)->comment('1=Active, 2=In-active, 3=Suspended, 4=Terminated, 5=Membership Expired, 6=Death');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voters');
    }
}
