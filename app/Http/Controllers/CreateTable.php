<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CreateTable extends Controller
{
    public function table() {
      if (!Schema::hasTable('addresses')) {
          Schema::create('addresses', function($table) {
                    $table->increments('id');
                    $table->string('street', 255)->nullable();
                    $table->string('country', 255);
                    $table->integer('icon_id')->nullable();
                    $table->integer('monster_id');
            });
        }

        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function ($table) {
                $table->increments('id');
                $table->integer('category_id')->unsigned();
                $table->string('title', 255);
                $table->string('slug', 255);
                $table->text('content');
                $table->string('image', 255)->nullable();
                $table->enum('status',['PUBLISHED','DRAFT'])->default('PUBLISHED');
                $table->date('date');
                $table->tinyInteger('featured')->default(0);
            });
        }
    }
    
}

