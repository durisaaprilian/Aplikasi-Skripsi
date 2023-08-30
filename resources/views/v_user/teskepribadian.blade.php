@extends('layout.app')

@section('content')

<div class="hero_area">
    <!-- header section strats -->
    @include('layout.header')
    <!-- end header section -->
</div>

<!-- item section -->
<div class="price_section layout_padding2">
    <div class="container" id="data_tes">
        <div class="heading_container">
            <h2>
                TES KEPRIBADIAN
            </h2>
            <h2 class="d-flex ml-auto" id="timer_pertanyaan">
            </h2>
        </div>
        @auth
        @if($data['hasil']==null)
        <div id="l_d1">
            @include('tes.d1')
        </div>
        <div id="l_d2">
            @include('tes.d2')
        </div>
        <div id="l_d3">
            @include('tes.d3')
        </div>
        <div id="l_d4">
            @include('tes.d4')
        </div>
        <div id="l_d5">
            @include('tes.finish')
        </div>
        @else
        <div id="l_d5">
            @include('tes.finish')
        </div>
        @endif
        @else
        <div id="">
            @include('tes.login')
        </div>
        @endauth
    </div>
</div>
<!-- end item section -->
@endsection
@push('jss')
<script>
    let waktu = 10;
    let pertanyaan = 1;
    let posisi = 1;
    let mulai_timer;
    let mulai_hasil;
    var situasi = "<?php echo $data['isi']; ?>";
    if (situasi) {
        $('#l_d1').hide();
        $('#l_d2').hide();
        $('#l_d3').hide();
        $('#l_d4').hide();
        $('#l_d5').show();
        // hasil();
    }
    else{
        $('#l_d1').show();
        $('#l_d2').show();
        $('#l_d3').show();
        $('#l_d4').show();
        $('#l_d5').hide();
        $('#p11').show();
        $('#p12').hide();
        $('#p13').hide();
        $('#p14').hide();
        $('#p15').hide();
        $('#p21').hide();
        $('#p22').hide();
        $('#p23').hide();
        $('#p24').hide();
        $('#p25').hide();
        $('#p31').hide();
        $('#p32').hide();
        $('#p33').hide();
        $('#p34').hide();
        $('#p35').hide();
        $('#p41').hide();
        $('#p42').hide();
        $('#p43').hide();
        $('#p44').hide();
        $('#p45').hide();
        mulai();
    }
    function mulai() {
        mulai_timer=setInterval(proses,1000);
    }
    function proses(){
        console.log('tampilkan pertanyaan '+pertanyaan+' nomor ke '+posisi);
        $('#timer_pertanyaan').html(waktu);
        waktu--;
        if (waktu<0) {
            console.log('waktu '+waktu,'pertanyaan '+pertanyaan,'posisi '+posisi);
            waktu=10;
            $('#p'+pertanyaan+posisi).hide();
            if (posisi>4) {
                if (pertanyaan>3) {
                    console.log('ajax');
                    clearInterval(mulai_timer);
                    hasil();
                }
                pertanyaan++;
                posisi=0;
            }
            posisi++;
            $('#p'+pertanyaan+posisi).show();
        }
    }

    function hasil() {
        mulai_hasil=setInterval(hasil_quest,1000);
    }
    function hasil_quest() {
        let d_d11 = $("input[name='d11']:checked").val()!=undefined ? $("input[name='d11']:checked").val() : 0;
        let d_d12 = $("input[name='d12']:checked").val()!=undefined ? $("input[name='d12']:checked").val() : 0;
        let d_d13 = $("input[name='d13']:checked").val()!=undefined ? $("input[name='d13']:checked").val() : 0;
        let d_d14 = $("input[name='d14']:checked").val()!=undefined ? $("input[name='d14']:checked").val() : 0;
        let d_d15 = $("input[name='d15']:checked").val()!=undefined ? $("input[name='d15']:checked").val() : 0;
        let d1 = parseInt(d_d11)+parseInt(d_d12)+parseInt(d_d13)+parseInt(d_d14)+parseInt(d_d15);
        let d_d21 = $("input[name='d21']:checked").val()!=undefined ? $("input[name='d21']:checked").val() : 0;
        let d_d22 = $("input[name='d22']:checked").val()!=undefined ? $("input[name='d22']:checked").val() : 0;
        let d_d23 = $("input[name='d23']:checked").val()!=undefined ? $("input[name='d23']:checked").val() : 0;
        let d_d24 = $("input[name='d24']:checked").val()!=undefined ? $("input[name='d24']:checked").val() : 0;
        let d_d25 = $("input[name='d25']:checked").val()!=undefined ? $("input[name='d25']:checked").val() : 0;
        let d2 = parseInt(d_d21)+parseInt(d_d22)+parseInt(d_d23)+parseInt(d_d24)+parseInt(d_d25);
        let d_d31 = $("input[name='d31']:checked").val()!=undefined ? $("input[name='d31']:checked").val() : 0;
        let d_d32 = $("input[name='d32']:checked").val()!=undefined ? $("input[name='d32']:checked").val() : 0;
        let d_d33 = $("input[name='d33']:checked").val()!=undefined ? $("input[name='d33']:checked").val() : 0;
        let d_d34 = $("input[name='d34']:checked").val()!=undefined ? $("input[name='d34']:checked").val() : 0;
        let d_d35 = $("input[name='d35']:checked").val()!=undefined ? $("input[name='d35']:checked").val() : 0;
        let d3 = parseInt(d_d31)+parseInt(d_d32)+parseInt(d_d33)+parseInt(d_d34)+parseInt(d_d35);
        let d_d41 = $("input[name='d41']:checked").val()!=undefined ? $("input[name='d41']:checked").val() : 0;
        let d_d42 = $("input[name='d42']:checked").val()!=undefined ? $("input[name='d42']:checked").val() : 0;
        let d_d43 = $("input[name='d43']:checked").val()!=undefined ? $("input[name='d43']:checked").val() : 0;
        let d_d44 = $("input[name='d44']:checked").val()!=undefined ? $("input[name='d44']:checked").val() : 0;
        let d_d45 = $("input[name='d45']:checked").val()!=undefined ? $("input[name='d45']:checked").val() : 0;
        let d4 = parseInt(d_d41)+parseInt(d_d42)+parseInt(d_d43)+parseInt(d_d44)+parseInt(d_d45);
        $.ajax({
            type:"POST",
            data:{
                d_d1:d1,
                d_d2:d2,
                d_d3:d3,
                d_d4:d4,
                "_token":"{{csrf_token()}}",
            },
            url:"{{route('pkepribadian')}}",
            success:function(){
                // console.log('ok');
            }
        })
        $('#l_d5').show();
        console.log("menampilkan hasil "+d1+","+d2+","+d3+","+d4);
        clearInterval(mulai_hasil);

    }
</script>
@endpush