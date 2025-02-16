@extends('index')

@section('container')

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }} Form</h3>
            <span>Edit Data</span>
        </div>
        <form action="/websearch/edit/{{ $id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Title</span>
                <input type="text" id="title" name="title" value="{{ $data->title }}" placeholder="Input Title">
            </div>
            <div class="list_form">
                <span class="sec_label">Description</span>
                <textarea id="description" name="description" row="5" placeholder="Input Descripotion">{{ $data->description }}</textarea>
            </div>
            <div class="list_form">
                <span class="sec_label">Website</span>
                <input type="text" id="website" name="website" value="{{ $data->website }}" placeholder="Input Url Website">
            </div>
            <div class="list_form">
                <span class="sec_label">Icon Url</span>
                <input type="text" id="iconUrl" name="iconUrl" value="{{ $data->iconUrl }}" placeholder="Input Url Icon Url">
            </div>
            <div class="list_form">
                <span class="sec_label">Logo Url</span>
                <input type="text" id="logoUrl" name="logoUrl" value="{{ $data->logoUrl }}" placeholder="Input Url Logo Url">
            </div>
            <div class="list_form">
                <span class="sec_label">Desktop Image Url</span>
                <input type="text" id="desktopImageUrl" name="desktopImageUrl" value="{{ $data->desktopImageUrl }}" placeholder="Input Url Desktop Image Url">
            </div>
            <div class="list_form">
                <span class="sec_label">Mobile ImageUrl</span>
                <input type="text" id="mobileImageUrl" name="mobileImageUrl" value="{{ $data->mobileImageUrl }}" placeholder="Input Url Mobile Image Url">
            </div>
            <div class="list_form">
                <span class="sec_label">Livechat</span>
                <input type="text" id="livechat" name="livechat" value="{{ $data->livechat }}" placeholder="Input Url Livechat">
            </div>
            <div class="list_form">
                <span class="sec_label">Whatsapp</span>
                <input type="text" id="whatsapp" name="whatsapp" value="{{ $data->whatsapp }}" placeholder="Input Url whatsapp">
            </div>
            <div class="list_form">
                <span class="sec_label">Telegram</span>
                <input type="text" id="telegram" name="telegram" value="{{ $data->telegram }}" placeholder="Input Url Telegram">
            </div>
            <div class="list_form">
                <span class="sec_label">line</span>
                <input type="text" id="line" name="line" value="{{ $data->line }}" placeholder="Input Url Line">
            </div>
            <div class="list_form">
                <span class="sec_label">Facebook</span>
                <input type="text" id="facebook" name="facebook" value="{{ $data->facebook }}" placeholder="Input Url Facebook">
            </div>
            <div class="list_form">
                <span class="sec_label">Instagram</span>
                <input type="text" id="instagram" name="instagram" value="{{ $data->instagram }}" placeholder="Input Url Instagram">
            </div>
            <div class="list_form">
                <span class="sec_label">Twitter</span>
                <input type="text" id="twitter" name="twitter" value="{{ $data->twitter }}" placeholder="Input Url Twitter">
            </div>
            <div class="list_form">
                <span class="sec_label">Youtube</span>
                <input type="text" id="youtube" name="youtube" value="{{ $data->youtube }}" placeholder="Input Url Youtube">
            </div>
            <div class="list_form">
                <span class="sec_label">Aplikasi Ios</span>
                <input type="text" id="aplikasiIos" name="aplikasiIos" value="{{ $data->aplikasiIos }}" placeholder="Input Url Aplikasi Ios">
            </div>
            <div class="list_form">
                <span class="sec_label">Aplikasi Android</span>
                <input type="text" id="aplikasiAndroid" name="aplikasiAndroid" value="{{ $data->aplikasiAndroid }}" placeholder="Input Url Aplikasi Android">
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
