<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Training;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Training::create(['jawaban_training'=>'11,13,14,16','type'=>'ISTJ']);
        Training::create(['jawaban_training'=>'12,13,13,11','type'=>'ISTP']);
        Training::create(['jawaban_training'=>'13,18,14,16','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'8,12,12,17','type'=>'INFJ']);
        Training::create(['jawaban_training'=>'13,14,14,15','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'10,13,13,17','type'=>'ISTJ']);
        Training::create(['jawaban_training'=>'14,9,10,15','type'=>'ENFJ']);
        Training::create(['jawaban_training'=>'10,12,14,15','type'=>'INTJ']);
        Training::create(['jawaban_training'=>'13,13,13,11','type'=>'ESTP']);
        Training::create(['jawaban_training'=>'13,14,12,13','type'=>'ESFJ']);
        Training::create(['jawaban_training'=>'16,11,13,14','type'=>'ENTJ']);
        Training::create(['jawaban_training'=>'14,14,14,13','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'14,14,12,15','type'=>'ESFJ']);
        Training::create(['jawaban_training'=>'16,13,12,12','type'=>'ESFP']);
        Training::create(['jawaban_training'=>'16,13,12,14','type'=>'ESFJ']);
        Training::create(['jawaban_training'=>'12,10,12,12','type'=>'INFP']);
        Training::create(['jawaban_training'=>'12,15,11,13','type'=>'ISFJ']);
        Training::create(['jawaban_training'=>'11,11,11,12','type'=>'INFP']);
        Training::create(['jawaban_training'=>'16,14,14,16','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'12,14,12,13','type'=>'ISFJ']);
        Training::create(['jawaban_training'=>'12,13,12,12','type'=>'ISFP']);
        Training::create(['jawaban_training'=>'15,11,10,12','type'=>'ENFP']);
        Training::create(['jawaban_training'=>'11,11,11,14','type'=>'INFJ']);
        Training::create(['jawaban_training'=>'13,13,14,15','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'16,14,14,14','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'14,13,13,10','type'=>'ESTP']);
        Training::create(['jawaban_training'=>'14,12,12,12','type'=>'ENFP']);
        Training::create(['jawaban_training'=>'14,13,13,14','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'11,11,11,14','type'=>'INFJ']);
        Training::create(['jawaban_training'=>'10,14,11,13','type'=>'ISFJ']);
        Training::create(['jawaban_training'=>'14,12,11,13','type'=>'ENFJ']);
        Training::create(['jawaban_training'=>'13,12,12,11','type'=>'ENFP']);
        Training::create(['jawaban_training'=>'19,13,12,12','type'=>'ESFP']);
        Training::create(['jawaban_training'=>'14,14,12,13','type'=>'ESFJ']);
        Training::create(['jawaban_training'=>'17,16,15,17','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'16,13,14,14','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'13,14,15,14','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'13,13,12,17','type'=>'ESFJ']);
        Training::create(['jawaban_training'=>'15,12,13,14','type'=>'ENTJ']);
        Training::create(['jawaban_training'=>'14,13,13,16','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'10,10,7,6','type'=>'INFP']);
        Training::create(['jawaban_training'=>'16,14,15,13','type'=>'ESTJ']);
        Training::create(['jawaban_training'=>'14,16,14,8','type'=>'ESTP']);
        Training::create(['jawaban_training'=>'13,11,11,13','type'=>'ENFJ']);
        Training::create(['jawaban_training'=>'13,13,12,11','type'=>'ESFP']);
        Training::create(['jawaban_training'=>'14,11,13,17','type'=>'ENTJ']);
        Training::create(['jawaban_training'=>'16,9,8,11','type'=>'ENFP']);
        Training::create(['jawaban_training'=>'10,13,14,10','type'=>'ISTP']);
        Training::create(['jawaban_training'=>'12,15,14,13','type'=>'ISTJ']);
        Training::create(['jawaban_training'=>'12,10,13,12','type'=>'INTP']);
    }
}
