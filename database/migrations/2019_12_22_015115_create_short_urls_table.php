<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShortUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('short-url.connection'))->create('short_urls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('destination_url');

            $urlKeyColumn = $table->string('url_key')->unique();

            if (Schema::getConnection()->getConfig('driver') === 'mysql') {
                $urlKeyColumn->collation('utf8mb4_bin');
            }

            $table->string('default_short_url');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->boolean('single_use');
            $table->boolean('track_visits');
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('short-url.connection'))->dropIfExists('short_urls');
    }
}
