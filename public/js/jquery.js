function confirmaAlert(mensaje, url) {
    if (confirm(mensaje)) {
        window.location.href = url;
    }
}

