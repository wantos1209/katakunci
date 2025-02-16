@extends('index')

@section('container')

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }} Form</h3>
            <span>Add Data</span>
        </div>
        <form action="/keyword/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Key</span>
                <input type="text" id="key" name="key">
            </div>
            {{-- <span class="text-warning-1">
                <strong>Perhatian:</strong> Gunakan tanda titik koma (<code> ; </code>) untuk memisahkan input jika Anda ingin menambahkan beberapa data sekaligus. Contoh: <code>arwanatoto; jeeptoto; doyantoto</code>
            </span> --}}
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/keyword"><button class="sec_botton btn_cancel" type="button">Cancel</button></a>
            </div>
        </form>
    </div>
</div>    

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>

@endsection
