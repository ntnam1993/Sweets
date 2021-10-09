<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->truncate();
        $filePath = storage_path() . '/data/category.csv';
        if (env('APP_ENV') == 'staging') {
            $filePath = storage_path() . '/data/category_stg.csv';
        }
        if (($handle = fopen($filePath, 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $category = new Category();
                $category->product_category_id = $data[0];
                $category->parent_product_category_id = $data[1];
                $category->order_no = $data[2];
                $category->level = $data[3];
                $category->end_flg = $data[4];
                $category->category_name = $data[5];
                $category->image_file_name = $data[6];
                $category->display_flg = $data[7];
                $category->create_user_no = $data[8];
                $category->create_date = $data[9];
                $category->modify_user_no = $data[10];
                $category->modify_date = $data[11];
                $category->data_version = $data[12];
                $category->save();
            }
            fclose($handle);
        }
    }
}
