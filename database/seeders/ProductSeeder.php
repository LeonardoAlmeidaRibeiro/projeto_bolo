<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Product::create(['id'=> '1', 'name'=> 'Bolo de Chocolate', 'description'=>'Chocolate indulgente, macio e irresistível', 'price'=>'9.5', 'image'=>["product_images\/DhhpwpGmCpgOrSsmYR3itARcMxYyee-metaMTAyMDI1ODQuanBn-.jpg"]]);
        Product::create(['id'=> '2', 'name'=> 'Coxinha de Frango', 'description'=>'Crocante, recheio de frango suculento', 'price'=>'2.75', 'image'=>["product_images\/s3EtoS6l7fl3VfXdccm9gsvWCI7yWI-metaaW1hZ2VzLmpwZw==-.jpg"]]);
        Product::create(['id'=> '3', 'name'=> 'Torta de Morango', 'description'=>'Morangos frescos, creme suave, crosta delicada', 'price'=>'11', 'image'=>["product_images\/t3Dwhyb66dfFB5tZAaz0IMvCvdUzgo-metacG5nLXRyYW5zcGFyZW50LXN0cmF3YmVycnktcGllLWZydWl0Y2FrZS10YXJ0LWNoZWVzZWNha2UtdG9ydGUtY2FrZS1jcmVhbS1mb29kLXN0cmF3YmVycmllcy5wbmc=-.png"]]);

        
    }
}
