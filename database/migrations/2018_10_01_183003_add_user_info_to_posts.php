<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserInfoToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('posts' ,function($table){
        $table->string('année_dentré');
        $table->string('année_sortie');
        $table->mediumText('Avantage');
        $table->mediumText('inconvénient');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts' ,function($table){
            $table->dropColumn('année_dentré');
            $table->dropColumn('année_sortie');
            $table->dropColumn('Avantage');
            $table->dropColumn('inconvénient');
           });
        
    }
}
