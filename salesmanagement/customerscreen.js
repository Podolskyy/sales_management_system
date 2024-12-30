function toggleDrawer() {
    const drawer = document.getElementById('drawer');
    drawer.classList.toggle('open');
}

function addCustomer(event) {
    event.preventDefault();

    const name = document.getElementById("customer-name").value;
    const email = document.getElementById("customer-email").value;
    const address = document.getElementById("customer-address").value;

    const tableBody = document.getElementById("customer-list");
    const newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td>${name}</td>
        <td>${email}</td>
        <td>${address}</td>
        <td><button onclick="editCustomer(this)" class="button edit-button">Edit</button></td>
    `;

    tableBody.appendChild(newRow);

    alert("New customer added successfully!");

    // Reset the form
    document.getElementById("customer-form").reset();
}

function searchCustomer(event) {
    event.preventDefault();

    const searchInput = document.getElementById("search-input").value.toLowerCase();
    const rows = document.querySelectorAll("#customer-list tr");
    let found = false;

    rows.forEach((row) => {
        const nameCell = row.querySelector("td:first-child").textContent.toLowerCase();
        if (nameCell.includes(searchInput)) {
            row.style.display = "";
            found = true;
        } else {
            row.style.display = "none";
        }
    });

    const searchMessage = document.getElementById("search-message");
    searchMessage.textContent = found ? "" : "No customers found.";
}
