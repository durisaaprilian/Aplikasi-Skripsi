<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hasil;
use App\Models\User;
use App\Models\Jawaban;
use App\Models\Training;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class AdminController extends Controller
{
    public function admin()
    {
    	return view('v_admin.admin');
    }

    public function data()
    {   
        if (Auth()->User()->role!='Admin') {
            return redirect('index');
        }
        // dd(User::where('role','=','Admin')->where('id_user','!=',Auth()->user()->id_user)->get());
        $data = array();
        foreach(User::where('role','=','Admin')->where('id_user','!=',Auth()->user()->id_user)->get() as $hasil){
            array_push($data,[
                'name' => $hasil->name,
                'email' => $hasil->email,
                'id_user' => $hasil->id_user,
            ]);
        }
        if (request()->ajax()) {
            return DataTables::of($data)->make(true);
        }
        return view('v_admin.dataadmin');
    }
    public function add()
    {
        if (Auth()->User()->role!='Admin') {
            return redirect('index');
        }
        if (request()->name&&request()->email&&request()->password) {
            dd(request());
        }
        return view('v_admin.add');
    }
    public function padd(Request $request)
    {
        if (Auth()->User()->role!='Admin') {
            return redirect('index');
        }
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required|max:255',
        ]);

        $data = User::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>Hash::make($request->password),
            'role' =>'Admin',
        ]);
        // dd($data);
        return redirect('data');
    }
    public function ubahdata($id)
    {
        if (Auth()->User()->role!='Admin') {
            return redirect('index');
        }
        $data = [
            'user' => User::find($id),
        ];
        return view('v_admin.update',compact('data'));
    }
    public function pubahdata(Request $request,$id)
    {
        // dd($request);
        if ($request->name!=null&&$request->email!=null) {
            if ($request->password==null) {
                $ubah_data = User::where('id_user',$id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
                if ($ubah_data) {
                    return redirect('data')->with('sukses','data sudah diubah');
                }
                else{
                    return redirect('data/ubah/'.$id)->with('gagal','data gagal diubah');
                }
            }
            if ($request->password!=null) {
                $ubah_data = User::where('id_user',$id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                if ($ubah_data) {
                    return redirect('data')->with('sukses','data sudah diubah');
                }
                else{
                    return redirect('data/ubah/'.$id)->with('gagal','data gagal diubah');
                }
            }

        }
        else{
            return redirect('data/ubah/'.$id);
        }
    }
    public function deletedata($id)
    {
        $delete_user = User::where('id_user','=',$id)->delete();
        DB::statement('alter table users auto_increment=0');
        if ($delete_user) {
            return redirect('data')->with('sukses','data sudahh dihapus');
        }
        else{
            return redirect('data')->with('gagal','data gagal dihapus');
        }
    }

    public function tesrekap()
    {
    	if (Auth()->User()->role=='Admin') {
            $data=array();
            foreach(Hasil::all() as $hasil){
                array_push($data,[
                    'id_users' => User::find($hasil->id_users)->name,
                    'email' => User::find($hasil->id_users)->email,
                    'tgl' => DATE('d/m/Y',strtotime($hasil->created_at)),
                    'jawaban' => $this->kepribadian($hasil->jawaban),
                ]);
            }
            // dd($data,User::all());
            if (request()->ajax()) {
                return DataTables::of($data)->make(true);
            }
            return view('v_admin.tesrekap');
        }
        return redirect('/');
    }

    public function kepribadian($data)
    {   
        if ($data!=null) {
            $normalisasi=[];
            // membuat data normalisasi sebanyak data training
            foreach (Training::all() as $key_training => $value_training) {

                $data_training = explode(',',$value_training->jawaban_training);
                $data_training_type = str_split($value_training->type);
                $data_uji = explode(',',$data);

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

            return $H1.$H2.$H3.$H4;
        }
        return "DATA BELUM ADA";
    }
}
