<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJwttokensTable extends Migration
{
    protected $tableName = 'jwttokens';
    protected $usersTableName = 'users';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('token')->unique();
            $table->integer('user_id')->unsigned();
            $table->dateTime('issued_at');
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('last_access')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on($this->usersTableName);
//            $table->foreign('user_id')
//                    ->references('id')->on($this->usersTableName)
//                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->tableName);
    }
}
