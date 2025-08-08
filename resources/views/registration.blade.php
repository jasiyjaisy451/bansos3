@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Registrasi Penerima Bansos</h2>
    <form id="verifyForm">
        @csrf
        <div class="mb-3">
            <label for="qr_code" class="form-label">Scan / Masukkan QR Code</label>
            <input type="text" name="qr_code" id="qr_code" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Cek QR</button>
    </form>

    <div id="result" class="mt-4" style="display: none;">
        <h4>Data Penerima</h4>
        <p><strong>Nama:</strong> <span id="child_name"></span></p>
        <p><strong>Nama Sekolah:</strong> <span id="school_name"></span></p>
        <p><strong>Alamat:</strong> <span id="address"></span></p>
        <button id="confirmBtn" class="btn btn-success">✅ Registrasikan</button>
    </div>
</div>

<script>
document.getElementById('verifyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    fetch('{{ route("registration.verify") }}', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('result').style.display = 'block';
            document.getElementById('child_name').textContent = data.recipient.child_name;
            document.getElementById('school_name').textContent = data.recipient.school_name;
            document.getElementById('address').textContent = data.recipient.address;

            document.getElementById('confirmBtn').onclick = function() {
                let formData = new FormData();
                formData.append('qr_code', document.getElementById('qr_code').value);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route("registration.confirm") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(resp => {
                    if (resp.success) {
                        alert('Registrasi Berhasil ✅');
                        location.reload();
                    } else {
                        alert(resp.error);
                    }
                });
            };
        } else {
            alert(data.error);
        }
    });
});
</script>
@endsection
