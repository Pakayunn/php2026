$(document).ready(function() {
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 3000);
});

/**
 * Generic delete function with SweetAlert2
 * @param {string} url - Delete endpoint URL
 * @param {string} itemName - Name of item being deleted (for message)
 */
function deleteItem(url, itemName = 'item') {
    Swal.fire({
        title: 'Bạn có chắc chắn?',
        text: `${itemName} sẽ bị xóa vĩnh viễn!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Đang xử lý...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Make AJAX request
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thành công!',
                            text: response.message || 'Xóa thành công!',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi!',
                            text: response.message || 'Có lỗi xảy ra!'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra khi kết nối server!',
                        footer: `Error: ${error}`
                    });
                }
            });
        }
    });
}

/**
 * Confirm action with SweetAlert2
 * @param {string} title - Dialog title
 * @param {string} text - Dialog text
 * @param {function} callback - Callback function if confirmed
 */
function confirmAction(title, text, callback) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xác nhận',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed && typeof callback === 'function') {
            callback();
        }
    });
}

/**
 * Show success message
 * @param {string} message - Success message
 * @param {number} timer - Auto close timer (ms)
 */
function showSuccess(message, timer = 2000) {
    Swal.fire({
        icon: 'success',
        title: 'Thành công!',
        text: message,
        timer: timer,
        showConfirmButton: false
    });
}

/**
 * Show error message
 * @param {string} message - Error message
 */
function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Lỗi!',
        text: message
    });
}

/**
 * Show loading spinner
 * @param {string} message - Loading message
 */
function showLoading(message = 'Đang xử lý...') {
    Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

/**
 * Close Swal
 */
function closeLoading() {
    Swal.close();
}

/**
 * Format number to VND currency
 * @param {number} number - Number to format
 * @returns {string} Formatted currency string
 */
function formatCurrency(number) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(number);
}

/**
 * Validate image file
 * @param {File} file - File to validate
 * @param {number} maxSize - Max size in bytes (default 2MB)
 * @returns {object} {valid: boolean, error: string}
 */
function validateImage(file, maxSize = 2097152) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    
    if (!allowedTypes.includes(file.type)) {
        return {
            valid: false,
            error: 'Chỉ chấp nhận file JPG hoặc PNG!'
        };
    }
    
    if (file.size > maxSize) {
        const maxSizeMB = maxSize / 1048576;
        return {
            valid: false,
            error: `File quá lớn! Tối đa ${maxSizeMB}MB`
        };
    }
    
    return { valid: true, error: null };
}

/**
 * Preview image before upload
 * @param {HTMLInputElement} input - File input element
 * @param {string} previewId - ID of preview element
 */
function previewImageFile(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (!preview) {
        console.error(`Preview element #${previewId} not found`);
        return;
    }
    
    preview.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const validation = validateImage(file);
        
        if (!validation.valid) {
            showError(validation.error);
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <div class="mt-2">
                    <p class="text-muted small mb-1">Preview:</p>
                    <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                </div>
            `;
        };
        reader.readAsDataURL(file);
    }
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}