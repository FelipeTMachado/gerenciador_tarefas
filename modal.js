function showModal(message) {
    document.getElementById("modal-message").textContent = message;
    document.getElementById("myModal").style.display = "block";
}

function closeModal() {
    document.getElementById("myModal").style.display = "none";
}