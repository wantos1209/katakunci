@extends('index')

@section('container')

<style>
    .button-left {
        width: "100%";
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .imagesearch-input {
        display: flex;
        margin-top: 5px;
        padding-top: 5px;
        border-top: 1px solid rgba(var(--rgba-primary), 0.2);
        margin-bottom: 5px;
    }

    .margin-50 {
        margin-top: 50px;
    }

    .margin-30 {
        margin-bottom: 50px;
    }

    .imagesearch-details {
        width: 100%;
    }

    .remove-btn {
        max-height: 40px; 
    }
</style>

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }} Form</h3>
            <span>Add Data</span
        </div>
        <form action="/imagesearch/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Site</span>
                <select id="site_id" name="site_id">
                    @foreach ($dataSite as $site)
                        <option value={{ $site->id }} >{{ $site->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Keyword</span>
                <select class="js-example-basic-multiple" name="keyword_id[]" multiple="multiple" required>
                    @foreach ($dataKeyword as $keyword)
                    <option value={{ $keyword->id }} >{{ $keyword->key }}</option>
                @endforeach
                  </select>
            </div>
            
            <div class="sec_head_form margin-50">
                <h3>{{ $title2 }} Form</h3>
            </div>
            <div id="dynamic-form">
                <div class="list_form button-left"><button type="button" id="add-imagesearch-btn" class="sec_botton btn_success">Add Data</button></div>
                <div id="imagesearch-fields">
                   
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/imagesearch"><button class="sec_botton btn_cancel" type="button">Cancel</button></a>
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
    $(document).ready(function() {
      $('.js-example-basic-multiple').select2();

    //   var selectedValues = ['arwanatoto', 'Daftar Arwanatoto']; 
    //   $('.js-example-basic-multiple').val(selectedValues).trigger('change');
  });
</script>

<script>
    $(document).ready(function () {
        // Menambahkan imagesearch baru
        $("#add-imagesearch-btn").on("click", function () {
            const imagesearchFields = $("#imagesearch-fields");
            const index = imagesearchFields.children().length;
            const newImagesearchField = $(`
                <div class="imagesearch-input margin-30">
                    <div class="imagesearch-details">
                        <div class="list_form">
                            <span class="sec_label">Title</span>
                            <input type="text" name="title[${index}]" placeholder="Input Title" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Image Url</span>
                            <input type="text" name="imageUrl[${index}]" placeholder="Input image Url" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Image Width</span>
                            <input type="number" min=0 name="imageWidth[${index}]" placeholder="Input Image Width" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Image Height</span>
                            <input type="number" min=0 name="imageHeight[${index}]" placeholder="Input Image Height" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Thumbnail Url</span>
                            <input type="text" name="thumbnailUrl[${index}]" placeholder="Input Thumbnail Url" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Thumbnail Width</span>
                            <input type="number" min=0 name="thumbnailWidth[${index}]" placeholder="Input Thumbnail Width" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Thumbnail Height</span>
                            <input type="number" min=0 name="thumbnailHeight[${index}]" placeholder="Input Thumbnail Height" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Source</span>
                            <input type="text" name="source[${index}]" placeholder="Input Source" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Domain</span>
                            <input type="text" name="domain[${index}]" placeholder="Input Domain" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Link</span>
                            <input type="text" name="link[${index}]" placeholder="Input Link" required>
                        </div>
                         <div class="list_form">
                            <span class="sec_label">Position</span>
                            <input type="number" min=0 name="position[${index}]" placeholder="Input Position" required>
                        </div>
                    </div>
                    <button type="button" class="remove-btn sec_botton btn_danger">Remove</button>
                </div>
            `);
            imagesearchFields.append(newImagesearchField);
        });

        // Menghapus imagesearch atau detail
        $("#imagesearch-fields").on("click", ".remove-btn", function () {
            $(this).closest(".imagesearch-input").remove();
        });
    });
</script>

@endsection
