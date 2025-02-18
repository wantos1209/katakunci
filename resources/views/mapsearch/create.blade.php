@extends('index')

@section('container')

<style>
    .button-left {
        width: "100%";
        display: flex;
        justify-content: flex-end;
        align-items: flex-end;
    }

    .mapsearch-input {
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

    .mapsearch-details {
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
        <form action="/mapsearch/create" method="POST" enctype="multipart/form-data">
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
                <div class="list_form button-left"><button type="button" id="add-mapsearch-btn" class="sec_botton btn_success">Add Data</button></div>
                <div id="mapsearch-fields">
                   
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit" id="" name="">Submit</button>
                <a href="/mapsearch"><button class="sec_botton btn_cancel" type="button">Cancel</button></a>
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
        // Menambahkan mapsearch baru
        $("#add-mapsearch-btn").on("click", function () {
            const mapsearchFields = $("#mapsearch-fields");
            const index = mapsearchFields.children().length;
            const newMapssearchField = $(`
                <div class="mapsearch-input margin-30">
                    <div class="mapsearch-details">
                        <div class="list_form">
                            <span class="sec_label">Title</span>
                            <input type="text" name="title[${index}]" placeholder="Input Title" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Address</span>
                            <input type="text" name="address[${index}]" placeholder="Input Address" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Latitude</span>
                            <input type="text" name="latitude[${index}]" placeholder="Input Latitude" required class="latitude">
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Longitude</span>
                            <input type="text" name="longitude[${index}]" placeholder="Input Longitude" required class="longitude">
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Rating</span>
                            <input type="number" name="rating[${index}]" step="0.1" placeholder="Input Rating" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Rating Count</span>
                            <input type="number" name="ratingCount[${index}]" placeholder="Input Rating Count" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Phone Number</span>
                            <input type="text" name="phoneNumber[${index}]" placeholder="Input Phone Number" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Category</span>
                            <input type="text" name="category[${index}]" placeholder="Input Category" required>
                        </div>
                         <div class="list_form">
                            <span class="sec_label">Website</span>
                            <input type="text" name="website[${index}]" placeholder="Input Website" required>
                        </div>
                        <div class="list_form">
                            <span class="sec_label">Position</span>
                            <input type="number" min=0 name="position[${index}]" placeholder="Input Position" value=${index + 1} required>
                        </div>
                    </div>
                    <button type="button" class="remove-btn sec_botton btn_danger">Remove</button
                </div>
            `);
            mapsearchFields.append(newMapssearchField);
        });

        $("#mapsearch-fields").on("click", ".remove-btn", function () {
            $(this).closest(".mapsearch-input").remove();
        });
        
       $(document).on("input", ".latitude, .longitude", function () {
            const value = $(this).val();
            if (!/^[-+]?[0-9]*\.?[0-9]+$/.test(value)) {
                $(this).val(value.slice(0, -1)); 
            }
            
            if ((value.match(/\./g) || []).length > 1) {
                $(this).val(value.slice(0, -1)); 
            }
        });
    });
</script>

@endsection
