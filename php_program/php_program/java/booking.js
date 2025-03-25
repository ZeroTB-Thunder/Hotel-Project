document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".room-checkbox");
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateSelectedRooms);
    });
});

function updateSelectedRooms() {
    const checkboxes = document.querySelectorAll(".room-checkbox");
    let selectedRooms = [];
    let totalPrice = 0;

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedRooms.push(checkbox.getAttribute("data-room-number"));
            totalPrice += parseFloat(checkbox.closest("tr").querySelector("td:nth-child(6)").textContent.replace("$", ""));
        }
    });

    document.getElementById("selectedRoomsList").textContent = selectedRooms.length > 0 ? selectedRooms.join(", ") : "None";
    document.getElementById("totalPrice").textContent = "$" + totalPrice.toFixed(2);

    // Set the total price in the hidden input field
    document.getElementById("total_price").value = totalPrice.toFixed(2);
}
