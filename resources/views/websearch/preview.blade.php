@extends('index')

@section('container')

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }} Form</h3>
            <span>Edit Data</span>
        </div>
        <form action="/preview/edit/{{ $id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Title 1</span>
                <input type="hidden" name="id[]" value={{ $data[0]->id }}>
                <input type="text" id="title" name="title[0]" value="{{ $data[0]->title }}" placeholder="Input Title 1">
            </div>
            <div class="list_form">
                <span class="sec_label">Link 1</span>
                <input type="text" id="link" name="link[0]" value="{{ $data[0]->link }}" placeholder="Input Link 1">
            </div>

            <div class="list_form" style="margin-top:13px">
                <input type="hidden" name="id[]" value={{ $data[1]->id }}>
                <span class="sec_label">Title 2</span>
                <input type="text" id="title" name="title[1]" value="{{ $data[1]->title }}" placeholder="Input Title 2">
            </div>
            <div class="list_form">
                <span class="sec_label">Link 2</span>
                <input type="text" id="link" name="link[1]" value="{{ $data[1]->link }}" placeholder="Input Link 2">
            </div>
           
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/websearch"><button class="sec_botton btn_cancel" type="button">Cancel</button></a>
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
