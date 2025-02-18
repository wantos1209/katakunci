@extends('index')

@section('container')

<style>
    .button-left {
        width: "100%";
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .organic-input {
        display: flex;
        border-top: 1px solid rgba(var(--rgba-primary), 0.2);
        margin-bottom: 5px;
    }
</style>

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }} Form</h3>
            <span>Edit Data</span>
        </div>
        <form action="/organic/edit/{{ $id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Title</span>
                <input type="text" id="title" name="title" value="{{ $data->title }}" placeholder="Input Title">
            </div>
            <div class="list_form">
                <span class="sec_label">Link</span>
                <input type="text" id="link" name="link" value="{{ $data->link }}" placeholder="Input Link">
            </div>
            <div class="list_form">
                <span class="sec_label">Snippet</span>
                <textarea type="text" id="snippet" name="snippet" placeholder="Input Url Snippet">{{ $data->snippet }}</textarea>
            </div>
            <div class="list_form">
                <span class="sec_label">Icon Url</span>
                <input type="text" id="iconUrl" name="iconUrl" value="{{ $data->iconUrl }}" placeholder="Input Url Icon Url">
            </div>

            <div class="sec_head_form" style="margin-top: 50px">
                <h3>{{ $title2 }} Form</h3>
            </div>

            <div id="dynamic-form">
                <div class="list_form button-left"><button type="button" id="add-organic-btn" class="sec_botton btn_success">Add Site Link</button></div>
                <div id="organic-fields">
                    @foreach ($dataOrganicDetail as $index => $organic)
                        <div class="organic-input">
                            <div class="list_form organic-details">
                                <span class="sec_label">Title</span>
                                <input type="text" name="title_detail[{{ $index }}]" value="{{ $organic->title }}" placeholder="Input Title" required>
                                <span class="sec_label">Link</span>
                                <input type="text" name="link_detail[{{ $index }}]" value="{{ $organic->link }}" placeholder="Input Link" required>
                                
                            </div>
                            <button type="button" class="remove-btn sec_botton btn_danger">Remove</button>
                        </div>
                    @endforeach
                </div>
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


<script>
    $(document).ready(function () {
        // Menambahkan organic baru
        $("#add-organic-btn").on("click", function () {
            const organicFields = $("#organic-fields");
            const index = organicFields.children().length;
            const newOrganicField = $(`
                <div class="organic-input">
                    <div class="list_form organic-details">
                        <span class="sec_label">Title</span>
                        <input type="text" name="title_detail[${index}]" placeholder="Input Title" required>
                        <span class="sec_label">Link</span>
                        <input type="text" name="link_detail[${index}]" placeholder="Input Link" required>
                    </div>
                    <button type="button" class="remove-btn sec_botton btn_danger">Remove</button>
                </div>
            `);
            organicFields.append(newOrganicField);
        });

        // Menghapus organic atau detail
        $("#organic-fields").on("click", ".remove-btn", function () {
            $(this).closest(".organic-input").remove();
        });
    });
</script>

@endsection
