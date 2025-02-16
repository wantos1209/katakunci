@extends('index')

@section('container')

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }} Form</h3>
            <span>Add Data</span>
        </div>
        <form action="/websearch/create" method="POST" enctype="multipart/form-data">
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
                <select class="js-example-basic-multiple" name="keyword_id[]" multiple="multiple">
                    @foreach ($dataKeyword as $keyword)
                    <option value={{ $keyword->id }} >{{ $keyword->key }}</option>
                @endforeach
                  </select>
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
    $(document).ready(function() {
      $('.js-example-basic-multiple').select2();

    //   var selectedValues = ['arwanatoto', 'Daftar Arwanatoto']; 
    //   $('.js-example-basic-multiple').val(selectedValues).trigger('change');
  });
</script>

@endsection
