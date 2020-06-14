Array.from(document.querySelectorAll('.delete')).forEach(deleteButton => {
    deleteButton.addEventListener('click', event => {
        event.preventDefault();
        if (confirm('Are you sure?')) {
            deleteButton.parentNode.submit();
        }
    });
});

Array.from(document.querySelectorAll('.post img')).forEach(img => {
    img.addEventListener('click', event => window.open(event.target.src, '_blank'));
});