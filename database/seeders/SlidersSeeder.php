<?php
namespace Database\Seeders;

use App\Models\Admin\Slider;
use Illuminate\Database\Seeder;

class SlidersSeeder extends Seeder
{
    public function run()
    {

         Slider::where('id', '>', '0')->delete();
         for ($i = 1; $i <= 5; $i++) {
            for ($j = 1; $j <= 9; $j++) {
               if ($j==1)
               {
                  $position = 'position-left';
                  $textcontent = 'textcontent-left';
                  $text = 'text-black';
               }
               if ($j==2)
               {
                  $position = 'position-left';
                  $textcontent = 'textcontent-right';
                  $text = 'text-black';
               }
               if ($j==3)
               {
                  $position = 'position-left';
                  $textcontent = 'textcontent-center';
                  $text = 'text-white';
               }
               
               if ($j==4)
               {
                  $position = 'position-right';
                  $textcontent = 'textcontent-left';
                  $text = 'text-black';
               }
               if ($j==5)
               {
                  $position = 'position-right';
                  $textcontent = 'textcontent-right';
                  $text = 'text-black';
               }
               if ($j==6)
               {
                  $position = 'position-right';
                  $textcontent = 'textcontent-center';
                  $text = 'text-white';
               }

               if ($j==7)
               {
                  $position = 'position-center';
                  $textcontent = 'textcontent-left';
                  $text = 'text-black';
               }
               if ($j==8)
               {
                  $position = 'position-center';
                  $textcontent = 'textcontent-right';
                  $text = 'text-black';
               }
               if ($j==9)
               {
                  $position = 'position-center';
                  $textcontent = 'textcontent-center';
                  $text = 'text-white';
               }

               Slider::insertOrIgnore([
                  'title'=>'Slider '.$j,
                  'description'=>'Slider '.$j.' Text Goes Here',
                  'position' => $position,
                  'textcontent' => $textcontent,
                  'text' => $text,
                  'language_id'=>'1',
                  'slider_type_id'=>$i,
                  'slider_navigation_id'=>'4',
                  'gallary_id'=>'2',
                  'ref_id'=>'0',
                  'url'=>'https://codecanyon.net/user/themes-coder',
                  'created_by'=>'1',
                  'updated_by'=>'1',
               ]);
               Slider::insertOrIgnore([
                  'title'=>'المنزلق '.$j,
                  'description'=>'يظهر النص المنزلق هنا',
                  'position' => $position,
                  'textcontent' => $textcontent,
                  'text' => $text,
                  'language_id'=>'2',
                  'slider_type_id'=>$i,
                  'slider_navigation_id'=>'4',
                  'gallary_id'=>'2',
                  'ref_id'=>'0',
                  'url'=>'https://codecanyon.net/user/themes-coder',
                  'created_by'=>'1',
                  'updated_by'=>'1',
               ]);
            }   
         }      	
         
         
    }
}