// Lấy container để chứa các thẻ phòng
const roomContainer = document.getElementById("room-container");

// Lấy tất cả các nút tầng
const floorButtons = document.querySelectorAll(".floor-button");

// Hàm tạo các phòng dựa trên dữ liệu từ API
function createRooms(rooms) {
    // Xóa tất cả các phòng hiện có
    roomContainer.innerHTML = "";

    rooms.forEach(room => {
        // Tạo một thẻ phòng mới
        const card = document.createElement("div");
        card.classList.add("card");

        // Tạo header cho thẻ phòng
        const cardHeader = document.createElement("div");
        cardHeader.classList.add("card-header");

        const roomName = document.createElement("h2");
        roomName.textContent = `Phòng ${room.RoomNumber}`;
        cardHeader.appendChild(roomName);

        const roomStatus = document.createElement("span");
        roomStatus.classList.add("status");
        switch (room.RoomStatus) {
            case "Available":
                roomStatus.textContent = "Còn trống";
                break;
            case "Occupied":
                roomStatus.textContent = "Đã đặt";
                break;
            case "Maintenance":
                roomStatus.textContent = "Đang bảo trì";
                break;
            default:
                roomStatus.textContent = "Không xác định";
        }
        roomStatus.classList.add(room.RoomStatus.toLowerCase());
        cardHeader.appendChild(roomStatus);

        card.appendChild(cardHeader);

        // Tạo body cho thẻ phòng
        const cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        const roomPrice = document.createElement("p");
        roomPrice.innerHTML = `<strong>Giá tiền:</strong> ${room.Price || "N/A"}`;
        cardBody.appendChild(roomPrice);

        const roomType = document.createElement("p");
        roomType.innerHTML = `<strong>Loại phòng:</strong> ${room.RoomTypeName || "N/A"}`;
        cardBody.appendChild(roomType);

        card.appendChild(cardBody);

        // Thêm thẻ phòng vào container
        roomContainer.appendChild(card);
    });
}

// Hàm gọi API để lấy dữ liệu phòng dựa trên tầng
function fetchRooms(floor) {
    fetch(`Database/getRooms.php?FloorID=${floor}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => createRooms(data))
        .catch(error => console.error('Lỗi khi tải dữ liệu phòng:', error));
}

// Mặc định hiển thị phòng của tầng 1 khi trang được tải
fetchRooms(1);

// Thêm sự kiện click cho các nút tầng
floorButtons.forEach(button => {
    button.addEventListener("click", () => {
        const floor = parseInt(button.getAttribute("data-floor"));
        fetchRooms(floor);
    });
});
