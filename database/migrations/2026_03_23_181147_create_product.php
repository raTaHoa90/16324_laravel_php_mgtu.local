<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // таблица для категорий товаров
        Schema::create('categories', function (Blueprint $table) {
            $table->id();                 // ID - уникальный ключ записи в таблице (PRIMARY KEY)
            $table->timestamps();         // Создает 2 поля метки времени created_at и updated_at
            $table->softDeletes();        // Создает поле метки времени deleted_at, для удаления записи без ее физического удаления
            $table->string('caption');               // имя категории
            $table->string('saf');                   // транслит имени на латинские буквы для красивого имени адреса
            $table->integer('parent_id');            // вышестоящая категория, в которую вложена текущая или 0, если эта категория самая верхняя.
            $table->text('description')->nullable(); // описание категории
        });

        // таблица товаров
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('caption');                  // название товара
            $table->text('description')->nullable();    // описание товара
            $table->decimal('price');                   // стоимость товара
            $table->tinyInteger('status')->default(0);  // статус товара (0 - скрыто, 1 - опубликовано)
            $table->integer('category_id')->nullable(); // ссылка на категорию в которой располагается товар
        });

        // таблица списков значений параметра
        Schema::create('param_lists', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('caption');          // название списка значений
            $table->tinyInteger('type_values'); // 0 - список текстовых значений, 1 - список цветов, 2 - набор картинок
        });

        // таблица значений списка
        Schema::create('param_list_values', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('list_id');  // ссылка на список значений
            $table->string('value');     // значение в списке
        });

        // таблица характеристик товара
        Schema::create('product_params', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('product_id');                 // для какого товара заводится характеристика
            $table->string('caption');                     // название характеристики
            $table->string('value');                       // значение характеристики
            $table->tinyInteger('type_param')->default(0); // тип характеристики
            /*
                0 - текст
                1 - лист значений
                2 - лист значений, который выбирает сам пользователь
            */
            $table->integer('list_id')->nullable(); // ссылка на лист значений, если выбран соответствующий тип
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('products');
        Schema::dropIfExists('param_lists');
        Schema::dropIfExists('param_list_values');
        Schema::dropIfExists('product_params');
    }
};
