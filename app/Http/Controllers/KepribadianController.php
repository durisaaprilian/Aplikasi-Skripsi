<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kepribadian;
use App\Models\Hasil;
use App\Models\Jawaban;
use App\Models\Training;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class KepribadianController extends Controller
{
    public function teskepribadian()
    {   
        if (Auth()->User()->role!='User') {
            return redirect('index');
        }
        $isi = Hasil::where('id_users','=',Auth()->User()->id_user)->first();
        if ($isi) {
            $isi = true;
        }
        else{
            $isi = false;
        }
        $data = [
            'hasil' => Hasil::where('id_users','=',Auth()->User()->id_user)->first(),
            'isi' => $isi,
        ];

        // dd($data);
        return view('v_user.teskepribadian',compact('data'));
    }
    public function pkepribadian(Request $request)
    {   
        // dd(Auth()->User()->id_user);
        $data = Hasil::create([
            'id_users'=>Auth()->User()->id_user,
            'jawaban'=>$request->d_d1.",".$request->d_d2.",".$request->d_d3.",".$request->d_d4,
        ]);
        if ($data==true) {
            return response()->json('sukses',200);
        }
        else{
            return response()->json('gagal',200);
        }    
    }
    public function tipekepribadian()
    {
        $data = [
            'kepribadian' => Kepribadian::get(),
        ];
        return view('tipekepribadian',compact('data'));
    }
    public function hasil()
    {
        $data = Hasil::where('id_users','=',Auth()->User()->id_user)->first();
        if ($data!=null) {

            // buat array untuk menampung data normalisasi
            $normalisasi=[];
            // membuat data normalisasi sebanyak data training
            foreach (Training::all() as $key_training => $value_training) {

                $data_training = explode(',',$value_training->jawaban_training);
                $data_training_type = str_split($value_training->type);
                $data_uji = explode(',',$data->jawaban);

                $array = [];
                // membuat normalsasi untuk masing masing data training
                foreach ($data_uji as $key_uji => $value_uji) {
                    $array['E'.$key_uji+1]=pow((($data_training[$key_uji]-$data_uji[$key_uji])**2),1/2);
                    $array['D'.$key_uji+1]=$data_training_type[$key_uji];
                }
                array_push($normalisasi,$array);
            }

            // proses pengambilan data K
            // mengambil data K dan memasukkan kedalam variabel K1 untuk mencari cata terbanyak
            $K1=[];
            foreach (collect($normalisasi)->sortBy(['E1','ASC'])->take(3) as $key => $value) {
                if (count($K1)==0) {
                    array_push($K1,array(
                        'D1'=>$value['D1'],
                        'J_D1'=>1,
                    ));
                }
                else{
                    if (collect($K1)->where('D1',$value['D1'])->count()>0) {
                        $K1[collect($K1)->where('D1',$value['D1'])->keys()[0]]['J_D1']=$K1[collect($K1)->where('D1',$value['D1'])->keys()[0]]['J_D1']+1;
                    }
                    else{
                        array_push($K1,[
                            'D1'=>$value['D1'],
                            'J_D1'=>1,
                        ]);
                    }
                }
            }
            // mengambil data K2
            $K2=[];
            foreach (collect($normalisasi)->sortBy(['E2','ASC'])->take(3) as $key => $value) {
                if (count($K2)==0) {
                    array_push($K2,[
                        'D2'=>$value['D2'],
                        'J_D2'=>1,
                    ]);
                }
                else{
                    if (collect($K2)->where('D2',$value['D2'])->count()>0) {
                        $K2[collect($K2)->where('D2',$value['D2'])->keys()[0]]['J_D2']=$K2[collect($K2)->where('D2',$value['D2'])->keys()[0]]['J_D2']+1;
                    }
                    else{
                        array_push($K2,[
                            'D2'=>$value['D2'],
                            'J_D2'=>1,
                        ]);
                    }
                }
            }
            // mengambil data K3
            $K3=[];
            foreach (collect($normalisasi)->sortBy(['E3','ASC'])->take(3) as $key => $value) {
                if (count($K3)==0) {
                    array_push($K3,[
                        'D3'=>$value['D3'],
                        'J_D3'=>1,
                    ]);
                }
                else{
                    if (collect($K3)->where('D3',$value['D3'])->count()>0) {
                        $K3[collect($K3)->where('D3',$value['D3'])->keys()[0]]['J_D3']=$K3[collect($K3)->where('D3',$value['D3'])->keys()[0]]['J_D3']+1;
                    }
                    else{
                        array_push($K3,[
                            'D3'=>$value['D3'],
                            'J_D3'=>1,
                        ]);
                    }
                }
            }
            // mengambil data K4
            $K4=[];
            foreach (collect($normalisasi)->sortBy(['E4','ASC'])->take(3) as $key => $value) {
                if (count($K4)==0) {
                    array_push($K4,[
                        'D4'=>$value['D4'],
                        'J_D4'=>1,
                    ]);
                }
                else{
                    if (collect($K4)->where('D4',$value['D4'])->count()>0) {
                        $K4[collect($K4)->where('D4',$value['D4'])->keys()[0]]['J_D4']=$K4[collect($K4)->where('D4',$value['D4'])->keys()[0]]['J_D4']+1;
                    }
                    else{
                        array_push($K4,[
                            'D4'=>$value['D4'],
                            'J_D4'=>1,
                        ]);
                    }
                }
            }

            // mengambil data terbanyak
            $H1="";
            foreach (collect($K1) as $key => $value) {
                if ($value['J_D1']>=2) {
                    $H1=$value['D1'];
                }
            }
            $H2="";
            foreach (collect($K2) as $key => $value) {
                if ($value['J_D2']>=2) {
                    $H2=$value['D2'];
                }
            }
            $H3="";
            foreach (collect($K3) as $key => $value) {
                if ($value['J_D3']>=2) {
                    $H3=$value['D3'];
                }
            }
            $H4="";
            foreach (collect($K4) as $key => $value) {
                if ($value['J_D4']>=2) {
                    $H4=$value['D4'];
                }
            }
            
            $hasil = Kepribadian::where('type','=',$H1.$H2.$H3.$H4)->first();

            // dd($a,$x,$d1.$d2.$d3.$d4);
            return response()->json($hasil,200);
        }
        return response()->json('kosong',200);
    }

    public function FunctionName($value='')
    {
        // code...
    }

    public function cek()
    {
        $data = Hasil::where('id_users','=',Auth()->User()->id_user)->first();
        if ($data!=null) {
            return response()->json('true',200);
        }
        else{
            return response()->json('false',200);
        }
    }
    public function cetak()
    {
        if (Auth()->User()->role!='User') {
            return redirect('index');
        }
        return view('v_user.cetak');
    }
}
