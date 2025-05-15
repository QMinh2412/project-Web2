// confirm delete provider
function confirmDeleteProvider (providerName, URL) {
    if (confirm(`Bạn có muốn xóa nhà cung cấp "${providerName}"?`)) {
        window.location.href = URL;
    }
}