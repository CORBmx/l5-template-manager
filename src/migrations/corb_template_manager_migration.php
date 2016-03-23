<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CorbTemplateManagerMigration extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('template-manager.template_table'), function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->longText('value');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop(config('template-manager.template_table'));
    }

}
