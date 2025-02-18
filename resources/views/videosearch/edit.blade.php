@extends('index')

@section('container')

<style>
    .button-left {
        width: "100%";
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .videosearch-input {
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

    .videosearch-details {
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
            <span>Edit Data</span>
        </div>
        <form action="/videosearch/edit/{{ $id }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Site</span>
                <select id="site_id" name="site_id">
                    @foreach ($dataSite as $site)
                        <option value="{{ $site->id }}" {{ $data->site_id == $site->id ? 'selected' : '' }}>{{ $site->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="list_form">
                <span class="sec_label">Keyword</span>
                <select class="js-example-basic-multiple" name="keyword_id[]" multiple="multiple">
                    @foreach ($dataKeyword as $keyword)
                    <option value="{{ $keyword->id }}" >{{ $keyword->key }}</option>
                @endforeach
                  </select>
            </div>

            <div class="sec_head_form margin-50">
                <h3>{{ $title2 }} Form</h3>
            </div>
            <div id="dynamic-form">
                <div class="list_form button-left"><button type="button" id="add-videosearch-btn" class="sec_botton btn_success">Add Data</button></div>
                <div id="videosearch-fields">
                    @foreach ($dataImageDetail as $index => $image)
                        <div class="videosearch-input margin-30">
                            <div class="videosearch-details">
                                <div class="list_form">
                                    <span class="sec_label">Title</span>
                                    <input type="text" name="title[{{ $index }}]" value="{{ $image->title }}" placeholder="Input Title" required>
                                </div>
                                <div class="list_form">
                                    <span class="sec_label">Link</span>
                                    <input type="text" name="link[{{ $index }}]" value="{{ $image->link }}" placeholder="Input Link" required>
                                </div>
                                <div class="list_form">
                                    <span class="sec_label">Snippet</span>
                                    <textarea name="snippet[{{ $index }}]" placeholder="Input Snippet" required>{{ $image->snippet }}</textarea>
                                </div>
                                <div class="list_form">
                                    <span class="sec_label">Image Url</span>
                                    <input type="text" name="imageUrl[{{ $index }}]" value="{{ $image->imageUrl }}" placeholder="Input Image Url" required>
                                </div>
                                <div class="list_form">
                                    <span class="sec_label">Duration</span>
                                    <input type="time" name="duration[{{ $index }}]" value="{{ $image->duration }}" placeholder="Input Duration" required>
                                </div>
                                <div class="list_form">
                                    <span class="sec_label">Source</span>
                                    <input type="text" name="source[{{ $index }}]" value="{{ $image->source }}" placeholder="Input Source" required>
                                </div>
                                <div class="list_form">
                                    <span class="sec_label">Channel</span>
                                    <input type="text" name="channel[{{ $index }}]" value="{{ $image->channel }}" placeholder="Input Channel" required>
                                </div>
                                <div class="list_form">
                                    <span class="sec_label">Date</span>
                                    <input type="date" name="date[{{ $index }}]" value="{{ $image->date }}" placeholder="Input Date" required>
                                </div>
                                 <div class="list_form">
                                    <span class="sec_label">Position</span>
                                    <input type="number" min=0 name="position[{{ $index }}]" value="{{ $image->position }}" placeholder="Input Position" required>
                                </div>
                            </div>
                            <button type="button" class="remove-btn sec_botton btn_danger">Remove</button>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/videosearch"><button class="sec_botton btn_cancel" type="button">Cancel</button></a>
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

      var selectedValues = @json($dataKeywordSelected);
      $('.js-example-basic-multiple').val(selectedValues).trigger('change');
  });
</script>

<script>
    $(document).ready(function () {
        // Menambahkan videosearch baru
        $("#add-videosearch-btn").on("click", function () {
            const videosearchFields = $("#videosearch-fields");
            const index = videosearchFields.children().length;
            const today = new Date().toISOString().split('T')[0];
            const newVideosearchField = $(`
                <div class="videosearch-input margin-30">
                    <div class="videosearch-details">
                        <div class="list_form">
                            <span class="sec_label">Title</span>
                            <input type="text" name="title[${index}]" placeholder="Input Title" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Link</span>
                            <input type="text" name="link[${index}]" placeholder="Input Link" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Snippet</span>
                            <textarea name="snippet[${index}]" placeholder="Input Snippet" required></textarea>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Image Url</span>
                            <input type="text" name="imageUrl[${index}]" placeholder="Input Image Url" required>
                        </div>
                         <div class="list_form">
                            <span class="sec_label">Duration</span>
                            <input type="time" name="duration[${index}]" placeholder="Input Duration" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Source</span>
                            <input type="text" name="source[${index}]" placeholder="Input Source" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Channel</span>
                            <input type="text" name="channel[${index}]" placeholder="Input Channel" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Date</span>
                            <input type="date" name="date[${index}]" placeholder="Input Date" value="${today}" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Position</span>
                            <input type="number" min=0 name="position[${index}]" placeholder="Input Position" required>
                        </div>
                    </div>
                    <button type="button" class="remove-btn sec_botton btn_danger">Remove</button>
                </div>
            `);
            videosearchFields.append(newVideosearchField);
        });

        // Menghapus videosearch atau detail
        $("#videosearch-fields").on("click", ".remove-btn", function () {
            $(this).closest(".videosearch-input").remove();
        });
    });
</script>

@endsection
