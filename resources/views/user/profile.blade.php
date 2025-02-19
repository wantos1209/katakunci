@extends('index')

@section('container')

<div class="sec_box hgi-100">
    <div class="sec_form">
        <div class="sec_head_form">
            <h3>{{ $title }} Form</h3>
            <span>Add Data</span>
        </div>
        <form action="/profile" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="list_form">
                <span class="sec_label">Password</span>
                <input type="password" id="password" name="password" placeholder="Input Password (leave empty to keep current)">
            </div>
            <div class="list_form">
                <span class="sec_label">Confirm Password</span>
                <input type="password" id="cpassword" name="cpassword" placeholder="Input Confirm Password">
            </div>
            <div class="list_form">
                <span class="sec_label">Gambar</span>
                <div class="pilihan_gambar">
                    <input type="file" id="pathImage" name="pathImage">
                </div>
            </div>
            <div class="sec_button_form">
                <button class="sec_botton btn_submit" type="submit">Submit</button>
                <a href="/user"><button type="button" class="sec_botton btn_cancel">Cancel</button></a>
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
        $("form").submit(function (event) {
            var password = $("#password").val();
            var confirmPassword = $("#cpassword").val();

            if (password !== confirmPassword) {
                event.preventDefault(); 
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'The confirm password does not match the password.',
                    showConfirmButton: true,
                });
            }
        });
    });
</script>



@endsection
