import $ from "jquery";
$(function() {
    var $fileInput = $('#file-input');
    var $browseBtn = $('#browse-btn');
    var $uploadArea = $('#file-upload-area');
    var $dropZone = $('#file-drop-zone');
    var $preview = $('#preview');
    var $removeBtn = $('#remove-btn');
    var $fileError = $('#file-error');
    var MAX_SIZE = 10 * 1024 * 1024; // 10MB

    // Tipe gambar yang diperbolehkan (cek mime & ext)
    var allowedTypes = [
        'image/png',
        'image/jpeg',
        'image/gif',
        'image/avif'
    ];
    var allowedExts = [
        '.png', '.jpg', '.jpeg', '.gif', '.avif'
    ];

    $browseBtn.on('click', function(e) {
        e.preventDefault();
        $fileInput.click();
    });

    $uploadArea.on('dragenter dragover', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $uploadArea.addClass('bg-green-50 border-green-400');
    });
    $uploadArea.on('dragleave drop', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $uploadArea.removeClass('bg-green-50 border-green-400');
    });

    $uploadArea.on('drop', function(e) {
        var files = e.originalEvent.dataTransfer.files;
        if (files && files[0]) {
            handleFile(files[0]);
        }
    });

    $fileInput.on('change', function() {
        // Jika input file dikosongkan/cancel, hapus preview juga
        if (!this.files || this.files.length === 0) {
            resetFile();
            return;
        }
        if (this.files && this.files[0]) {
            handleFile(this.files[0]);
        }
    });

    function handleFile(file) {
        $fileError.addClass('hidden').text('');
        // Validasi type (MIME) atau ext (fallback untuk AVIF yg kadang tidak dikenali di browser lama)
        var typeOk = allowedTypes.includes(file.type);
        var extOk = allowedExts.some(function(ext) {
            return file.name.toLowerCase().endsWith(ext);
        });
        if (!typeOk && !extOk) {
            showError('File harus berupa gambar PNG, JPG, GIF, atau AVIF.');
            resetFile();
            return;
        }
        if (file.size > MAX_SIZE) {
            showError('Ukuran file maksimal 10MB.');
            resetFile();
            return;
        }
        showPreview(file);
    }

    function showPreview(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // check if the input file is not empty

            var $img = $('<img>')
                .addClass('w-full h-full object-contain rounded-lg select-none')
                .attr('src', e.target.result)
                .attr('alt', 'Preview');
            var $changeText = $('<span>')
                .text('Klik gambar untuk mengganti')
                .addClass('absolute bottom-3 left-1/2 -translate-x-1/2 text-xs text-white bg-black/40 px-2 py-1 rounded pointer-events-none z-20');
            $preview.html('').append($img).append($changeText).removeClass('hidden');
            $dropZone.hide();
            $removeBtn.removeClass('hidden');
        };
        reader.readAsDataURL(file);
    }

    $preview.on('click', function() {
        $fileInput.click();
    });

    $removeBtn.on('click', function(e) {
        e.preventDefault();
        resetFile();
    });

    function resetFile() {
        $fileInput.val('');
        $preview.addClass('hidden').html('');
        $dropZone.show();
        $removeBtn.addClass('hidden');
    }

    function showError(msg) {
        $fileError.text(msg).removeClass('hidden');
        setTimeout(function() {
            $fileError.addClass('hidden').text('');
        }, 3000);
    }

    $uploadArea.closest("form").on('reset', function(e){
        setTimeout(function() {
            resetFile();
        }, 10);
    });
});