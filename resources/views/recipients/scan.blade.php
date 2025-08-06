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
                <h5 class="mb-0">Penyaluran Barang</h5>
            </div>
            <div class="card-body">
                <form id="distributionForm">
                    <input type="hidden" id="recipient_id" name="recipient_id">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="uniform_received" name="uniform_received">
                                <label class="form-check-label" for="uniform_received">
                                    <i class="fas fa-tshirt me-2"></i>Seragam
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="shoes_received" name="shoes_received">
                                <label class="form-check-label" for="shoes_received">
                                    <i class="fas fa-shoe-prints me-2"></i>Sepatu
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="bag_received" name="bag_received">
                                <label class="form-check-label" for="bag_received">
                                    <i class="fas fa-briefcase me-2"></i>Tas
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check me-2"></i>Update Penyaluran
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="resetForm()">
                            <i class="fas fa-redo me-2"></i>Reset
                        </button>
                    </div>
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
    
    // Auto-submit when QR input changes (for scanner)
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
    
    // Handle Enter key
    $('#qr_input').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#qrForm').submit();
        }
    });

    // QR Verification Form
    $('#qrForm').on('submit', function(e) {
        e.preventDefault();
        
        const qrCode = $('#qr_input').val().trim();
        if (!qrCode) {
            alert('Masukkan kode QR terlebih dahulu');
            return;
        }
        
        // Show loading
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
                    
                    // Set current distribution status
                    $('#uniform_received').prop('checked', response.recipient.uniform_received);
                    $('#shoes_received').prop('checked', response.recipient.shoes_received);
                    $('#bag_received').prop('checked', response.recipient.bag_received);
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

    // Distribution Form
    $('#distributionForm').on('submit', function(e) {
        e.preventDefault();
        
        const recipientId = $('#recipient_id').val();
        if (!recipientId) {
            alert('Data penerima tidak ditemukan');
            return;
        }
        
        // Prepare form data with proper checkbox handling
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        
        if ($('#uniform_received').is(':checked')) {
            formData.append('uniform_received', '1');
        }
        if ($('#shoes_received').is(':checked')) {
            formData.append('shoes_received', '1');
        }
        if ($('#bag_received').is(':checked')) {
            formData.append('bag_received', '1');
        }
        
        // Show loading
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
                    // Update current recipient data
                    if (response.recipient) {
                        currentRecipient = response.recipient;
                        displayRecipientInfo(currentRecipient);
                    }
                    
                    // Show success message
                    const successAlert = `
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle me-2"></i>
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    `;
                    $('#resultContent').prepend(successAlert);
                    
                    if (response.is_fully_distributed) {
                        const completeAlert = `
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>Penyaluran Lengkap!</strong> Bukti penerimaan dapat dicetak.
                                <br><br>
                                <a href="/recipients/${recipientId}/receipt" class="btn btn-success me-2" target="_blank">
                                    <i class="fas fa-file-pdf me-1"></i>Cetak Bukti
                                </a>
                                <a href="/recipients/${recipientId}/signature" class="btn btn-warning" target="_blank">
                                    <i class="fas fa-signature me-1"></i>Form Tanda Tangan
                                </a>
                            </div>
                        `;
                        $('#resultContent').prepend(completeAlert);
                    }
                } else {
                    alert(response.message || 'Terjadi kesalahan');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                console.error('Error:', response);
                alert(response?.message || 'Terjadi kesalahan saat memperbarui data');
            },
            complete: function() {
                // Restore button
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });
});

function displayRecipientInfo(recipient) {
    const statusBadge = recipient.is_distributed 
        ? '<span class="badge bg-success">Sudah Menerima</span>'
        : '<span class="badge bg-warning">Belum Menerima</span>';

    const distributionItems = `
        <div class="row mt-3">
            <div class="col-4 text-center">
                <i class="fas fa-tshirt fa-2x ${recipient.uniform_received ? 'text-success' : 'text-muted'}"></i>
                <br><small>Seragam</small>
            </div>
            <div class="col-4 text-center">
                <i class="fas fa-shoe-prints fa-2x ${recipient.shoes_received ? 'text-success' : 'text-muted'}"></i>
                <br><small>Sepatu</small>
            </div>
            <div class="col-4 text-center">
                <i class="fas fa-briefcase fa-2x ${recipient.bag_received ? 'text-success' : 'text-muted'}"></i>
                <br><small>Tas</small>
            </div>
        </div>
    `;

    $('#resultContent').html(`
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            QR Code valid!
        </div>
        
        <div class="recipient-info">
            <h6><strong>${recipient.child_name}</strong> ${statusBadge}</h6>
            <p class="mb-1"><strong>QR Code:</strong> ${recipient.qr_code}</p>
            <p class="mb-1"><strong>Orang Tua:</strong> ${recipient.parent_name}</p>
            <p class="mb-1"><strong>Sekolah:</strong> ${recipient.school_name} (${recipient.school_level})</p>
            <p class="mb-1"><strong>Kelas:</strong> ${recipient.class}</p>
            <p class="mb-1"><strong>Ukuran:</strong> Sepatu ${recipient.shoe_size}, Baju ${recipient.shirt_size}</p>
            
            ${distributionItems}
        </div>
    `);
    
    $('#resultCard').show();
}

function resetForm() {
    $('#qr_input').val('').focus();
    $('#resultCard').hide();
    $('#distributionSection').hide();
    $('#distributionForm')[0].reset();
    currentRecipient = null;
}
</script>
@endpush