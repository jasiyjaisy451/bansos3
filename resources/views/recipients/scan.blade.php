@extends('layouts.app')

@section('title', 'Scan QR Code')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Scan QR Code</h5>
            </div>
            <div class="card-body">
                <form id="qrForm">
                    <div class="mb-3">
                        <label for="qr_input" class="form-label">Masukkan Kode QR</label>
                        <input type="text" class="form-control" id="qr_input"
                               placeholder="Scan atau ketik kode QR di sini..." autofocus>
                        <small class="form-text text-muted">
                            Gunakan scanner atau ketik manual kode QR
                        </small>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Verifikasi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow" id="resultCard" style="display: none;">
            <div class="card-header">
                <h5 class="mb-0">Hasil Verifikasi</h5>
            </div>
            <div class="card-body" id="resultContent">
                <!-- Result will be loaded here -->
            </div>
        </div>
    </div>
</div>

<div class="row mt-4" id="distributionSection" style="display: none;">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="mb-0">Konfirmasi Penyaluran</h5>
            </div>
            <div class="card-body">
                <form id="distributionForm">
                    <input type="hidden" id="recipient_id" name="recipient_id">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i> Tandai Sudah Disalurkan
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let currentRecipient = null;

    $('#qr_input').on('input', function() {
        const value = $(this).val().trim();
        if (value.length > 5) {
            setTimeout(() => {
                if ($('#qr_input').val().trim() === value) {
                    $('#qrForm').submit();
                }
            }, 500);
        }
    });

    $('#qr_input').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#qrForm').submit();
        }
    });

    $('#qrForm').on('submit', function(e) {
        e.preventDefault();

        const qrCode = $('#qr_input').val().trim();
        if (!qrCode) {
            alert('Masukkan kode QR terlebih dahulu');
            return;
        }

        $('#resultContent').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memverifikasi...</div>');
        $('#resultCard').show();

        $.ajax({
            url: '{{ route("recipients.verify-qr") }}',
            method: 'POST',
            data: {
                qr_code: qrCode,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    currentRecipient = response.recipient;
                    displayRecipientInfo(response.recipient);
                    $('#distributionSection').show();
                    $('#recipient_id').val(response.recipient.id);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                $('#resultCard').show();
                $('#resultContent').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ${response.error || 'Terjadi kesalahan'}
                    </div>
                `);
                $('#distributionSection').hide();
                currentRecipient = null;
            }
        });
    });

    $('#distributionForm').on('submit', function(e) {
        e.preventDefault();

        const recipientId = $('#recipient_id').val();
        if (!recipientId) {
            alert('Data penerima tidak ditemukan');
            return;
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');

        const submitBtn = $('#distributionForm button[type="submit"]');
        const originalText = submitBtn.html();
        submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...').prop('disabled', true);

        $.ajax({
            url: `/recipients/${recipientId}/distribute`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    if (response.recipient) {
                        currentRecipient = response.recipient;
                        displayRecipientInfo(currentRecipient, true); // tampilkan PDF langsung
                    }
                    const successAlert = `
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    $('#resultContent').prepend(successAlert);
                } else {
                    alert(response.message || 'Terjadi kesalahan');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert(response?.message || 'Terjadi kesalahan saat memperbarui data');
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});

function displayRecipientInfo(recipient, showPdf = false) {
    const statusBadge = recipient.is_distributed
        ? '<span class="badge bg-success">Sudah Menerima</span>'
        : '<span class="badge bg-warning">Belum Menerima</span>';

    let pdfButton = '';
    if (showPdf || recipient.is_distributed) {
        pdfButton = `
            <div class="mt-3">
                <a href="/recipients/${recipient.id}/signature" class="btn btn-primary" target="_blank">
                    <i class="fas fa-file-pdf me-2"></i>Cetak PDF
                </a>
            </div>
        `;
    }

    $('#resultContent').html(`
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            QR Code valid!
        </div>

        <div class="recipient-info">
            <h6><strong>${recipient.child_name}</strong> ${statusBadge}</h6>
            <p class="mb-1"><strong>QR Code:</strong> ${recipient.qr_code}</p>
            <p class="mb-1"><strong>Nama Ayah:</strong> ${recipient.Ayah_name}</p>
            <p class="mb-1"><strong>Nama Ibu:</strong> ${recipient.Ibu_name}</p>
            <p class="mb-1"><strong>Sekolah:</strong> ${recipient.school_name} (${recipient.school_level})</p>
            <p class="mb-1"><strong>Kelas:</strong> ${recipient.class}</p>
        </div>
        ${pdfButton}
    `);

    $('#resultCard').show();
}

function resetForm() {
    $('#qr_input').val('').focus();
    $('#resultCard').hide();
    $('#distributionSection').hide();
    $('#distributionForm')[0].reset();
}
</script>
@endpush
