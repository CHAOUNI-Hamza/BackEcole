<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 20);
            $table->string('prenom', 20);
            $table->integer('father_id')->unsigned();
            $table->foreign('father_id')->references('id')->on('fathers')->onDelete('cascade');
            $table->string('niveau_scolaire');
            $table->string('type_niveau');
            $table->string('photo');
            $table->string('num_matricule', 30);
            $table->string('sex', 5);
            $table->date('date_naissance');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->softDeletes();
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
        Schema::dropIfExists('students');
    }
}
