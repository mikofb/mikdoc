<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(); // name of the document
            $table->string('slug')->nullable(); // slug for display
            $table->string('size')->nullable(); // size of a file
            $table->boolean('is_file')->default(false); // Boolean: 1 (true) if document is file, 0 (false) otherwise 
            $table->integer('document_id')->nullable(); // parent directory
            $table->integer('user_id')->nullable(); // document's owner (user) id
            $table->timestamps();
        });

        // Creating root directory...
        \DB::table('documents')->insert(
            [
                'name' => 'root',
                'slug' => 'root',
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
